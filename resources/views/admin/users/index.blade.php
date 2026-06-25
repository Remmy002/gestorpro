<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Gestión de Usuarios</h2>
    </x-slot>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol actual</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asignar rol</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $user->hasRole('admin') ? 'bg-indigo-100 text-indigo-700' : '' }}
                            {{ $user->hasRole('lider') ? 'bg-green-100 text-green-700' : '' }}
                            {{ $user->hasRole('colaborador') ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $user->hasRole('invitado') ? 'bg-gray-100 text-gray-700' : '' }}">
                            {{ $user->getRoleNames()->first() ?? 'Sin rol' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <form method="POST"
                              action="{{ route('admin.users.assignRole', $user) }}"
                              class="flex items-center gap-2">
                            @csrf
                            <select name="role"
                                    class="text-sm border border-gray-300 rounded px-2 py-1">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="bg-indigo-600 text-white text-sm px-3 py-1 rounded hover:bg-indigo-700">
                                Asignar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>