<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // ============ MÉTRICAS ============
        
        // 1. Cantidad total de ventas (número)
        $totalVentas = Sale::where('user_id', $userId)->count();

        // 2. Cantidad total de productos (número)
        $totalProductos = Product::count();

        // 3. Total vendido en dinero ($)
        $totalVendido = Sale::where('user_id', $userId)->sum('total') ?? 0;

        // 4. Valor del inventario disponible ($)
        // Suma de (precio × stock) de todos los productos
        $valorInventario = Product::selectRaw('SUM(price * stock) as total')
            ->value('total') ?? 0;

        // ============ GRÁFICOS ============

        // Ventas por mes
        $ventasMes = Sale::selectRaw('MONTH(created_at) as mes, SUM(total) as total')
            ->where('user_id', $userId)
            ->whereYear('created_at', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $ventasData = [
            'labels' => $ventasMes->pluck('mes')->map(function ($m) {
                return now()->setMonth($m)->translatedFormat('F');
            }),
            'data' => $ventasMes->pluck('total'),
        ];

        // Stock de productos
        $productos = Product::orderBy('name')->get();

        $productosData = [
            'labels' => $productos->pluck('name'),
            'data' => $productos->pluck('stock'),
        ];

        return view('dashboard', compact(
            'ventasData',
            'productosData',
            'totalVentas',
            'totalProductos',
            'totalVendido',
            'valorInventario'
        ));
    }
}
