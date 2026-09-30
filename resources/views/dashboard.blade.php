<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">📊 Dashboard</h2>
                <p class="text-sm text-gray-500 mt-1">Resumen de tu negocio en tiempo real</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">{{ now()->translatedFormat('l, d \d\e F \d\e Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ===== FILA 1: Tarjetas principales ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

                {{-- Total Ventas --}}
                <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold bg-white/20 text-white px-2 py-1 rounded-full">Total</span>
                        </div>
                        <p class="text-white/80 text-sm font-medium">Total de Ventas</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $totalVentas }}</p>
                        <p class="text-white/70 text-xs mt-1">transacciones</p>
                    </div>
                </div>

                {{-- Total Vendido --}}
                <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold bg-white/20 text-white px-2 py-1 rounded-full">Ingresos</span>
                        </div>
                        <p class="text-white/80 text-sm font-medium">Total Vendido</p>
                        <p class="text-white text-3xl font-bold mt-1">${{ number_format($totalVendido, 2) }}</p>
                        <p class="text-white/70 text-xs mt-1">ingresos totales</p>
                    </div>
                </div>

                {{-- Total Productos --}}
                <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold bg-white/20 text-white px-2 py-1 rounded-full">Catálogo</span>
                        </div>
                        <p class="text-white/80 text-sm font-medium">Total Productos</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $totalProductos }}</p>
                        <p class="text-white/70 text-xs mt-1">en inventario</p>
                    </div>
                </div>

                {{-- Valor Inventario --}}
                <div class="group relative overflow-hidden bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold bg-white/20 text-white px-2 py-1 rounded-full">Valor</span>
                        </div>
                        <p class="text-white/80 text-sm font-medium">Valor Inventario</p>
                        <p class="text-white text-3xl font-bold mt-1">${{ number_format($valorInventario, 2) }}</p>
                        <p class="text-white/70 text-xs mt-1">stock × precio</p>
                    </div>
                </div>
            </div>

            {{-- ===== FILA 2: Tarjetas secundarias ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

                {{-- Ventas de Hoy --}}
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-cyan-600 bg-cyan-50 px-2 py-1 rounded-full">Hoy</span>
                    </div>
                    <p class="text-gray-500 text-sm">Ventas de Hoy</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">${{ number_format($ventasHoy, 2) }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ now()->translatedFormat('d \d\e F') }}</p>
                </div>

                {{-- Ticket Promedio --}}
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">Promedio</span>
                    </div>
                    <p class="text-gray-500 text-sm">Ticket Promedio</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">${{ number_format($ticketPromedio, 2) }}</p>
                    <p class="text-xs text-gray-400 mt-1">por transacción</p>
                </div>

                {{-- Productos Agotados --}}
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 {{ $agotados > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $agotados > 0 ? 'text-red-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold {{ $agotados > 0 ? 'text-red-600 bg-red-50' : 'text-green-600 bg-green-50' }} px-2 py-1 rounded-full">
                            {{ $agotados > 0 ? 'Atención' : 'OK' }}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm">Productos Agotados</p>
                    <p class="text-2xl font-bold {{ $agotados > 0 ? 'text-red-600' : 'text-gray-800' }} mt-1">{{ $agotados }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $agotados > 0 ? 'Necesitan reabastecerse' : 'Todo en stock' }}</p>
                </div>
            </div>

            {{-- ===== FILA 3: Gráficos + Top productos ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

                {{-- Gráfico 7 días --}}
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800">📈 Ventas últimos 7 días</h3>
                    </div>
                    <canvas id="semanaChart" height="140"></canvas>
                </div>

                {{-- Top 5 Productos --}}
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800">🏆 Top 5 Productos</h3>
                    </div>
                    @if($topProductos->isEmpty())
                        <p class="text-gray-400 text-sm text-center py-8">Aún no hay ventas registradas</p>
                    @else
                        <div class="space-y-3">
                            @foreach($topProductos as $i => $prod)
                                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-all">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-white
                                        {{ $i === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : '' }}
                                        {{ $i === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500' : '' }}
                                        {{ $i === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : '' }}
                                        {{ $i >= 3 ? 'bg-gray-200 text-gray-700' : '' }}">
                                        {{ $i + 1 }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $prod->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $prod->total_vendido }} vendidos</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-emerald-600">${{ number_format($prod->total_ingresos, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- ===== FILA 4: Alerta de Stock Bajo ===== --}}
            @if($stockBajo->count() > 0)
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 p-5 rounded-2xl shadow-md mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-yellow-800">Productos con Stock Bajo</h3>
                                <p class="text-xs text-yellow-700">{{ $stockBajo->count() }} productos necesitan reabastecerse</p>
                            </div>
                        </div>
                        <a href="{{ route('products.index') }}" class="text-yellow-700 hover:text-yellow-900 text-sm font-semibold">
                            Ver todos →
                        </a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($stockBajo as $producto)
                            <div class="bg-white rounded-xl p-3 flex items-center justify-between shadow-sm">
                                <span class="text-sm text-gray-700 truncate">{{ $producto->name }}</span>
                                <span class="bg-yellow-500 text-white px-2 py-0.5 rounded-full text-xs font-bold">
                                    {{ $producto->stock }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ===== FILA 5: Gráficos principales ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">📊 Ventas por Mes</h3>
                    <canvas id="ventasChart"></canvas>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">📦 Stock de Productos</h3>
                    <canvas id="productosChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const fontFamily = 'Figtree, system-ui, sans-serif';

        // Gráfico Ventas últimos 7 días
        new Chart(document.getElementById('semanaChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($labels7Dias),
                datasets: [{
                    label: 'Ventas del día',
                    data: @json($diasSemana),
                    borderColor: 'rgba(99, 102, 241, 1)',
                    backgroundColor: 'rgba(99, 102, 241, 0.15)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: { family: fontFamily, size: 13 },
                        bodyFont: { family: fontFamily, size: 12 },
                        callbacks: {
                            label: (ctx) => '$' + parseFloat(ctx.parsed.y).toLocaleString('es-ES', {minimumFractionDigits: 2})
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { font: { family: fontFamily }, callback: v => '$' + v.toLocaleString() }
                    },
                    x: { grid: { display: false }, ticks: { font: { family: fontFamily } } }
                }
            }
        });

        // Gráfico Ventas por Mes
        new Chart(document.getElementById('ventasChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($ventasData['labels']),
                datasets: [{
                    label: 'Ventas por Mes',
                    data: @json($ventasData['data']),
                    borderColor: 'rgba(16, 185, 129, 1)',
                    backgroundColor: 'rgba(16, 185, 129, 0.15)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        callbacks: {
                            label: (ctx) => '$' + parseFloat(ctx.parsed.y).toLocaleString('es-ES', {minimumFractionDigits: 2})
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { callback: v => '$' + v.toLocaleString() } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Gráfico Stock
        new Chart(document.getElementById('productosChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($productosData['labels']),
                datasets: [{
                    label: 'Stock disponible',
                    data: @json($productosData['data']),
                    backgroundColor: (ctx) => {
                        const v = ctx.parsed.y;
                        if (v === 0) return 'rgba(239, 68, 68, 0.7)';
                        if (v <= 5) return 'rgba(245, 158, 11, 0.7)';
                        return 'rgba(59, 130, 246, 0.7)';
                    },
                    borderColor: (ctx) => {
                        const v = ctx.parsed.y;
                        if (v === 0) return 'rgba(239, 68, 68, 1)';
                        if (v <= 5) return 'rgba(245, 158, 11, 1)';
                        return 'rgba(59, 130, 246, 1)';
                    },
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</x-app-layout>