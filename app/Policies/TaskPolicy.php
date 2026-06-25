<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    // Ver tarea: admin o miembro del proyecto
    public function view(User $user, Task $task): bool
    {
        return $user->hasRole('admin')
            || $task->project->members->contains($user->id);
    }

    // Crear tarea: admin, lider o colaborador miembro del proyecto
    public function create(User $user): bool
    {
        return $user->can('crear tarea');
    }

    // Editar tarea: admin, lider dueño, o colaborador asignado
    public function update(User $user, Task $task): bool
    {
        return $user->hasRole('admin')
            || ($user->can('editar tarea') && (
                $task->project->owner_id === $user->id
                || $task->assignee_id === $user->id
            ));
    }

    // Eliminar tarea: admin o lider dueño del proyecto
    public function delete(User $user, Task $task): bool
    {
        return $user->hasRole('admin')
            || ($user->can('eliminar tarea') && $task->project->owner_id === $user->id);
    }

    // Cambiar estado: admin, lider o asignado
    public function changeStatus(User $user, Task $task): bool
    {
        return $user->hasRole('admin')
            || $task->project->owner_id === $user->id
            || $task->assignee_id === $user->id;
    }

    // Reasignar tarea: admin o lider dueño
    public function assign(User $user, Task $task): bool
    {
        return $user->hasRole('admin')
            || ($user->can('asignar tarea') && $task->project->owner_id === $user->id);
    }
}