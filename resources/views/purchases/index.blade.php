<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Compras a Proveedores
            </h2>
            <a href="{{ route('purchases.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nueva Compra
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
                            <th class="px-4 py-2 text-left">Proveedor</th>
                            <th class="px-4 py-2 text-left">Factura</th>
                            <th class="px-4 py-2 text-left">Fecha</th>
                            <th class="px-4 py-2 text-left">Total</th>
                            <th class="px-4 py-2 text-left">Pago</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">#{{ $purchase->id }}</td>
                                <td class="px-4 py-2 font-semibold">{{ $purchase->supplier->name ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm">{{ $purchase->invoice_number ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm">{{ $purchase->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 font-semibold">${{ number_format($purchase->total, 2) }}</td>
                                <td class="px-4 py-2">
                                    @if($purchase->payment_type === 'contado')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">💵 Contado</span>
                                    @elseif($purchase->payment_status === 'paid')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">✅ Pagada</span>
                                    @elseif($purchase->payment_status === 'partial')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">⏳ Parcial</span>
                                    @elseif($purchase->is_overdue)
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">⚠️ Vencida</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">📅 Pendiente</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('purchases.show', $purchase) }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    No hay compras registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($purchases->hasPages())
                <div class="mt-4">{{ $purchases->links() }}</div>
            @endif

        </div>
    </div>
</x-app-layout>