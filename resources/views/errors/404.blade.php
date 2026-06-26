<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestorPro — Página no encontrada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="text-center px-6">
        <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-6xl font-bold text-indigo-300 mb-2">404</h1>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Página no encontrada</h2>
        <p class="text-gray-500 text-sm mb-8">
            El recurso que buscas no existe o fue eliminado.
        </p>
        <a href="{{ route('dashboard') }}"
           class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
            Ir al Panel
        </a>
    </div>
</body>
</html>