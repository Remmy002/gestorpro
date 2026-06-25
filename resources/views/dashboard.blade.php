<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">Panel Principal</h1>
        <p class="text-sm text-gray-500 mt-1">Bienvenido de nuevo, {{ auth()->user()->name }}</p>
    </x-slot>

    {{-- Tarjeta de bienvenida --}}
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-2xl p-6 mb-6 text-white shadow-md">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-semibold">{{ auth()->user()->name }}</h2>
                <p class="text-indigo-100 text-sm">
                    Rol:
                    <span class="bg-white bg-opacity-20 px-2 py-0.5 rounded-full text-white font-medium">
                        {{ auth()->user()->getRoleNames()->first() }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    {{-- Acciones por rol --}}
    @role('admin')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800">Administrador</h3>
        </div>
        <div class="flex gap-3 flex-wrap">
            <a href="{{ route('admin.users.index') }}"
               class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl hover:bg-indigo-700 text-sm font-medium transition shadow-sm">
                Gestionar Usuarios
            </a>
            <a href="{{ route('projects.index') }}"
               class="bg-white border border-indigo-200 text-indigo-700 px-5 py-2.5 rounded-xl hover:bg-indigo-50 text-sm font-medium transition">
                Ver Todos los Proyectos
            </a>
        </div>
    </div>
    @endrole

    @role('lider')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800">Líder de Proyecto</h3>
        </div>
        <div class="flex gap-3 flex-wrap">
            <a href="{{ route('projects.create') }}"
               class="bg-green-600 text-white px-5 py-2.5 rounded-xl hover:bg-green-700 text-sm font-medium transition shadow-sm">
                + Crear Proyecto
            </a>
            <a href="{{ route('projects.index') }}"
               class="bg-white border border-green-200 text-green-700 px-5 py-2.5 rounded-xl hover:bg-green-50 text-sm font-medium transition">
                Mis Proyectos
            </a>
        </div>
    </div>
    @endrole

    @role('colaborador')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800">Colaborador</h3>
        </div>
        <a href="{{ route('projects.index') }}"
           class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 text-sm font-medium transition shadow-sm">
            Ver Mis Proyectos
        </a>
    </div>
    @endrole

    @role('invitado')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800">Invitado</h3>
        </div>
        <a href="{{ route('projects.index') }}"
           class="bg-gray-600 text-white px-5 py-2.5 rounded-xl hover:bg-gray-700 text-sm font-medium transition shadow-sm">
            Ver Proyectos Asignados
        </a>
    </div>
    @endrole

</x-app-layout>