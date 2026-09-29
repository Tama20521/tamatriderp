<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Venta
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($products->isEmpty())
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    No hay productos con stock disponible. 
                    <a href="{{ route('products.create') }}" class="underline font-bold">
                        Crea uno primero
                    </a>
                </div>
            @else
                <form action="{{ route('sales.store') }}" method="POST" id="saleForm" class="bg-white shadow rounded-lg p-6">
                    @csrf
              {{-- Selector de Cliente --}}
<div class="mb-6 bg-gray-50 p-4 rounded">
    <label class="block font-semibold mb-2">Cliente (opcional)</label>
    <select name="client_id" class="w-full border rounded px-3 py-2">
        <option value="">-- Consumidor Final --</option>
        @foreach($clients as $client)
            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                {{ $client->name }}
                @if($client->document) — {{ $client->document }} @endif
            </option>
        @endforeach
    </select>
    <p class="text-xs text-gray-500 mt-1">
        ¿No encuentras al cliente? 
        <a href="{{ route('clients.create') }}" class="text-blue-500 underline" target="_blank">
            Crear nuevo cliente
        </a>
    </p>
</div>

                    <table class="w-full mb-4" id="productsTable">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-3 py-2 text-left">Producto</th>
                                <th class="px-3 py-2 text-left">Precio</th>
                                <th class="px-3 py-2 text-left">Stock</th>
                                <th class="px-3 py-2 text-left">Cantidad</th>
                                <th class="px-3 py-2 text-left">Subtotal</th>
                                <th class="px-3 py-2 text-left"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-3 py-2">
                                    <select name="products[0][id]" class="product-select border rounded px-2 py-1 w-full" required>
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                    data-price="{{ $product->price }}"
                                                    data-stock="{{ $product->stock }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-3 py-2 price">$0.00</td>
                                <td class="px-3 py-2 stock">0</td>
                                <td class="px-3 py-2">
                                    <input type="number" name="products[0][quantity]" 
                                           class="quantity border rounded px-2 py-1 w-20" value="1" min="1" required>
                                </td>
                                <td class="px-3 py-2 subtotal font-bold">$0.00</td>
                                <td class="px-3 py-2">
                                    <button type="button" class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded remove-row">X</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right font-bold px-3 py-2">Total:</td>
                                <td colspan="2" class="font-bold text-lg px-3 py-2" id="total">$0.00</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="flex gap-3">
                        <button type="button" class="bg-gray-600 hover:bg-gray-800 text-white px-4 py-2 rounded" id="addRow">
                            + Agregar producto
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-2 rounded">
                            Registrar Venta
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>

    <script>
        let rowIndex = 1;

        function updateTotals() {
            let total = 0;
            document.querySelectorAll('#productsTable tbody tr').forEach(row => {
                const select = row.querySelector('.product-select');
                const qtyInput = row.querySelector('.quantity');
                const price = parseFloat(select.selectedOptions[0]?.dataset.price || 0);
                const stock = parseInt(select.selectedOptions[0]?.dataset.stock || 0);
                let qty = parseInt(qtyInput.value || 0);

                if (qty > stock) {
                    qty = stock;
                    qtyInput.value = stock;
                }

                const subtotal = price * qty;
                row.querySelector('.price').textContent = `$${price.toFixed(2)}`;
                row.querySelector('.stock').textContent = stock;
                row.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
                total += subtotal;
            });
            document.getElementById('total').textContent = `$${total.toFixed(2)}`;
        }

        document.getElementById('addRow')?.addEventListener('click', () => {
            const tbody = document.querySelector('#productsTable tbody');
            const newRow = tbody.rows[0].cloneNode(true);
            newRow.querySelectorAll('select, input').forEach(el => {
                el.name = el.name.replace(/\[\d+\]/, `[${rowIndex}]`);
                if (el.classList.contains('quantity')) el.value = 1;
            });
            tbody.appendChild(newRow);
            rowIndex++;
            updateTotals();
        });

        document.addEventListener('input', e => {
            if (e.target.matches('.product-select, .quantity')) updateTotals();
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

        updateTotals();
    </script>
</x-app-layout>