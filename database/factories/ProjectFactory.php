<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre'      => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraph(),
            'estado'      => $this->faker->randomElement(['activo', 'pausado', 'finalizado']),
            'owner_id'    => User::factory(),
        ];
    }
}