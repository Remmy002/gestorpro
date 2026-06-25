<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    // Ver un proyecto: admin o miembro del proyecto
    public function view(User $user, Project $project): bool
    {
        return $user->hasRole('admin')
            || $project->members->contains($user->id);
    }

    // Crear proyecto: admin o lider
    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'lider']);
    }

    // Editar proyecto: admin o dueño del proyecto
    public function update(User $user, Project $project): bool
    {
        return $user->hasRole('admin')
            || ($user->can('editar proyecto') && $project->owner_id === $user->id);
    }

    // Eliminar proyecto: admin o dueño del proyecto
    public function delete(User $user, Project $project): bool
    {
        return $user->hasRole('admin')
            || ($user->can('eliminar proyecto') && $project->owner_id === $user->id);
    }

    // Gestionar miembros: admin o dueño del proyecto
    public function manageMembers(User $user, Project $project): bool
    {
        return $user->hasRole('admin')
            || ($user->can('gestionar miembros') && $project->owner_id === $user->id);
    }
}