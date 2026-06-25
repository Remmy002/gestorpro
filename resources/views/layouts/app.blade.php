<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GestorPro — {{ $title ?? 'Panel' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">
                GestorPro
            </a>
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->name }}
                        <span class="ml-1 text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">
                            {{ auth()->user()->getRoleNames()->first() }}
                        </span>
                    </span>

                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.users.index') }}"
                           class="text-sm text-gray-600 hover:text-indigo-600">Usuarios</a>
                    @endif

                    <a href="{{ route('projects.index') }}"
                       class="text-sm text-gray-600 hover:text-indigo-600">Proyectos</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-red-500 hover:text-red-700">Cerrar sesión</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    {{-- MENSAJES FLASH --}}
    <div class="max-w-7xl mx-auto px-4">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded">
                {{ session('warning') }}
            </div>
        @endif
    </div>

    {{-- CONTENIDO --}}
    <main class="max-w-7xl mx-auto px-4 pb-10">
        {{ $slot }}
    </main>

</body>
</html>