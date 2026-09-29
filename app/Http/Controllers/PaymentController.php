<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Listado de cuentas por cobrar
     */
    public function index(Request $request)
    {
        $query = Sale::with(['client', 'user'])
            ->where('payment_type', 'credito');

        // Filtro por estado
        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('paid_amount', 0)->whereColumn('paid_amount', '<', 'total');
            } elseif ($request->status === 'partial') {
                $query->where('paid_amount', '>', 0)
                      ->whereColumn('paid_amount', '<', 'total');
            } elseif ($request->status === 'paid') {
                $query->whereColumn('paid_amount', '>=', 'total');
            } elseif ($request->status === 'overdue') {
                $query->whereColumn('paid_amount', '<', 'total')
                      ->whereNotNull('due_date')
                      ->whereDate('due_date', '<', now());
            }
        }

        // Búsqueda por cliente
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('document', 'like', "%{$search}%");
            });
        }

        $sales = $query->latest()->paginate(15)->withQueryString();

        // Métricas
        $totalPorCobrar = Sale::where('payment_type', 'credito')
            ->whereColumn('paid_amount', '<', 'total')
            ->sum(DB::raw('total - paid_amount'));

        $totalVencido = Sale::where('payment_type', 'credito')
            ->whereColumn('paid_amount', '<', 'total')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now())
            ->sum(DB::raw('total - paid_amount'));

        $cantidadPendientes = Sale::where('payment_type', 'credito')
            ->whereColumn('paid_amount', '<', 'total')
            ->count();

        return view('payments.index', compact(
            'sales',
            'totalPorCobrar',
            'totalVencido',
            'cantidadPendientes'
        ));
    }

    /**
     * Formulario para registrar abono a una venta
     */
    public function create(Sale $sale)
    {
        if ($sale->payment_type !== 'credito') {
            return redirect()
                ->route('payments.index')
                ->with('error', 'Esta venta no es a crédito.');
        }

        if ($sale->balance <= 0) {
            return redirect()
                ->route('payments.index')
                ->with('error', 'Esta venta ya está pagada completamente.');
        }

        $payments = $sale->payments()->with('user')->latest()->get();

        return view('payments.create', compact('sale', 'payments'));
    }

    /**
     * Guardar el abono
     */
    public function store(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'amount'         => 'required|numeric|min:0.01|max:' . $sale->balance,
            'payment_method' => 'required|in:efectivo,transferencia,cheque,tarjeta,otro',
            'reference'      => 'nullable|string|max:255',
            'notes'          => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            Payment::create([
                'sale_id'        => $sale->id,
                'user_id'        => auth()->id(),
                'amount'         => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'reference'      => $validated['reference'] ?? null,
                'notes'          => $validated['notes'] ?? null,
                'paid_at'        => now(),
            ]);

            $sale->increment('paid_amount', $validated['amount']);

            DB::commit();

            return redirect()
                ->route('payments.index')
                ->with('success', 'Abono registrado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error al registrar el abono: ' . $e->getMessage());
        }
    }

    /**
     * Historial de abonos de una venta
     */
    public function show(Sale $sale)
    {
        $sale->load(['client', 'user', 'products', 'payments.user']);
        return view('payments.show', compact('sale'));
    }
}