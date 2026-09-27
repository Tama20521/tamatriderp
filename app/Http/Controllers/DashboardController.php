<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // ============ MÉTRICAS PRINCIPALES ============

        $totalVentas = Sale::where('user_id', $userId)->count();
        $totalProductos = Product::count();
        $totalVendido = Sale::where('user_id', $userId)->sum('total') ?? 0;

        $valorInventario = Product::selectRaw('SUM(price * stock) as total')
            ->value('total') ?? 0;

        // ============ NUEVAS MÉTRICAS ============

        // Ventas de hoy
        $ventasHoy = Sale::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->sum('total') ?? 0;

        // Ticket promedio
        $ticketPromedio = $totalVentas > 0 
            ? $totalVendido / $totalVentas 
            : 0;

        // Top 5 productos más vendidos
        $topProductos = DB::table('product_sale')
            ->join('products', 'product_sale.product_id', '=', 'products.id')
            ->join('sales', 'product_sale.sale_id', '=', 'sales.id')
            ->where('sales.user_id', $userId)
            ->select(
                'products.name',
                DB::raw('SUM(product_sale.quantity) as total_vendido'),
                DB::raw('SUM(product_sale.subtotal) as total_ingresos')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        // Productos con stock bajo (≤ 5)
        $stockBajo = Product::where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->get();

        // Productos agotados
        $agotados = Product::where('stock', 0)->count();

        // Ventas de los últimos 7 días
        $ventasSemana = Sale::selectRaw('DATE(created_at) as dia, SUM(total) as total')
            ->where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        // Rellenar los días sin ventas
        $diasSemana = [];
        $labels7Dias = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = now()->subDays($i)->format('Y-m-d');
            $labels7Dias[] = now()->subDays($i)->translatedFormat('D d/m');
            $ventaDia = $ventasSemana->firstWhere('dia', $fecha);
            $diasSemana[] = $ventaDia ? $ventaDia->total : 0;
        }

        // ============ DATOS PARA GRÁFICOS EXISTENTES ============

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
            'valorInventario',
            'ventasHoy',
            'ticketPromedio',
            'topProductos',
            'stockBajo',
            'agotados',
            'labels7Dias',
            'diasSemana'
        ));
    }
}