<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel Principal
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                    Bienvenido, {{ auth()->user()->name }}
                </h3>
                <p class="text-sm text-gray-500">
                    Rol asignado:
                    <span class="font-medium text-indigo-600">
                        {{ auth()->user()->getRoleNames()->first() }}
                    </span>
                </p>
            </div>

            {{-- Panel según rol --}}
            @role('admin')
            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-5 mb-4">
                <h4 class="font-semibold text-indigo-800 mb-3">Acciones de Administrador</h4>
                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('admin.users.index') }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                        Gestionar Usuarios
                    </a>
                    <a href="{{ route('projects.index') }}"
                       class="bg-white border border-indigo-300 text-indigo-700 px-4 py-2 rounded hover:bg-indigo-50 text-sm">
                        Ver Todos los Proyectos
                    </a>
                </div>
            </div>
            @endrole

            @role('lider')
            <div class="bg-green-50 border border-green-200 rounded-lg p-5 mb-4">
                <h4 class="font-semibold text-green-800 mb-3">Acciones de Líder</h4>
                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('projects.create') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                        Crear Proyecto
                    </a>
                    <a href="{{ route('projects.index') }}"
                       class="bg-white border border-green-300 text-green-700 px-4 py-2 rounded hover:bg-green-50 text-sm">
                        Mis Proyectos
                    </a>
                </div>
            </div>
            @endrole

            @role('colaborador')
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 mb-4">
                <h4 class="font-semibold text-blue-800 mb-3">Acciones de Colaborador</h4>
                <div class="flex gap-3">
                    <a href="{{ route('projects.index') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                        Ver Mis Proyectos
                    </a>
                </div>
            </div>
            @endrole

            @role('invitado')
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-4">
                <h4 class="font-semibold text-gray-700 mb-3">Acciones de Invitado</h4>
                <div class="flex gap-3">
                    <a href="{{ route('projects.index') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
                        Ver Proyectos Asignados
                    </a>
                </div>
            </div>
            @endrole

        </div>
    </div>
</x-app-layout>