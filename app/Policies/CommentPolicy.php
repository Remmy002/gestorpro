<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    // Crear comentario: cualquier miembro del proyecto
    public function create(User $user): bool
    {
        return $user->can('comentar');
    }

    // Eliminar comentario: admin o autor del comentario
    public function delete(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin')
            || $comment->user_id === $user->id;
    }
}