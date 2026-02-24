<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/colocations', [ColocationController::class, 'index'])
        ->name('colocations.index');

    Route::get('/colocations/create', [ColocationController::class, 'create'])
        ->name('colocations.create');

    Route::post('/colocations', [ColocationController::class, 'store'])
        ->name('colocations.store');

    Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])
        ->name('colocations.show');

    Route::get('/colocations/{colocation}/edit', [ColocationController::class, 'edit'])
        ->name('colocations.edit');

    Route::put('/colocations/{colocation}', [ColocationController::class, 'update'])
        ->name('colocations.update');

    Route::get('/colocations/{colocation}/expenses', [ExpenseController::class, 'index'])
        ->name('dépenses.index');

    Route::get('/colocations/{colocation}/expenses/create', [ExpenseController::class, 'create'])
        ->name('dépenses.create');

    Route::post('/colocations/{colocation}/expenses', [ExpenseController::class, 'store'])
        ->name('dépenses.store');

    Route::get('/colocations/{colocation}/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::post('/colocations/{colocation}/categories', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::get('/colocations/{colocation}/invitations', [InvitationController::class, 'index'])
        ->name('invitations.index');

    Route::post('/colocations/{colocation}/invitations', [InvitationController::class, 'store'])
        ->name('invitations.store');

    Route::get('/colocations/{colocation}/payments', [PaymentController::class, 'index'])
        ->name('payments.index');

    Route::post('/colocations/{colocation}/payments', [PaymentController::class, 'store'])
        ->name('payments.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('users.index');

    Route::post('/users/{user}/ban', [AdminUserController::class, 'ban'])
        ->name('users.ban');

    Route::post('/users/{user}/unban', [AdminUserController::class, 'unban'])
        ->name('users.unban');

});

require __DIR__.'/auth.php';
