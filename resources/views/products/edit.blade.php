<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                               class="w-full border rounded px-3 py-2" required>
                        @error('name') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Precio</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                               class="w-full border rounded px-3 py-2" required>
                        @error('price') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                               class="w-full border rounded px-3 py-2" required>
                        @error('stock') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-2 rounded">
                            Actualizar
                        </button>
                        <a href="{{ route('products.index') }}" 
                           class="bg-gray-400 hover:bg-gray-600 text-white px-6 py-2 rounded">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>