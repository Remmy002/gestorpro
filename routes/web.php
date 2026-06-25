<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\AdminUserController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Proyectos
    Route::resource('projects', ProjectController::class);

    // Tareas anidadas a proyectos
    Route::resource('projects.tasks', TaskController::class)->shallow();

    // Cambio de estado y reasignación
    Route::patch('tasks/{task}/status', [TaskController::class, 'status'])->name('tasks.status');
    Route::patch('tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');

    // Comentarios
    Route::post('tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Miembros
    Route::post('projects/{project}/members', [MemberController::class, 'store'])->name('projects.members.store');
    Route::delete('projects/{project}/members/{user}', [MemberController::class, 'destroy'])->name('projects.members.destroy');

    // Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/roles', [AdminUserController::class, 'assignRole'])->name('users.assignRole');
    });

});