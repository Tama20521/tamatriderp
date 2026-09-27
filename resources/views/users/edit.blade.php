<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👥 Editar Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full border rounded px-3 py-2" required>
                        @error('name') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full border rounded px-3 py-2" required>
                        @error('email') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4 bg-gray-50 p-3 rounded">
                        <p class="text-sm text-gray-600 mb-2">
                            Deja en blanco si no quieres cambiar la contraseña
                        </p>
                        <label class="block font-semibold mb-2">Nueva Contraseña</label>
                        <input type="password" name="password"
                               class="w-full border rounded px-3 py-2">
                        @error('password') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4 bg-gray-50 p-3 rounded">
                        <label class="block font-semibold mb-2">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Rol</label>
                        <select name="role" class="w-full border rounded px-3 py-2" required>
                            <option value="vendedor" {{ old('role', $user->role) === 'vendedor' ? 'selected' : '' }}>
                                🧑‍💼 Vendedor
                            </option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                👑 Administrador
                            </option>
                        </select>
                        @error('role') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-2 rounded">
                            Actualizar
                        </button>
                        <a href="{{ route('users.index') }}"
                           class="bg-gray-400 hover:bg-gray-600 text-white px-6 py-2 rounded">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>