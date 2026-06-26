<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $project->nombre }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $project->descripcion }}</p>
            </div>
            <a href="{{ route('projects.index') }}"
               class="text-sm text-indigo-600 hover:underline">← Volver</a>
        </div>
    </x-slot>

    <div class="grid grid-cols-3 gap-6">

        {{-- Tareas --}}
        <div class="col-span-2 space-y-4">

            {{-- Filtros --}}
            <form method="GET" action="{{ route('projects.show', $project) }}"
                  class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Estado</label>
                    <select name="estado"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">Todos</option>
                        <option value="pendiente"   {{ request('estado') === 'pendiente'   ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_progreso" {{ request('estado') === 'en_progreso' ? 'selected' : '' }}>En progreso</option>
                        <option value="completada"  {{ request('estado') === 'completada'  ? 'selected' : '' }}>Completada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Prioridad</label>
                    <select name="prioridad"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">Todas</option>
                        <option value="alta"  {{ request('prioridad') === 'alta'  ? 'selected' : '' }}>Alta</option>
                        <option value="media" {{ request('prioridad') === 'media' ? 'selected' : '' }}>Media</option>
                        <option value="baja"  {{ request('prioridad') === 'baja'  ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
                    Filtrar
                </button>
                @if(request('estado') || request('prioridad'))
                    <a href="{{ route('projects.show', $project) }}"
                       class="text-sm text-gray-400 hover:text-gray-600 self-center">
                        Limpiar filtros
                    </a>
                @endif
            </form>

            {{-- Header tareas --}}
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-gray-700">
                    Tareas
                    @if(request('estado') || request('prioridad'))
                        <span class="text-xs text-indigo-500 font-normal ml-1">(filtradas)</span>
                    @endif
                </h3>
                @can('create', App\Models\Task::class)
                    <a href="{{ route('projects.tasks.create', $project) }}"
                       class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        + Nueva Tarea
                    </a>
                @endcan
            </div>

            {{-- Lista de tareas --}}
            @forelse($tasks as $task)
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-4 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <a href="{{ route('tasks.show', $task) }}"
                           class="font-medium text-indigo-700 hover:underline">{{ $task->titulo }}</a>
                        <div class="flex gap-2 mt-1.5 flex-wrap">
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $task->estado === 'pendiente'   ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $task->estado === 'en_progreso' ? 'bg-blue-100 text-blue-700'     : '' }}
                                {{ $task->estado === 'completada'  ? 'bg-green-100 text-green-700'   : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $task->estado)) }}
                            </span>
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $task->prioridad === 'alta'  ? 'bg-red-100 text-red-700'       : '' }}
                                {{ $task->prioridad === 'media' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $task->prioridad === 'baja'  ? 'bg-gray-100 text-gray-600'     : '' }}">
                                {{ ucfirst($task->prioridad) }}
                            </span>
                            @if($task->assignee)
                                <span class="text-xs text-gray-400">→ {{ $task->assignee->name }}</span>
                            @endif
                            @if($task->due_date)
                                <span class="text-xs text-gray-400">📅 {{ $task->due_date->format('d/m/Y') }}</span>
                            @endif
                            <span class="text-xs text-gray-400">
                                💬 {{ $task->comments->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-2 ml-4">
                        @can('update', $task)
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition">
                                Editar
                            </a>
                        @endcan
                        @can('delete', $task)
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('¿Eliminar esta tarea?')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-50 text-red-500 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">
                                    Eliminar
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-8 text-center">
                    <p class="text-gray-400 text-sm">No hay tareas
                        {{ request('estado') || request('prioridad') ? 'con esos filtros.' : 'en este proyecto.' }}
                    </p>
                </div>
            @endforelse

            {{-- Paginación --}}
            <div class="mt-2">{{ $tasks->appends(request()->query())->links() }}</div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">

            {{-- Info proyecto --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-5">
                <h4 class="font-semibold text-gray-700 mb-3">Info del Proyecto</h4>
                <p class="text-xs text-gray-400 mb-1">Dueño: <span class="text-gray-600">{{ $project->owner->name }}</span></p>
                <span class="inline-block text-xs px-2 py-1 rounded-full font-medium
                    {{ $project->estado === 'activo'     ? 'bg-green-100 text-green-700'   : '' }}
                    {{ $project->estado === 'pausado'    ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $project->estado === 'finalizado' ? 'bg-gray-100 text-gray-700'     : '' }}">
                    {{ ucfirst($project->estado) }}
                </span>
                <div class="flex gap-3 mt-4">
                    @can('update', $project)
                        <a href="{{ route('projects.edit', $project) }}"
                           class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition">
                            Editar
                        </a>
                    @endcan
                    @can('delete', $project)
                        <form method="POST" action="{{ route('projects.destroy', $project) }}"
                              onsubmit="return confirm('¿Eliminar este proyecto?')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-50 text-red-500 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            </div>

            {{-- Miembros --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-5">
                <h4 class="font-semibold text-gray-700 mb-3">Miembros ({{ $members->count() }})</h4>
                <div class="space-y-2 mb-4">
                    @foreach($members as $member)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $member->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $member->pivot->project_role }}</p>
                                </div>
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
                </div>

                @can('manageMembers', $project)
                    @php
                        $nonMembers = App\Models\User::whereNotIn('id', $members->pluck('id'))->get();
                    @endphp
                    @if($nonMembers->count())
                        <form method="POST" action="{{ route('projects.members.store', $project) }}"
                              class="space-y-2 pt-3 border-t border-gray-100">
                            @csrf
                            @error('user_id')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                            <select name="user_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                <option value="">— Seleccionar usuario —</option>
                                @foreach($nonMembers as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                            <select name="project_role"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                <option value="colaborador">Colaborador</option>
                                <option value="lider">Líder</option>
                                <option value="invitado">Invitado</option>
                            </select>
                            <button class="w-full bg-indigo-600 text-white text-sm py-2 rounded-lg hover:bg-indigo-700 transition">
                                + Agregar Miembro
                            </button>
                        </form>
                    @endif
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>