<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">{{ $task->titulo }}</h2>
            <a href="{{ route('projects.show', $task->project) }}"
               class="text-sm text-indigo-600 hover:underline">← Volver al proyecto</a>
        </div>
    </x-slot>

    <div class="grid grid-cols-3 gap-6">

        {{-- Detalle de la tarea --}}
        <div class="col-span-2 space-y-4">
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-gray-700 mb-4">{{ $task->descripcion ?? 'Sin descripción.' }}</p>
                <div class="flex flex-wrap gap-3 text-sm">
                    <span class="px-2 py-1 rounded-full
                        {{ $task->estado === 'pendiente'   ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $task->estado === 'en_progreso' ? 'bg-blue-100 text-blue-700'     : '' }}
                        {{ $task->estado === 'completada'  ? 'bg-green-100 text-green-700'   : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $task->estado)) }}
                    </span>
                    <span class="px-2 py-1 rounded-full
                        {{ $task->prioridad === 'alta'  ? 'bg-red-100 text-red-700'    : '' }}
                        {{ $task->prioridad === 'media' ? 'bg-orange-100 text-orange-700' : '' }}
                        {{ $task->prioridad === 'baja'  ? 'bg-gray-100 text-gray-700'  : '' }}">
                        Prioridad: {{ ucfirst($task->prioridad) }}
                    </span>
                    @if($task->due_date)
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full">
                            Vence: {{ $task->due_date->format('d/m/Y') }}
                        </span>
                    @endif
                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full">
                        Asignado a: {{ $task->assignee?->name ?? 'Sin asignar' }}
                    </span>
                </div>

                <div class="flex gap-3 mt-5">
                    @can('update', $task)
                        <a href="{{ route('tasks.edit', $task) }}"
                           class="bg-indigo-600 text-white text-sm px-4 py-2 rounded hover:bg-indigo-700">
                            Editar
                        </a>
                    @endcan
                    @can('delete', $task)
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                              onsubmit="return confirm('¿Eliminar esta tarea?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white text-sm px-4 py-2 rounded hover:bg-red-600">
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            </div>

            {{-- Cambiar estado --}}
            @can('changeStatus', $task)
            <div class="bg-white shadow rounded-lg p-5">
                <h4 class="font-semibold text-gray-700 mb-3">Cambiar Estado</h4>
                <form method="POST" action="{{ route('tasks.status', $task) }}" class="flex gap-3">
                    @csrf @method('PATCH')
                    <select name="estado" class="border border-gray-300 rounded px-3 py-2 text-sm">
                        <option value="pendiente"   {{ $task->estado === 'pendiente'   ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_progreso" {{ $task->estado === 'en_progreso' ? 'selected' : '' }}>En progreso</option>
                        <option value="completada"  {{ $task->estado === 'completada'  ? 'selected' : '' }}>Completada</option>
                    </select>
                    <button class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700">
                        Actualizar
                    </button>
                </form>
            </div>
            @endcan

            {{-- Comentarios --}}
            <div class="bg-white shadow rounded-lg p-5">
                <h4 class="font-semibold text-gray-700 mb-4">Comentarios ({{ $task->comments->count() }})</h4>

                @forelse($task->comments as $comment)
                    <div class="border-b border-gray-100 pb-3 mb-3 last:border-0 last:mb-0">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                @can('delete', $comment)
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-red-400 hover:text-red-600">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $comment->cuerpo }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">No hay comentarios aún.</p>
                @endforelse

                @can('create', App\Models\Comment::class)
                    <form method="POST" action="{{ route('comments.store', $task) }}" class="mt-4">
                        @csrf
                        <textarea name="cuerpo" rows="2" placeholder="Escribe un comentario..."
                                  class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('cuerpo') }}</textarea>
                        @error('cuerpo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <button class="mt-2 bg-indigo-600 text-white text-sm px-4 py-2 rounded hover:bg-indigo-700">
                            Comentar
                        </button>
                    </form>
                @endcan
            </div>
        </div>

        {{-- Sidebar reasignar --}}
        <div class="space-y-4">
            @can('assign', $task)
            <div class="bg-white shadow rounded-lg p-5">
                <h4 class="font-semibold text-gray-700 mb-3">Reasignar Tarea</h4>
                <form method="POST" action="{{ route('tasks.assign', $task) }}">
                    @csrf @method('PATCH')
                    <select name="assignee_id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm mb-3">
                        <option value="">— Sin asignar —</option>
                        @foreach($task->project->members as $member)
                            <option value="{{ $member->id }}"
                                {{ $task->assignee_id == $member->id ? 'selected' : '' }}>
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="w-full bg-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-700">
                        Reasignar
                    </button>
                </form>
            </div>
            @endcan
        </div>

    </div>
</x-app-layout>