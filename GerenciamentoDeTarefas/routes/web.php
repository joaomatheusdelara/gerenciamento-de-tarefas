<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController; 
Route::get('/', function () {
    return 'entre no link http://127.0.0.1:8000/tarefas para ver sua lista de tarefas!';
});

Route::get('/tarefas', [TarefaController::class, 'index']);
Route::post('/tarefas', [TarefaController::class, 'store'])->name('tarefas.store');
Route::delete('/tarefas/{id}', [TarefaController::class, 'destroy'])->name('tarefas.destroy');
Route::put('/tarefas/{id}', [TarefaController::class, 'update'])->name('tarefas.update');
Route::get('/tarefas/{id}', [TarefaController::class, 'show'])->name('tarefas.show');


