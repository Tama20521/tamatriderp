<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'user'])
            ->where('payment_type', 'credito');

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('paid_amount', 0)->whereColumn('paid_amount', '<', 'total');
            } elseif ($request->status === 'partial') {
                $query->where('paid_amount', '>', 0)->whereColumn('paid_amount', '<', 'total');
            } elseif ($request->status === 'paid') {
                $query->whereColumn('paid_amount', '>=', 'total');
            } elseif ($request->status === 'overdue') {
                $query->whereColumn('paid_amount', '<', 'total')
                      ->whereNotNull('due_date')
                      ->whereDate('due_date', '<', now());
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('supplier', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('document', 'like', "%{$search}%");
            });
        }

        $purchases = $query->latest()->paginate(15)->withQueryString();

        $totalPorPagar = Purchase::where('payment_type', 'credito')
            ->whereColumn('paid_amount', '<', 'total')
            ->sum(DB::raw('total - paid_amount'));

        $totalVencido = Purchase::where('payment_type', 'credito')
            ->whereColumn('paid_amount', '<', 'total')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now())
            ->sum(DB::raw('total - paid_amount'));

        $cantidadPendientes = Purchase::where('payment_type', 'credito')
            ->whereColumn('paid_amount', '<', 'total')
            ->count();

        return view('supplier_payments.index', compact(
            'purchases',
            'totalPorPagar',
            'totalVencido',
            'cantidadPendientes'
        ));
    }

    public function create(Purchase $purchase)
    {
        if ($purchase->payment_type !== 'credito') {
            return redirect()->route('supplier_payments.index')
                ->with('error', 'Esta compra no es a crédito.');
        }

        if ($purchase->balance <= 0) {
            return redirect()->route('supplier_payments.index')
                ->with('error', 'Esta compra ya está pagada completamente.');
        }

        $payments = $purchase->payments()->with('user')->latest()->get();

        return view('supplier_payments.create', compact('purchase', 'payments'));
    }

    public function store(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'amount'         => 'required|numeric|min:0.01|max:' . $purchase->balance,
            'payment_method' => 'required|in:efectivo,transferencia,cheque,tarjeta,otro',
            'reference'      => 'nullable|string|max:255',
            'notes'          => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            SupplierPayment::create([
                'purchase_id'    => $purchase->id,
                'user_id'        => auth()->id(),
                'amount'         => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'reference'      => $validated['reference'] ?? null,
                'notes'          => $validated['notes'] ?? null,
                'paid_at'        => now(),
            ]);

            $purchase->increment('paid_amount', $validated['amount']);

            DB::commit();

            return redirect()
                ->route('supplier_payments.index')
                ->with('success', 'Pago registrado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error al registrar el pago: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'products', 'payments.user']);
        return view('supplier_payments.show', compact('purchase'));
    }
}