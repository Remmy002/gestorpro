<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $projects = Project::with('owner')->latest()->paginate(10);
        } else {
            $projects = $user->projects()->with('owner')->latest()->paginate(10);
        }

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create([
            ...$request->validated(),
            'owner_id' => auth()->id(),
        ]);

        // Agregar al creador como líder en la tabla pivote
        $project->members()->attach(auth()->id(), ['project_role' => 'lider']);

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load(['owner', 'members', 'tasks.assignee', 'tasks.comments']);
        $members = $project->members;

        return view('projects.show', compact('project', 'members'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')
                         ->with('success', 'Proyecto eliminado correctamente.');
    }
}