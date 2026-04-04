<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\Admin\PermitController;

// Página de validação pública (igual ao link original)
Route::get('/documents/validation/validate', [ValidationController::class, 'validateDocument'])
    ->name('validation.validate');

// Painel administrativo
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('permits', PermitController::class);
});

Route::get('/', function () {
    return redirect()->route('admin.permits.index');
});
