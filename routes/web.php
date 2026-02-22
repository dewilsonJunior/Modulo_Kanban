<?php

use App\Http\Controllers\KanbanController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [KanbanController::class, 'dashboard'])->name("dashboard");
    Route::post('/salvar-kanban', [KanbanController::class, 'salvarKanban']);
});

require __DIR__ . '/auth.php';
