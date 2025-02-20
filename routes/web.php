<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\TaskDashboard;
use App\Livewire\TaskManager;
use App\Livewire\UserManger;

Route::redirect('/', '/login');

Route::redirect('dashboard', 'task-dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('task-dashboard', TaskDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('task-dashboard');

Route::get('task-manager', TaskManager::class)
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('task-manager');
    
Route::get('user-manager', UserManger::class)
    ->middleware(['auth', 'role:admin',])
    ->name('user-manager');    

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
