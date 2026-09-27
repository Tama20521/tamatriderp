<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ============ FILA 1: 4 Métricas principales ============ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Total de Ventas</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalVentas }}</p>
                    <p class="text-xs opacity-75 mt-1">transacciones</p>
                </div>

                <div class="bg-emerald-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Total Vendido</h3>
                    <p class="text-3xl font-bold mt-2">${{ number_format($totalVendido, 2) }}</p>
                    <p class="text-xs opacity-75 mt-1">ingresos totales</p>
                </div>

                <div class="bg-green-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Total de Productos</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalProductos }}</p>
                    <p class="text-xs opacity-75 mt-1">en catálogo</p>
                </div>

                <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Valor Inventario</h3>
                    <p class="text-3xl font-bold mt-2">${{ number_format($valorInventario, 2) }}</p>
                    <p class="text-xs opacity-75 mt-1">stock × precio</p>
                </div>
            </div>

            {{-- ============ FILA 2: 3 Métricas nuevas ============ --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                <div class="bg-cyan-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Ventas de Hoy</h3>
                    <p class="text-3xl font-bold mt-2">${{ number_format($ventasHoy, 2) }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ now()->translatedFormat('d \d\e F, Y') }}</p>
                </div>

                <div class="bg-indigo-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Ticket Promedio</h3>
                    <p class="text-3xl font-bold mt-2">${{ number_format($ticketPromedio, 2) }}</p>
                    <p class="text-xs opacity-75 mt-1">por transacción</p>
                </div>

                <div class="{{ $agotados > 0 ? 'bg-red-500' : 'bg-teal-500' }} text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Productos Agotados</h3>
                    <p class="text-3xl font-bold mt-2">{{ $agotados }}</p>
                    <p class="text-xs opacity-75 mt-1">
                        {{ $agotados > 0 ? '¡Necesitan reabastecerse!' : 'Todo en stock' }}
                    </p>
                </div>
            </div>

            {{-- ============ FILA 3: Gráfico 7 días + Top Productos ============ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">

                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="font-semibold mb-3">Ventas últimos 7 días</h3>
                    <canvas id="semanaChart" height="120"></canvas>
                </div>

                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="font-semibold mb-3">🏆 Top 5 Productos Más Vendidos</h3>
                    @if($topProductos->isEmpty())
                        <p class="text-gray-500 text-sm text-center py-8">
                            Aún no hay ventas registradas
                        </p>
                    @else
                        <table class="w-full text-sm">
                            <thead class="border-b">
                                <tr class="text-left text-gray-600">
                                    <th class="py-2">#</th>
                                    <th class="py-2">Producto</th>
                                    <th class="py-2 text-right">Vendidos</th>
                                    <th class="py-2 text-right">Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProductos as $i => $prod)
                                    <tr class="border-b">
                                        <td class="py-2 font-bold 
                                            {{ $i === 0 ? 'text-yellow-500' : '' }}
                                            {{ $i === 1 ? 'text-gray-400' : '' }}
                                            {{ $i === 2 ? 'text-orange-600' : '' }}">
                                            {{ $i + 1 }}
                                        </td>
                                        <td class="py-2">{{ $prod->name }}</td>
                                        <td class="py-2 text-right font-semibold">
                                            {{ $prod->total_vendido }}
                                        </td>
                                        <td class="py-2 text-right text-emerald-600 font-semibold">
                                            ${{ number_format($prod->total_ingresos, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            {{-- ============ FILA 4: Alerta de Stock Bajo ============ --}}
            @if($stockBajo->count() > 0)
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg shadow mb-6">
                    <div class="flex items-center mb-3">
                        <span class="text-2xl mr-2">⚠️</span>
                        <h3 class="font-semibold text-yellow-800">
                            Productos con Stock Bajo ({{ $stockBajo->count() }})
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach($stockBajo as $producto)
                            <div class="bg-white rounded p-2 flex justify-between items-center">
                                <span class="text-sm">{{ $producto->name }}</span>
                                <span class="bg-yellow-500 text-white px-2 py-1 rounded text-xs font-bold">
                                    {{ $producto->stock }} unidades
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('products.index') }}" 
                           class="text-yellow-700 underline text-sm font-semibold">
                            Ver todos los productos →
                        </a>
                    </div>
                </div>
            @endif

            {{-- ============ FILA 5: Gráficos originales ============ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="font-semibold mb-3">Ventas por Mes</h3>
                    <canvas id="ventasChart"></canvas>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="font-semibold mb-3">Stock de Productos</h3>
                    <canvas id="productosChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ===== Gráfico Ventas últimos 7 días =====
        const semanaCtx = document.getElementById('semanaChart').getContext('2d');
        new Chart(semanaCtx, {
            type: 'line',
            data: {
                labels: @json($labels7Dias),
                datasets: [{
                    label: 'Ventas del día',
                    data: @json($diasSemana),
                    borderColor: 'rgba(99, 102, 241, 1)',
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Ventas: $' + parseFloat(context.parsed.y).toLocaleString('es-ES', {minimumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: v => '$' + v.toLocaleString() }
                    }
                }
            }
        });

        // ===== Gráfico Ventas por Mes =====
        const ventasCtx = document.getElementById('ventasChart').getContext('2d');
        new Chart(ventasCtx, {
            type: 'line',
            data: {
                labels: @json($ventasData['labels']),
                datasets: [{
                    label: 'Ventas por Mes',
                    data: @json($ventasData['data']),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Ventas: $' + parseFloat(context.parsed.y).toLocaleString('es-ES', {minimumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: v => '$' + v.toLocaleString() }
                    }
                }
            }
        });

        // ===== Gráfico Stock =====
        const productosCtx = document.getElementById('productosChart').getContext('2d');
        new Chart(productosCtx, {
            type: 'bar',
            data: {
                labels: @json($productosData['labels']),
                datasets: [{
                    label: 'Stock disponible',
                    data: @json($productosData['data']),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</x-app-layout>
