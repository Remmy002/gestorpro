<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestorPro — Iniciar Sesión</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

    <div style="width: 100%; max-width: 480px;">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3">
                <div class="bg-indigo-600 rounded-xl p-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-gray-800">GestorPro</span>
            </div>
            <p class="text-gray-500 text-sm mt-2">Sistema de Gestión de Proyectos Colaborativos</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8" style="padding: 2rem;">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Iniciar Sesión</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Correo electrónico
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" autofocus
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('email') border-red-400 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Contraseña
                    </label>
                    <input type="password" name="password"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('password') border-red-400 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember"
                               class="rounded border-gray-300 text-indigo-600">
                        Recordarme
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-indigo-600 hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2.5 rounded-xl hover:bg-indigo-700 transition font-medium text-sm shadow-sm">
                    Iniciar Sesión
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">
                    Regístrate
                </a>
            </p>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            UATF — INF560 Desarrollo Web Backend
        </p>
    </div>

</body>
</html>