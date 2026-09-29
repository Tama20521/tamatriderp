<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                💰 Detalle de Cuenta — Venta #{{ $sale->id }}
            </h2>
            <div class="flex gap-2">
                @if($sale->balance > 0)
                    <a href="{{ route('payments.create', $sale) }}"
                       class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">
                        💵 Registrar Abono
                    </a>
                @endif
                <a href="{{ route('payments.index') }}"
                   class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    ← Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Info del cliente --}}
            <div class="bg-white shadow rounded-lg p-6 mb-4">
                <h3 class="font-semibold text-lg mb-4">👤 Cliente</h3>
                @if($sale->client)
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="text-gray-500">Nombre</div>
                            <div class="font-semibold">{{ $sale->client->name }}</div>
                        </div>
                        @if($sale->client->document)
                            <div>
                                <div class="text-gray-500">Documento</div>
                                <div class="font-semibold">{{ $sale->client->document }}</div>
                            </div>
                        @endif
                        @if($sale->client->phone)
                            <div>
                                <div class="text-gray-500">Teléfono</div>
                                <div class="font-semibold">📞 {{ $sale->client->phone }}</div>
                            </div>
                        @endif
                        @if($sale->client->email)
                            <div>
                                <div class="text-gray-500">Email</div>
                                <div class="font-semibold">📧 {{ $sale->client->email }}</div>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-gray-500">Consumidor Final</p>
                @endif
            </div>

            {{-- Resumen financiero --}}
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <div class="text-sm uppercase opacity-90">Total Venta</div>
                    <div class="text-2xl font-bold mt-1">${{ number_format($sale->total, 2) }}</div>
                </div>
                <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                    <div class="text-sm uppercase opacity-90">Total Pagado</div>
                    <div class="text-2xl font-bold mt-1">${{ number_format($sale->paid_amount, 2) }}</div>
                </div>
                <div class="bg-red-500 text-white p-4 rounded-lg shadow">
                    <div class="text-sm uppercase opacity-90">Saldo Pendiente</div>
                    <div class="text-2xl font-bold mt-1">${{ number_format($sale->balance, 2) }}</div>
                </div>
            </div>

            {{-- Productos vendidos --}}
            <div class="bg-white shadow rounded-lg overflow-hidden mb-4">
                <div class="p-4 border-b">
                    <h3 class="font-semibold text-lg">📦 Productos</h3>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Producto</th>
                            <th class="px-4 py-2 text-left">Cantidad</th>
                            <th class="px-4 py-2 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->products as $product)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $product->name }}</td>
                                <td class="px-4 py-2">{{ $product->pivot->quantity }}</td>
                                <td class="px-4 py-2 font-semibold">${{ number_format($product->pivot->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Historial de abonos --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4 border-b">
                    <h3 class="font-semibold text-lg">📜 Historial de Abonos</h3>
                </div>
                @if($sale->payments->count() > 0)
                    <table class="w-full">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-4 py-2 text-left">Fecha</th>
                                <th class="px-4 py-2 text-left">Monto</th>
                                <th class="px-4 py-2 text-left">Método</th>
                                <th class="px-4 py-2 text-left">Referencia</th>
                                <th class="px-4 py-2 text-left">Registró</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->payments as $payment)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $payment->paid_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-2 font-semibold text-green-600">
                                        ${{ number_format($payment->amount, 2) }}
                                    </td>
                                    <td class="px-4 py-2">{{ ucfirst($payment->payment_method) }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $payment->reference ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $payment->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center py-4 text-gray-500">Sin abonos registrados</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>