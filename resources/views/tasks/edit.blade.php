<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Tarea</h2>
    </x-slot>

    <div class="bg-white shadow rounded-lg p-6 max-w-2xl">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo', $task->titulo) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @error('titulo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('descripcion', $task->descripcion) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="estado" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                        <option value="pendiente"   {{ old('estado', $task->estado) === 'pendiente'   ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_progreso" {{ old('estado', $task->estado) === 'en_progreso' ? 'selected' : '' }}>En progreso</option>
                        <option value="completada"  {{ old('estado', $task->estado) === 'completada'  ? 'selected' : '' }}>Completada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                    <select name="prioridad" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                        <option value="baja"  {{ old('prioridad', $task->prioridad) === 'baja'  ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ old('prioridad', $task->prioridad) === 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta"  {{ old('prioridad', $task->prioridad) === 'alta'  ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha límite</label>
                    <input type="date" name="due_date"
                           value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Asignar a</label>
                    <select name="assignee_id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                        <option value="">— Sin asignar —</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}"
                                {{ old('assignee_id', $task->assignee_id) == $member->id ? 'selected' : '' }}>
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 text-sm">
                    Guardar Cambios
                </button>
                <a href="{{ route('tasks.show', $task) }}"
                   class="text-sm text-gray-500 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>