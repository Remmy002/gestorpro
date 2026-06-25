<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('crear proyecto');
    }

    public function rules(): array
    {
        return [
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'estado'      => 'required|in:activo,pausado,finalizado',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del proyecto es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in'       => 'El estado debe ser activo, pausado o finalizado.',
        ];
    }
}