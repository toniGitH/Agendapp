<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//  ENTRY ROUTE
    Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

//  ROUTES FOR NON AUTHENTICATED USERS
    Route::middleware('guest')->group(function () {
        // Access to login and register forms
        Route::get('/access', [AuthController::class, 'access'])->name('access');
        // Login route
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        // Register route
        Route::post('/register', [AuthController::class, 'register'])->name('register');
    });

//  ROUTES FOR AUTHENTICATED USERS
    Route::middleware('auth')->group(function () {
        // Logout route
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        // Contacts routes
        Route::resource('contacts', ContactController::class);
        
        Route::delete('/contacts/{user}/all', [ContactController::class, 'destroyAll'])->name('contacts.destroy.all');
        Route::post('/contacts/{user}/transfer', [ContactController::class, 'transferAll'])->name('contacts.transfer');
        
        // User routes
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/users/{user}/profile', [UserController::class, 'profile'])->name('users.profile');
    });




