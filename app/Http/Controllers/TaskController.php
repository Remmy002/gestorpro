<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        $this->authorize('create', Task::class);
        $members = $project->members;
        return view('tasks.create', compact('project', 'members'));
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        $project->tasks()->create($request->validated());

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Tarea creada correctamente.');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        $task->load(['project', 'assignee', 'comments.user']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $members = $task->project->members;
        return view('tasks.edit', compact('task', 'members'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.show', $task)
                         ->with('success', 'Tarea actualizada correctamente.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $project = $task->project;
        $task->delete();

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Tarea eliminada correctamente.');
    }

    public function status(Request $request, Task $task)
    {
        $this->authorize('changeStatus', $task);
        $request->validate([
            'estado' => 'required|in:pendiente,en_progreso,completada',
        ]);
        $task->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado actualizado.');
    }

    public function assign(Request $request, Task $task)
    {
        $this->authorize('assign', $task);
        $request->validate([
            'assignee_id' => 'nullable|exists:users,id',
        ]);
        $task->update(['assignee_id' => $request->assignee_id]);

        return back()->with('success', 'Tarea reasignada correctamente.');
    }
}