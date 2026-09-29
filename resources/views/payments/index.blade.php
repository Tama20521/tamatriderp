<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💰 Cuentas por Cobrar
        </h2>
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

            {{-- Métricas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Total por Cobrar</h3>
                    <p class="text-2xl font-bold mt-2">${{ number_format($totalPorCobrar, 2) }}</p>
                </div>
                <div class="bg-red-500 text-white p-4 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Total Vencido</h3>
                    <p class="text-2xl font-bold mt-2">${{ number_format($totalVencido, 2) }}</p>
                </div>
                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow">
                    <h3 class="text-sm font-semibold uppercase opacity-90">Facturas Pendientes</h3>
                    <p class="text-2xl font-bold mt-2">{{ $cantidadPendientes }}</p>
                </div>
            </div>

            {{-- Filtros --}}
            <form method="GET" action="{{ route('payments.index') }}" 
                  class="bg-white p-4 rounded-lg shadow mb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
                <input type="text" name="search" placeholder="Buscar cliente..." 
                       value="{{ request('search') }}"
                       class="border rounded px-3 py-2 md:col-span-2">
                <div class="flex gap-2">
                    <select name="status" class="border rounded px-3 py-2 flex-1">
                        <option value="">-- Estado --</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="partial" {{ request('status') === 'partial' ? 'selected' : '' }}>Parcial</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Pagado</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Vencido</option>
                    </select>
                    <button type="submit" class="bg-gray-700 hover:bg-gray-900 text-white px-4 py-2 rounded">
                        Filtrar
                    </button>
                </div>
            </form>

            {{-- Tabla --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Cliente</th>
                            <th class="px-4 py-2 text-left">Fecha</th>
                            <th class="px-4 py-2 text-left">Vence</th>
                            <th class="px-4 py-2 text-left">Total</th>
                            <th class="px-4 py-2 text-left">Pagado</th>
                            <th class="px-4 py-2 text-left">Saldo</th>
                            <th class="px-4 py-2 text-left">Estado</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">#{{ $sale->id }}</td>
                                <td class="px-4 py-2">
                                    <div class="font-semibold">{{ $sale->client->name ?? 'Consumidor Final' }}</div>
                                    @if($sale->client && $sale->client->document)
                                        <div class="text-xs text-gray-500">{{ $sale->client->document }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm">{{ $sale->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-sm">
                                    @if($sale->due_date)
                                        <span class="{{ $sale->is_overdue ? 'text-red-600 font-semibold' : '' }}">
                                            {{ $sale->due_date->format('d/m/Y') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-2 font-semibold">${{ number_format($sale->total, 2) }}</td>
                                <td class="px-4 py-2 text-green-600">${{ number_format($sale->paid_amount, 2) }}</td>
                                <td class="px-4 py-2 font-bold text-red-600">${{ number_format($sale->balance, 2) }}</td>
                                <td class="px-4 py-2">
                                    @if($sale->payment_status === 'paid')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">✅ Pagado</span>
                                    @elseif($sale->payment_status === 'partial')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">⏳ Parcial</span>
                                    @elseif($sale->is_overdue)
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">⚠️ Vencido</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-semibold">📅 Pendiente</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('payments.show', $sale) }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white px-2 py-1 rounded text-xs">
                                        Ver
                                    </a>
                                    @if($sale->balance > 0)
                                        <a href="{{ route('payments.create', $sale) }}"
                                           class="bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">
                                            💵 Abonar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-gray-500">
                                    No hay cuentas por cobrar registradas
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