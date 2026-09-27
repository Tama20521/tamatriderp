<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Métricas principales --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                
                {{-- Total de Ventas (cantidad) --}}
                <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Total de Ventas</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalVentas }}</p>
                    <p class="text-xs opacity-75 mt-1">transacciones</p>
                </div>

                {{-- Total Vendido (dinero) --}}
                <div class="bg-emerald-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Total Vendido</h3>
                    <p class="text-3xl font-bold mt-2">${{ number_format($totalVendido, 2) }}</p>
                    <p class="text-xs opacity-75 mt-1">ingresos totales</p>
                </div>

                {{-- Total de Productos (cantidad) --}}
                <div class="bg-green-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Total de Productos</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalProductos }}</p>
                    <p class="text-xs opacity-75 mt-1">en catálogo</p>
                </div>

                {{-- Valor del Inventario (dinero) --}}
                <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Valor Inventario</h3>
                    <p class="text-3xl font-bold mt-2">${{ number_format($valorInventario, 2) }}</p>
                    <p class="text-xs opacity-75 mt-1">stock × precio</p>
                </div>
            </div>

            {{-- Gráficos --}}
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
        // Gráfico de Ventas por Mes
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
                                return 'Ventas: $' + parseFloat(context.parsed.y).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Gráfico de Stock
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
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>