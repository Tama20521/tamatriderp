<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👥 Gestión de Clientes
            </h2>
            <a href="{{ route('clients.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nuevo Cliente
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

            <form method="GET" action="{{ route('clients.index') }}" class="mb-4">
                <input type="text" name="search" placeholder="Buscar por nombre, email, teléfono o documento..."
                       value="{{ request('search') }}"
                       class="w-full border rounded px-3 py-2">
            </form>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Contacto</th>
                            <th class="px-4 py-2 text-left">Documento</th>
                            <th class="px-4 py-2 text-left">Compras</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-semibold">{{ $client->name }}</td>
                                <td class="px-4 py-2 text-sm">
                                    @if($client->email)
                                        <div>📧 {{ $client->email }}</div>
                                    @endif
                                    @if($client->phone)
                                        <div>📞 {{ $client->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm">{{ $client->document ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">
                                        {{ $client->sales()->count() }} ventas
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('clients.edit', $client) }}"
                                       class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('clients.destroy', $client) }}"
                                          method="POST" class="inline"
                                          onsubmit="return confirm('¿Eliminar este cliente?')">
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
                                <td colspan="5" class="text-center py-4 text-gray-500">
                                    No hay clientes registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $clients->links() }}
            </div>

        </div>
    </div>
</x-app-layout>