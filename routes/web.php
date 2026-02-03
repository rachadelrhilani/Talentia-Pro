<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('loginForm');

Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profil personnel
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Mot de passe
    Route::get('/profile/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/profile/password', [PasswordController::class, 'update'])->name('password.update');

    // Recherche utilisateurs
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});
Route::middleware(['auth', 'role:candidat'])
    ->prefix('candidat')
    ->name('candidat.')
    ->group(function () {


    // Offres
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

    // Postuler
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');

    // Amis
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends');
    Route::post('/friends/{user}', [FriendshipController::class, 'send']);
    Route::post('/friends/{friendship}/accept', [FriendshipController::class, 'accept']);
    Route::post('/friends/{friendship}/reject', [FriendshipController::class, 'reject']);
});

Route::middleware(['auth', 'role:recruteur'])
    ->prefix('recruteur')
    ->name('recruteur.')
    ->group(function () {

    // Entreprise
    Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');

    // Offres
    Route::resource('/jobs', JobOfferController::class);

    // Candidatures
    Route::get('/jobs/{job}/applications',
        [ApplicationController::class, 'index']
    )->name('jobs.applications');

    // Clôturer offre
    Route::post('/jobs/{job}/close',
        [JobOfferController::class, 'close']
    )->name('jobs.close');
});
