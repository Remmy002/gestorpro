<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gestorpro.com'],
            ['name' => 'Administrador', 'password' => Hash::make('password')]
        );
        $admin->assignRole('admin');

        $lider = User::firstOrCreate(
            ['email' => 'lider@gestorpro.com'],
            ['name' => 'Líder Demo', 'password' => Hash::make('password')]
        );
        $lider->assignRole('lider');

        $colaborador = User::firstOrCreate(
            ['email' => 'colaborador@gestorpro.com'],
            ['name' => 'Colaborador Demo', 'password' => Hash::make('password')]
        );
        $colaborador->assignRole('colaborador');

        $invitado = User::firstOrCreate(
            ['email' => 'invitado@gestorpro.com'],
            ['name' => 'Invitado Demo', 'password' => Hash::make('password')]
        );
        $invitado->assignRole('invitado');

        $project = Project::firstOrCreate(
            ['nombre' => 'Proyecto Demo'],
            [
                'descripcion' => 'Proyecto de demostración inicial.',
                'estado'      => 'activo',
                'owner_id'    => $lider->id,
            ]
        );

        $project->members()->syncWithoutDetaching([
            $lider->id       => ['project_role' => 'lider'],
            $colaborador->id => ['project_role' => 'colaborador'],
            $invitado->id    => ['project_role' => 'invitado'],
        ]);
    }
}