<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');
        return $this->user()->can('update', $task);
    }

    public function rules(): array
    {
        return [
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'estado'      => 'required|in:pendiente,en_progreso,completada',
            'prioridad'   => 'required|in:baja,media,alta',
            'due_date'    => 'nullable|date',
            'assignee_id' => 'nullable|exists:users,id',
        ];
    }
}