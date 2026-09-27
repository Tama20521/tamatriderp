<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mis Ventas
            </h2>
            <a href="{{ route('sales.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nueva Venta
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Fecha</th>
                            <th class="px-4 py-2 text-left">Productos</th>
                            <th class="px-4 py-2 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $sale->id }}</td>
                                <td class="px-4 py-2">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2">
                                    <ul class="list-disc list-inside text-sm">
                                        @foreach($sale->products as $product)
                                            <li>
                                                {{ $product->name }} 
                                                (x{{ $product->pivot->quantity }}) 
                                                — ${{ number_format($product->pivot->subtotal, 2) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-4 py-2 font-bold">
                                    ${{ number_format($sale->total, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">
                                    No hay ventas registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $sales->links() }}
            </div>

        </div>
    </div>
</x-app-layout>