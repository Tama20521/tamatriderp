<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Sistema de Ventas') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 relative overflow-hidden">
            
            {{-- Burbujas decorativas --}}
            <div class="absolute top-0 left-0 w-96 h-96 bg-white opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full translate-x-1/2 translate-y-1/2 blur-3xl"></div>
            <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-pink-300 opacity-20 rounded-full blur-3xl"></div>

            {{-- Logo / Branding --}}
           <div class="relative z-10 text-center mb-8">
           <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-4">
           <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </div>
          <h1 class="text-3xl font-bold text-white mb-2">TamaTrix ERP</h1>
           <p class="text-white/80 text-sm">Gestión Empresarial Inteligente</p>
            </div>

            {{-- Card del formulario --}}
            <div class="relative z-10 w-full sm:max-w-md px-6 py-8 bg-white/95 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-3xl border border-white/20">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <p class="relative z-10 mt-8 text-white/70 text-xs">
                © {{ date('Y') }} TamaTrix ERP - Desarrollado por TamaTechFinance
            </p>
        </div>
    </body>
</html>
