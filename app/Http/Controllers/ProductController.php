<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'available') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock === 'unavailable') {
                $query->where('stock', '=', 0);
            }
        }

        $products = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('products.index', compact('products'));
    }

   public function create()
{
    $suppliers = \App\Models\Supplier::where('active', true)->orderBy('name')->get();
    return view('products.create', compact('suppliers'));
}

    public function store(Request $request)
    {
      $validated = $request->validate([
        'supplier_id' => 'nullable|exists:suppliers,id',
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
      ]);
        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
{
    $suppliers = \App\Models\Supplier::where('active', true)->orderBy('name')->get();
    return view('products.edit', compact('product', 'suppliers'));
}

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
       // Verificar si el producto tiene ventas asociadas
    if ($product->sales()->count() > 0) {
        return redirect()
            ->route('products.index')
            ->with('error', 'No se puede eliminar este producto porque tiene ventas registradas.');
    }

    $product->delete();

    return redirect()
        ->route('products.index')
        ->with('success', 'Producto eliminado correctamente.');
    }
}

