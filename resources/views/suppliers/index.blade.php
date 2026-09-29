<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🏭 Gestión de Proveedores
            </h2>
            <a href="{{ route('suppliers.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nuevo Proveedor
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

            <form method="GET" action="{{ route('suppliers.index') }}" 
                  class="bg-white p-4 rounded-lg shadow mb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
                <input type="text" name="search" placeholder="Buscar proveedor..." 
                       value="{{ request('search') }}"
                       class="border rounded px-3 py-2 md:col-span-2">
                <button type="submit" class="bg-gray-700 hover:bg-gray-900 text-white px-4 py-2 rounded">
                    Buscar
                </button>
            </form>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Proveedor</th>
                            <th class="px-4 py-2 text-left">Contacto</th>
                            <th class="px-4 py-2 text-left">Productos</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-semibold">{{ $supplier->name }}</td>
                                <td class="px-4 py-2 text-sm">
                                    @if($supplier->email)
                                        <div>📧 {{ $supplier->email }}</div>
                                    @endif
                                    @if($supplier->phone)
                                        <div>📞 {{ $supplier->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                        {{ $supplier->products()->count() }} productos
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('suppliers.edit', $supplier) }}"
                                       class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}"
                                          method="POST" class="inline"
                                          onsubmit="return confirm('¿Eliminar?')">
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
                                    No hay proveedores registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
          {{-- Paginación con estilo Tailwind de Breeze --}}
            @if($suppliers->hasPages())
                <div class="mt-4 bg-white p-4 rounded-lg shadow">
                    {{ $suppliers->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>