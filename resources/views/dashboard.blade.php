<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Total de Ventas</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalVentas }}</p>
                </div>
                <div class="bg-green-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Total de Productos</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalProductos }}</p>
                </div>
            </div>

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
            }
        });

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
            }
        });
    </script>
</x-app-layout>
