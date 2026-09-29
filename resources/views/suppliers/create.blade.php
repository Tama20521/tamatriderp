<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏭 Nuevo Proveedor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('suppliers.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Nombre del Proveedor *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border rounded px-3 py-2" required>
                        @error('name') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Persona de Contacto</label>
                        <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('contact_name') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('email') <small class="text-red-500">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('phone') <small class="text-red-500">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Documento (RUC, NIT)</label>
                            <input type="text" name="document" value="{{ old('document') }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('document') <small class="text-red-500">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Sitio Web</label>
                            <input type="text" name="website" value="{{ old('website') }}"
                                   placeholder="https://ejemplo.com"
                                   class="w-full border rounded px-3 py-2">
                            @error('website') <small class="text-red-500">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Dirección</label>
                        <input type="text" name="address" value="{{ old('address') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('address') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Notas</label>
                        <textarea name="notes" rows="3"
                                  class="w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>
                        @error('notes') <small class="text-red-500">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="active" value="1" 
                                   {{ old('active', true) ? 'checked' : '' }}
                                   class="mr-2">
                            <span>Proveedor activo</span>
                        </label>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-2 rounded">
                            Guardar
                        </button>
                        <a href="{{ route('suppliers.index') }}"
                           class="bg-gray-400 hover:bg-gray-600 text-white px-6 py-2 rounded">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>