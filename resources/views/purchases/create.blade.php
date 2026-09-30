<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📦 Nueva Compra a Proveedor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('purchases.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Proveedor *</label>
                    <select name="supplier_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Seleccionar proveedor --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-semibold mb-2">N° Factura del Proveedor</label>
                        <input type="text" name="invoice_number" value="{{ old('invoice_number') }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Tipo de Pago *</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="payment_type" value="contado" 
                                       {{ old('payment_type', 'contado') === 'contado' ? 'checked' : '' }}
                                       class="mr-2 pt-radio">
                                <span>💵 Contado</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="payment_type" value="credito" 
                                       {{ old('payment_type') === 'credito' ? 'checked' : '' }}
                                       class="mr-2 pt-radio">
                                <span>📅 Crédito</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div id="due-date-field" class="mb-4" style="display: none;">
                    <label class="block font-semibold mb-2">Fecha de Vencimiento</label>
                    <input type="date" name="due_date" 
                           value="{{ old('due_date', now()->addDays(30)->format('Y-m-d')) }}"
                           class="border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Productos Comprados *</label>
                    <table class="w-full" id="productsTable">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-3 py-2 text-left">Producto</th>
                                <th class="px-3 py-2 text-left">Cantidad</th>
                                <th class="px-3 py-2 text-left">Costo Unitario</th>
                                <th class="px-3 py-2 text-left">Subtotal</th>
                                <th class="px-3 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-3 py-2">
                                    <select name="products[0][id]" class="product-select border rounded px-2 py-1 w-full" required>
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-3 py-2">
                                    <input type="number" name="products[0][quantity]" class="quantity border rounded px-2 py-1 w-20" value="1" min="1" required>
                                </td>
                                <td class="px-3 py-2">
                                    <input type="number" step="0.01" name="products[0][unit_cost]" class="unit-cost border rounded px-2 py-1 w-24" value="0" min="0" required>
                                </td>
                                <td class="px-3 py-2 subtotal font-bold">$0.00</td>
                                <td class="px-3 py-2">
                                    <button type="button" class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded remove-row">X</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-bold px-3 py-2">Total:</td>
                                <td colspan="2" class="font-bold text-lg px-3 py-2 text-emerald-600" id="total">$0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="mt-2 bg-gray-600 hover:bg-gray-800 text-white px-4 py-2 rounded" id="addRow">
                        + Agregar producto
                    </button>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Notas</label>
                    <textarea name="notes" rows="2" class="w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-2 rounded">
                        Registrar Compra
                    </button>
                    <a href="{{ route('purchases.index') }}" class="bg-gray-400 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        Cancelar
                    </a>
                </div>
            </form>

        </div>
    </div>

    <script>
        let rowIndex = 1;

        function updateTotals() {
            let total = 0;
            document.querySelectorAll('#productsTable tbody tr').forEach(row => {
                const qty = parseFloat(row.querySelector('.quantity').value || 0);
                const cost = parseFloat(row.querySelector('.unit-cost').value || 0);
                const subtotal = qty * cost;
                row.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
                total += subtotal;
            });
            document.getElementById('total').textContent = `$${total.toFixed(2)}`;
        }

        document.getElementById('addRow').addEventListener('click', () => {
            const tbody = document.querySelector('#productsTable tbody');
            const newRow = tbody.rows[0].cloneNode(true);
            newRow.querySelectorAll('select, input').forEach(el => {
                el.name = el.name.replace(/\[\d+\]/, `[${rowIndex}]`);
                if (el.classList.contains('quantity')) el.value = 1;
                if (el.classList.contains('unit-cost')) el.value = 0;
            });
            tbody.appendChild(newRow);
            rowIndex++;
            updateTotals();
        });

        document.addEventListener('input', e => {
            if (e.target.matches('.quantity, .unit-cost')) updateTotals();
        });

        document.addEventListener('click', e => {
            if (e.target.matches('.remove-row')) {
                const rows = document.querySelectorAll('#productsTable tbody tr');
                if (rows.length > 1) {
                    e.target.closest('tr').remove();
                    updateTotals();
                }
            }
        });

        document.querySelectorAll('.pt-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('due-date-field').style.display = this.value === 'credito' ? 'block' : 'none';
            });
        });

        document.addEventListener('change', e => {
            if (e.target.matches('.product-select')) {
                const price = e.target.selectedOptions[0]?.dataset.price || 0;
                const row = e.target.closest('tr');
                row.querySelector('.unit-cost').value = price;
                updateTotals();
            }
        });

        updateTotals();
    </script>
</x-app-layout>