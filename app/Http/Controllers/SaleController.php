<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['products', 'client'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        $clients = \App\Models\Client::orderBy('name')->get();

        return view('sales.create', compact('products', 'clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'           => 'nullable|exists:clients,id',
            'payment_type'        => 'required|in:contado,credito',
            'due_date'            => 'required_if:payment_type,credito|nullable|date',
            'products'            => 'required|array|min:1',
            'products.*.id'       => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $isContado = $validated['payment_type'] === 'contado';

            $sale = Sale::create([
                'user_id'      => auth()->id(),
                'client_id'    => $validated['client_id'] ?? null,
                'total'        => 0,
                'payment_type' => $validated['payment_type'],
                'due_date'     => $validated['due_date'] ?? null,
                'paid_amount'  => 0,
            ]);

            $total = 0;

            foreach ($validated['products'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stock insuficiente para: {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $sale->products()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            $sale->update([
                'total'       => $total,
                'paid_amount' => $isContado ? $total : 0,
            ]);

            DB::commit();

            return redirect()
                ->route('sales.index')
                ->with('success', 'Venta registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error al registrar la venta: ' . $e->getMessage());
        }
    }
}