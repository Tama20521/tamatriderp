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
                            <th class="px-4 py-2 text-left">Cliente</th>
                            <th class="px-4 py-2 text-left">Productos</th>
                            <th class="px-4 py-2 text-left">Pago</th>
                            <th class="px-4 py-2 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $sale->id }}</td>
                                <td class="px-4 py-2">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2 text-sm">
    @if($sale->client)
        <span class="font-semibold">{{ $sale->client->name }}</span>
    @else
        <span class="text-gray-400 italic">Consumidor Final</span>
    @endif
</td>
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
                               <td class="px-4 py-2">
    @if($sale->payment_type === 'contado')
        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
            💵 Contado
        </span>
    @else
        @if($sale->payment_status === 'paid')
            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                ✅ Pagado
            </span>
        @elseif($sale->payment_status === 'partial')
            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">
                ⏳ Parcial
            </span>
        @else
            <span class="{{ $sale->is_overdue ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }} px-2 py-1 rounded text-xs">
                {{ $sale->is_overdue ? '⚠️ Vencido' : '📅 Pendiente' }}
            </span>
        @endif
    @endif
</td>
                                <td class="px-4 py-2 font-bold">
                                    ${{ number_format($sale->total, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">
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