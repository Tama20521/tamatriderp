<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listado de Productos
            </h2>
            <a href="{{ route('products.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nuevo Producto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
             <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
             {{ session('error') }}
             </div>
           @endif
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <form method="GET" action="{{ route('products.index') }}" 
                  class="bg-white p-4 rounded-lg shadow mb-6 grid grid-cols-1 md:grid-cols-5 gap-3">
                <input type="text" name="search" placeholder="Buscar por nombre" 
                       value="{{ request('search') }}"
                       class="border rounded px-3 py-2">
                <input type="number" name="min_price" placeholder="Precio mín." 
                       value="{{ request('min_price') }}"
                       class="border rounded px-3 py-2">
                <input type="number" name="max_price" placeholder="Precio máx." 
                       value="{{ request('max_price') }}"
                       class="border rounded px-3 py-2">
                <select name="stock" class="border rounded px-3 py-2">
                    <option value="">-- Stock --</option>
                    <option value="available" {{ request('stock') === 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="unavailable" {{ request('stock') === 'unavailable' ? 'selected' : '' }}>Agotado</option>
                </select>
                <button type="submit" class="bg-gray-700 hover:bg-gray-900 text-white px-4 py-2 rounded">
                    Filtrar
                </button>
            </form>

            {{-- Tabla --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Precio</th>
                            <th class="px-4 py-2 text-left">Stock</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $product->name }}</td>
                                <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                                <td class="px-4 py-2">{{ $product->stock }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('products.edit', $product) }}" 
                                       class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" 
                                          method="POST" class="inline"
                                          onsubmit="return confirm('¿Eliminar este producto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">
                                    No se encontraron productos
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>