<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Compra #{{ $purchase->id }}
            </h2>
            <a href="{{ route('purchases.index') }}" class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6 mb-4">
                <h3 class="font-semibold text-lg mb-4">🏭 Proveedor</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <div class="text-gray-500">Nombre</div>
                        <div class="font-semibold">{{ $purchase->supplier->name }}</div>
                    </div>
                    @if($purchase->supplier->document)
                        <div>
                            <div class="text-gray-500">Documento</div>
                            <div class="font-semibold">{{ $purchase->supplier->document }}</div>
                        </div>
                    @endif
                    @if($purchase->invoice_number)
                        <div>
                            <div class="text-gray-500">N° Factura</div>
                            <div class="font-semibold">{{ $purchase->invoice_number }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <div class="text-sm uppercase opacity-90">Total Compra</div>
                    <div class="text-2xl font-bold mt-1">${{ number_format($purchase->total, 2) }}</div>
                </div>
                <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                    <div class="text-sm uppercase opacity-90">Pagado</div>
                    <div class="text-2xl font-bold mt-1">${{ number_format($purchase->paid_amount, 2) }}</div>
                </div>
                <div class="bg-red-500 text-white p-4 rounded-lg shadow">
                    <div class="text-sm uppercase opacity-90">Saldo</div>
                    <div class="text-2xl font-bold mt-1">${{ number_format($purchase->balance, 2) }}</div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden mb-4">
                <div class="p-4 border-b"><h3 class="font-semibold text-lg">📦 Productos</h3></div>
                <table class="w-full">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Producto</th>
                            <th class="px-4 py-2 text-left">Cantidad</th>
                            <th class="px-4 py-2 text-left">Costo Unit.</th>
                            <th class="px-4 py-2 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase->products as $product)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $product->name }}</td>
                                <td class="px-4 py-2">{{ $product->pivot->quantity }}</td>
                                <td class="px-4 py-2">${{ number_format($product->pivot->unit_cost, 2) }}</td>
                                <td class="px-4 py-2 font-semibold">${{ number_format($product->pivot->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4 border-b"><h3 class="font-semibold text-lg">💵 Historial de Pagos</h3></div>
                @if($purchase->payments->count() > 0)
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
                            @foreach($purchase->payments as $payment)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $payment->paid_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-2 font-semibold text-green-600">${{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($payment->payment_method) }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $payment->reference ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $payment->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center py-4 text-gray-500">Sin pagos registrados</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
