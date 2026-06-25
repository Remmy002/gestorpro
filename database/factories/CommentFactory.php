<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cuerpo'  => $this->faker->sentences(2, true),
            'user_id' => User::factory(),
            'task_id' => Task::factory(),
        ];
    }
}