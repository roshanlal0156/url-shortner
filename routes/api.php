<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login')->middleware('web');
Route::get('create-super-admin', [SuperAdminController::class, 'testCreate']);
Route::get('invite', [SuperAdminController::class, 'invite'])->name('sa.invite');