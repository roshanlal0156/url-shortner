<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'check'])->name('home');
Route::get('/sa/dashboard', [SuperAdminController::class, 'dashboard'])->name('sa.dashboard');
Route::get('/sa/invite', [SuperAdminController::class, 'getInviteForm'])->name('sa.inviteform');