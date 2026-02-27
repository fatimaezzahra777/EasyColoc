<?php

use App\Http\Controllers\DépensesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class,'index'])
    ->middleware('auth')
    ->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile',    [ProfileController::class, 'edit'])   ->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update']) ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('colocations', ColocationController::class);
   

    Route::prefix('colocations/{colocation}')->group(function () {

        Route::get('/dépenses',        [DépensesController::class, 'index'])  ->name('dépenses.index');
        Route::get('/dépenses/create', [DépensesController::class, 'create']) ->name('dépenses.create');
        Route::post('/dépenses',       [DépensesController::class, 'store'])  ->name('dépenses.store');
        Route::delete('/dépenses/{expense}', [DépensesController::class, 'destroy'])->name('dépenses.destroy');


        Route::get('/categories',          [CategoryController::class, 'index'])  ->name('categories.index');
        Route::post('/categories',         [CategoryController::class, 'store'])  ->name('categories.store');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


        Route::get('/invitations',         [InvitationController::class, 'index'])  ->name('invitations.index');
        Route::get('/invitations/create',  [InvitationController::class, 'create']) ->name('invitations.create');
        Route::post('/invitations',        [InvitationController::class, 'store'])  ->name('invitations.store');
        Route::delete('/invitations/{invitation}', [InvitationController::class, 'cancel'])->name('invitations.cancel');

        Route::get('/payments',            [PaymentController::class, 'index'])  ->name('payments.index');
        Route::get('/payments/create',     [PaymentController::class, 'create']) ->name('payments.create');
        Route::post('/payments',           [PaymentController::class, 'store'])  ->name('payments.store');
        Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
    });

    Route::post('/invitations/{invitation}/accept',  [InvitationController::class, 'accept']) ->name('invitations.accept');
    Route::post('/invitations/{invitation}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');
    Route::post('/colocations/{colocation}/invite', [ColocationController::class, 'sendInvitation'])->name('colocations.invite');
    Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
});


Route::middleware(['auth','is_admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('users.index');

    Route::patch('/users/{user}/ban', [AdminUserController::class, 'ban'])
        ->name('users.ban');

    Route::patch('/users/{user}/unban', [AdminUserController::class, 'unban'])
        ->name('users.unban');
    
    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('users');

});

require __DIR__.'/auth.php';
