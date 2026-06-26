<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestorPro — Acceso denegado</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="text-center px-6">
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m0 0v2m0-2h2m-2 0H10m2-5V7m0 0V5m0 2h2M12 7H10"/>
            </svg>
        </div>
        <h1 class="text-6xl font-bold text-red-400 mb-2">403</h1>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Acceso Denegado</h2>
        <p class="text-gray-500 text-sm mb-8">
            No tienes permisos para acceder a esta sección.
        </p>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}"
           class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
            Volver atrás
        </a>
    </div>
</body>
</html>