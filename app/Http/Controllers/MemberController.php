<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $this->authorize('manageMembers', $project);

        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'project_role' => 'required|in:lider,colaborador,invitado',
        ], [
            'user_id.required'      => 'Selecciona un usuario.',
            'user_id.exists'        => 'El usuario no existe.',
            'project_role.required' => 'Selecciona un rol.',
            'project_role.in'       => 'Rol inválido.',
        ]);

        // Evitar duplicados
        if ($project->members->contains($request->user_id)) {
            return back()->with('error', 'El usuario ya es miembro de este proyecto.');
        }

        $project->members()->attach($request->user_id, [
            'project_role' => $request->project_role,
        ]);

        return back()->with('success', 'Miembro agregado correctamente.');
    }

    public function destroy(Project $project, User $user)
    {
        $this->authorize('manageMembers', $project);

        if ($project->owner_id === $user->id) {
            return back()->with('error', 'No puedes quitar al dueño del proyecto.');
        }

        $project->members()->detach($user->id);

        return back()->with('success', 'Miembro removido correctamente.');
    }
}