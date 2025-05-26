<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('tasks.index'));

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $tasks = $user
        ->tasks()            
        ->where('completed', true)
        ->latest()
        ->get();

    return view('dashboard', compact('tasks'));
})->middleware(['auth', 'verified'])
  ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
         ->name('profile.destroy');

     Route::resource('tasks', TaskController::class)
          ->only(['index', 'create', 'store', 'update', 'edit', 'destroy']);

    Route::get('tasks/{task}', fn() => redirect()->route('tasks.index'));
});

require __DIR__.'/auth.php';

