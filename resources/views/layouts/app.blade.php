<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GestorPro — {{ $title ?? 'Panel' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-gradient-to-r from-indigo-700 to-indigo-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <div class="bg-white rounded-lg p-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-600" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-lg tracking-tight">GestorPro</span>
            </a>

            {{-- Nav links + usuario --}}
            @auth
            <div class="flex items-center gap-5">
                <a href="{{ route('projects.index') }}"
                   class="text-indigo-100 hover:text-white text-sm font-medium transition">
                    Proyectos
                </a>
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.users.index') }}"
                       class="text-indigo-100 hover:text-white text-sm font-medium transition">
                        Usuarios
                    </a>
                @endif

                {{-- Usuario --}}
                <div class="flex items-center gap-2 bg-indigo-600 rounded-full px-3 py-1.5">
                    <div class="w-6 h-6 rounded-full bg-white flex items-center justify-center">
                        <span class="text-indigo-600 text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <span class="text-white text-sm">{{ auth()->user()->name }}</span>
                    <span class="text-xs bg-indigo-400 text-white px-2 py-0.5 rounded-full">
                        {{ auth()->user()->getRoleNames()->first() }}
                    </span>
                </div>

                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-indigo-200 hover:text-white text-sm transition">
                        Salir
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </nav>

    {{-- MENSAJES FLASH --}}
    <div class="max-w-7xl mx-auto px-6 mt-4">
        @if(session('success'))
            <div class="flex items-center gap-2 bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm">
                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center gap-2 bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-sm">
                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-lg text-sm">
                ⚠️ {{ session('warning') }}
            </div>
        @endif
    </div>

    {{-- HEADER de página --}}
    @isset($header)
        <div class="max-w-7xl mx-auto px-6 mt-6 mb-4">
            {{ $header }}
        </div>
    @endisset

    {{-- CONTENIDO --}}
    <main class="max-w-7xl mx-auto px-6 pb-12">
        {{ $slot }}
    </main>

</body>
</html>