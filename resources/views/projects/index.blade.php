<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Proyectos</h2>
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                    + Nuevo Proyecto
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-4">
        @forelse($projects as $project)
            <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
                <div>
                    <a href="{{ route('projects.show', $project) }}"
                       class="text-lg font-semibold text-indigo-700 hover:underline">
                        {{ $project->nombre }}
                    </a>
                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($project->descripcion, 80) }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $project->estado === 'activo' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $project->estado === 'pausado' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $project->estado === 'finalizado' ? 'bg-gray-100 text-gray-700' : '' }}">
                            {{ ucfirst($project->estado) }}
                        </span>
                        <span class="text-xs text-gray-400">Dueño: {{ $project->owner->name }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @can('update', $project)
                        <a href="{{ route('projects.edit', $project) }}"
                           class="text-sm text-indigo-600 hover:underline">Editar</a>
                    @endcan
                    @can('delete', $project)
                        <form method="POST" action="{{ route('projects.destroy', $project) }}"
                              onsubmit="return confirm('¿Eliminar este proyecto?')">
                            @csrf @method('DELETE')
                            <button class="text-sm text-red-500 hover:underline">Eliminar</button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <div class="bg-white shadow rounded-lg p-6 text-center text-gray-400">
                No hay proyectos disponibles.
            </div>
        @endforelse

        <div class="mt-4">{{ $projects->links() }}</div>
    </div>
</x-app-layout>