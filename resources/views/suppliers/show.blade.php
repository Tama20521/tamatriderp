<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🏭 {{ $supplier->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('suppliers.edit', $supplier) }}"
                   class="bg-yellow-500 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                    Editar
                </a>
                <a href="{{ route('suppliers.index') }}"
                   class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    ← Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Info del proveedor --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white shadow rounded-lg p-6 md:col-span-2">
                    <h3 class="font-semibold text-lg mb-4">Información de Contacto</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        @if($supplier->contact_name)
                            <div>
                                <span class="text-gray-500">Contacto:</span>
                                <div class="font-semibold">{{ $supplier->contact_name }}</div>
                            </div>
                        @endif
                        @if($supplier->email)
                            <div>
                                <span class="text-gray-500">Email:</span>
                                <div class="font-semibold">📧 {{ $supplier->email }}</div>
                            </div>
                        @endif
                        @if($supplier->phone)
                            <div>
                                <span class="text-gray-500">Teléfono:</span>
                                <div class="font-semibold">📞 {{ $supplier->phone }}</div>
                            </div>
                        @endif
                        @if($supplier->document)
                            <div>
                                <span class="text-gray-500">Documento:</span>
                                <div class="font-semibold">{{ $supplier->document }}</div>
                            </div>
                        @endif
                        @if($supplier->address)
                            <div class="md:col-span-2">
                                <span class="text-gray-500">Dirección:</span>
                                <div class="font-semibold">{{ $supplier->address }}</div>
                            </div>
                        @endif
                        @if($supplier->website)
                            <div class="md:col-span-2">
                                <span class="text-gray-500">Sitio Web:</span>
                                <div class="font-semibold">
                                    <a href="{{ $supplier->website }}" target="_blank" class="text-blue-500 underline">
                                        {{ $supplier->website }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">Resumen</h3>
                    <div class="space-y-3">
                        <div>
                            <div class="text-gray-500 text-sm">Total Productos</div>
                            <div class="text-3xl font-bold text-blue-600">
                                {{ $supplier->products()->count() }}
                            </div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Valor del Inventario</div>
                            <div class="text-2xl font-bold text-purple-600">
                                ${{ number_format($supplier->valor_inventario, 2) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Estado</div>
                            <div class="font-semibold">
                                @if($supplier->active)
                                    <span class="text-green-600">✅ Activo</span>
                                @else
                                    <span class="text-gray-500">⏸️ Inactivo</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Productos del proveedor --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4 border-b">
                    <h3 class="font-semibold text-lg">📦 Productos de este Proveedor</h3>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Producto</th>
                            <th class="px-4 py-2 text-left">Precio</th>
                            <th class="px-4 py-2 text-left">Stock</th>
                            <th class="px-4 py-2 text-left">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplier->products as $product)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-semibold">{{ $product->name }}</td>
                                <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                                <td class="px-4 py-2">
                                    @if($product->stock > 10)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                            {{ $product->stock }}
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">
                                            {{ $product->stock }}
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">
                                            Agotado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 font-semibold text-emerald-600">
                                    ${{ number_format($product->price * $product->stock, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">
                                    Este proveedor no tiene productos asignados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
