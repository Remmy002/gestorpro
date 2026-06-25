<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titulo'      => $this->faker->sentence(4),
            'descripcion' => $this->faker->paragraph(),
            'estado'      => $this->faker->randomElement(['pendiente', 'en_progreso', 'completada']),
            'prioridad'   => $this->faker->randomElement(['baja', 'media', 'alta']),
            'due_date'    => $this->faker->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'project_id'  => Project::factory(),
            'assignee_id' => User::factory(),
        ];
    }
}