<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">{{ $project->nombre }}</h2>
            <a href="{{ route('projects.index') }}"
               class="text-sm text-indigo-600 hover:underline">← Volver</a>
        </div>
    </x-slot>

    <div class="grid grid-cols-3 gap-6">

        {{-- Tareas --}}
        <div class="col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-gray-700">Tareas</h3>
                @can('create', App\Models\Task::class)
                    <a href="{{ route('projects.tasks.create', $project) }}"
                       class="bg-indigo-600 text-white text-sm px-3 py-1.5 rounded hover:bg-indigo-700">
                        + Nueva Tarea
                    </a>
                @endcan
            </div>

            @forelse($project->tasks as $task)
                <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
                    <div>
                        <a href="{{ route('tasks.show', $task) }}"
                           class="font-medium text-indigo-700 hover:underline">{{ $task->titulo }}</a>
                        <div class="flex gap-2 mt-1">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $task->estado === 'pendiente'   ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $task->estado === 'en_progreso' ? 'bg-blue-100 text-blue-700'     : '' }}
                                {{ $task->estado === 'completada'  ? 'bg-green-100 text-green-700'   : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $task->estado)) }}
                            </span>
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $task->prioridad === 'alta'  ? 'bg-red-100 text-red-700'      : '' }}
                                {{ $task->prioridad === 'media' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $task->prioridad === 'baja'  ? 'bg-gray-100 text-gray-700'    : '' }}">
                                {{ ucfirst($task->prioridad) }}
                            </span>
                            @if($task->assignee)
                                <span class="text-xs text-gray-400">→ {{ $task->assignee->name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2">
                        @can('update', $task)
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="text-xs text-indigo-600 hover:underline">Editar</a>
                        @endcan
                        @can('delete', $task)
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">Eliminar</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="bg-white shadow rounded-lg p-5 text-center text-gray-400 text-sm">
                    No hay tareas en este proyecto.
                </div>
            @endforelse
        </div>

        {{-- Sidebar miembros --}}
        <div class="space-y-4">

            {{-- Info proyecto --}}
            <div class="bg-white shadow rounded-lg p-5">
                <h4 class="font-semibold text-gray-700 mb-2">Info del Proyecto</h4>
                <p class="text-sm text-gray-500 mb-2">{{ $project->descripcion }}</p>
                <span class="text-xs px-2 py-1 rounded-full
                    {{ $project->estado === 'activo'     ? 'bg-green-100 text-green-700'  : '' }}
                    {{ $project->estado === 'pausado'    ? 'bg-yellow-100 text-yellow-700': '' }}
                    {{ $project->estado === 'finalizado' ? 'bg-gray-100 text-gray-700'    : '' }}">
                    {{ ucfirst($project->estado) }}
                </span>
                <div class="flex gap-2 mt-3">
                    @can('update', $project)
                        <a href="{{ route('projects.edit', $project) }}"
                           class="text-xs text-indigo-600 hover:underline">Editar proyecto</a>
                    @endcan
                    @can('delete', $project)
                        <form method="POST" action="{{ route('projects.destroy', $project) }}"
                              onsubmit="return confirm('¿Eliminar proyecto?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-500 hover:underline">Eliminar</button>
                        </form>
                    @endcan
                </div>
            </div>

            {{-- Miembros --}}
            <div class="bg-white shadow rounded-lg p-5">
                <h4 class="font-semibold text-gray-700 mb-3">Miembros</h4>
                @foreach($members as $member)
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $member->name }}</p>
                            <p class="text-xs text-gray-400">{{ $member->pivot->project_role }}</p>
                        </div>
                        @can('manageMembers', $project)
                            @if($member->id !== $project->owner_id)
                                <form method="POST"
                                      action="{{ route('projects.members.destroy', [$project, $member]) }}">
                                    @csrf @method('DELETE')
                                    <button class="text-xs text-red-400 hover:text-red-600">Quitar</button>
                                </form>
                            @endif
                        @endcan
                    </div>
                @endforeach

                {{-- Agregar miembro --}}
                @can('manageMembers', $project)
                    @php
                        $nonMembers = App\Models\User::whereNotIn('id', $members->pluck('id'))->get();
                    @endphp
                    @if($nonMembers->count())
                        <form method="POST"
                              action="{{ route('projects.members.store', $project) }}"
                              class="mt-4 space-y-2">
                            @csrf
                            <select name="user_id"
                                    class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                <option value="">— Seleccionar usuario —</option>
                                @foreach($nonMembers as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                            <select name="project_role"
                                    class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                <option value="colaborador">Colaborador</option>
                                <option value="lider">Líder</option>
                                <option value="invitado">Invitado</option>
                            </select>
                            @error('user_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                            <button class="w-full bg-indigo-600 text-white text-sm py-1.5 rounded hover:bg-indigo-700">
                                Agregar Miembro
                            </button>
                        </form>
                    @endif
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>