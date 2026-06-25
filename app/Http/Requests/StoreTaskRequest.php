<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('crear tarea');
    }

    public function rules(): array
    {
        return [
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'estado'      => 'required|in:pendiente,en_progreso,completada',
            'prioridad'   => 'required|in:baja,media,alta',
            'due_date'    => 'nullable|date|after_or_equal:today',
            'assignee_id' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'   => 'El título de la tarea es obligatorio.',
            'estado.in'         => 'Estado inválido.',
            'prioridad.in'      => 'Prioridad inválida.',
            'due_date.after_or_equal' => 'La fecha límite no puede ser anterior a hoy.',
            'assignee_id.exists'=> 'El usuario asignado no existe.',
        ];
    }
}