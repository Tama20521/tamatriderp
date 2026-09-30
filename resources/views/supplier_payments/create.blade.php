<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💵 Registrar Pago — Compra #{{ $purchase->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6 mb-4">
                <h3 class="font-semibold text-lg mb-4">Información de la Compra</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <div class="text-gray-500">Proveedor</div>
                        <div class="font-semibold">{{ $purchase->supplier->name }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Factura</div>
                        <div class="font-semibold">{{ $purchase->invoice_number ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Vencimiento</div>
                        <div class="font-semibold">
                            {{ $purchase->due_date ? $purchase->due_date->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                    <div>
                        <div class="text-gray-500">Estado</div>
                        <div class="font-semibold">
                            @if($purchase->is_overdue)
                                <span class="text-red-600">⚠️ Vencido</span>
                            @else
                                <span class="text-yellow-600">⏳ Pendiente</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t">
                    <div>
                        <div class="text-gray-500 text-sm">Total</div>
                        <div class="text-xl font-bold">${{ number_format($purchase->total, 2) }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm">Pagado</div>
                        <div class="text-xl font-bold text-green-600">${{ number_format($purchase->paid_amount, 2) }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm">Saldo</div>
                        <div class="text-xl font-bold text-red-600">${{ number_format($purchase->balance, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Nuevo Pago</h3>
                <form action="{{ route('supplier_payments.store', $purchase) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Monto a Pagar *</label>
                        <input type="number" step="0.01" name="amount" 
                               value="{{ old('amount', $purchase->balance) }}"
                               max="{{ $purchase->balance }}"
                               class="w-full border rounded px-3 py-2 text-lg font-bold" required>
                        <p class="text-xs text-gray-500 mt-1">
                            Máximo: ${{ number_format($purchase->balance, 2) }}
                        </p>
                        @error('amount') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Método de Pago *</label>
                        <select name="payment_method" class="w-full border rounded px-3 py-2" required>
                            <option value="efectivo">💵 Efectivo</option>
                            <option value="transferencia">🏦 Transferencia</option>
                            <option value="cheque">📝 Cheque</option>
                            <option value="tarjeta">💳 Tarjeta</option>
                            <option value="otro">🔹 Otro</option>
                        </select>
                        @error('payment_method') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Referencia</label>
                        <input type="text" name="reference" value="{{ old('reference') }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Notas</label>
                        <textarea name="notes" rows="2" class="w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold">
                            💵 Registrar Pago
                        </button>
                        <a href="{{ route('supplier_payments.index') }}" class="bg-gray-400 hover:bg-gray-600 text-white px-6 py-2 rounded">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

            @if($payments->count() > 0)
                <div class="bg-white shadow rounded-lg p-6 mt-4">
                    <h3 class="font-semibold text-lg mb-4">Historial de Pagos</h3>
                    <table class="w-full text-sm">
                        <thead class="border-b">
                            <tr class="text-left text-gray-600">
                                <th class="py-2">Fecha</th>
                                <th class="py-2">Monto</th>
                                <th class="py-2">Método</th>
                                <th class="py-2">Registró</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr class="border-b">
                                    <td class="py-2">{{ $payment->paid_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-2 font-semibold text-green-600">${{ number_format($payment->amount, 2) }}</td>
                                    <td class="py-2">{{ ucfirst($payment->payment_method) }}</td>
                                    <td class="py-2 text-gray-600">{{ $payment->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>