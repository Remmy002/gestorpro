<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $this->authorize('create', Comment::class);

        $request->validate([
            'cuerpo' => 'required|string|max:1000',
        ], [
            'cuerpo.required' => 'El comentario no puede estar vacío.',
        ]);

        $task->comments()->create([
            'cuerpo'  => $request->cuerpo,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Comentario agregado.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('success', 'Comentario eliminado.');
    }
}