<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('loginForm');

    Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {


    // profil personnel
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // mot de passe
    Route::get('/profile/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/profile/password', [PasswordController::class, 'update'])->name('password.update');

    // recherche utilisateurs
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});
Route::middleware(['auth', 'role:candidat'])
    ->prefix('candidat')
    ->name('candidat.')
    ->group(function () {


        // offres
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

        // postuler
        Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');
        Route::get('/applications', [ApplicationController::class, 'getapp'])
            ->name('applications');
        // amis
        Route::get('/friends', [FriendshipController::class, 'index'])->name('friends');
        Route::post('/friends/{user}', [FriendshipController::class, 'send'])->name("send");
        Route::post('/friends/{friendship}/accept', [FriendshipController::class, 'accept'])->name('accept');
        Route::post('/friends/{friendship}/reject', [FriendshipController::class, 'reject'])->name('reject');
    });

Route::middleware(['auth', 'role:recruteur'])
    ->prefix('recruteur')
    ->name('recruteur.')
    ->group(function () {

    Route::get('/jobs/{job}/edit', [JobController::class,'edit'])->name('jobs.edit');
        Route::patch('/jobs/{job}', [JobController::class,'update'])->name('jobs.update');

        // entreprise
        Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');

        // offres
        Route::resource('/jobs', JobOfferController::class);

        // candidatures
        Route::get(
            '/jobs/{job}/applications',
            [ApplicationController::class, 'index']
        )->name('jobs.applications');

        // cloturer offre
        Route::post(
            '/jobs/{job}/close',
            [JobOfferController::class, 'close']
        )->name('jobs.close');
        Route::patch(
            '/recruteur/applications/{application}',
            [ApplicationController::class, 'updateStatus']
        )->name('applications.update');
    });

Route::get('/auth/github', [SocialAuthController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback'])->name('auth.github.callback');

