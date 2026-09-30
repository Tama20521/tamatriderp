<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'user'])
            ->latest()
            ->paginate(10);

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::where('active', true)->orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id'          => 'required|exists:suppliers,id',
            'invoice_number'       => 'nullable|string|max:255',
            'payment_type'         => 'required|in:contado,credito',
            'due_date'             => 'required_if:payment_type,credito|nullable|date',
            'notes'                => 'nullable|string',
            'products'             => 'required|array|min:1',
            'products.*.id'        => 'required|exists:products,id',
            'products.*.quantity'  => 'required|integer|min:1',
            'products.*.unit_cost' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $isContado = $validated['payment_type'] === 'contado';

            $purchase = Purchase::create([
                'supplier_id'    => $validated['supplier_id'],
                'user_id'        => auth()->id(),
                'invoice_number' => $validated['invoice_number'] ?? null,
                'total'          => 0,
                'payment_type'   => $validated['payment_type'],
                'due_date'       => $validated['due_date'] ?? null,
                'paid_amount'    => 0,
                'notes'          => $validated['notes'] ?? null,
            ]);

            $total = 0;

            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['id']);

                $subtotal = $item['unit_cost'] * $item['quantity'];
                $total += $subtotal;

                $purchase->products()->attach($product->id, [
                    'quantity'  => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal'  => $subtotal,
                ]);

                // Aumentar stock
                $product->increment('stock', $item['quantity']);
            }

            $purchase->update([
                'total'       => $total,
                'paid_amount' => $isContado ? $total : 0,
            ]);

            DB::commit();

            return redirect()
                ->route('purchases.index')
                ->with('success', 'Compra registrada correctamente. El stock ha sido actualizado.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error al registrar la compra: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'products', 'payments.user']);
        return view('purchases.show', compact('purchase'));
    }
}