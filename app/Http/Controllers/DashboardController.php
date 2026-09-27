<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

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

        // Métricas rápidas
        $totalVentas = Sale::where('user_id', $userId)->count();
        $totalProductos = Product::count();

        return view('dashboard', compact(
            'ventasData',
            'productosData',
            'totalVentas',
            'totalProductos'
        ));
    }
}
