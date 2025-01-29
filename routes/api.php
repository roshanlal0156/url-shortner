<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login')->middleware('web');
Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware(['web']);
Route::get('create-super-admin', [SuperAdminController::class, 'testCreate']);
Route::post('invite', [SuperAdminController::class, 'invite'])->name('sa.invite')->middleware(['web', 'role:super_admin']);
Route::get('sa/clients-list', [SuperAdminController::class, 'clientsList'])->name('sa.clientsList')->middleware(['web', 'role:super_admin']);

Route::post('a/invite', [AdminController::class, 'invite'])->name('a.invite')->middleware('web')->middleware(['web', 'role:admin']);
Route::get('a/short-url-list', [ShortUrlController::class, 'fetch'])->name('a.short-url-list')->middleware('web')->middleware(['web']);
Route::post('generate', [ShortUrlController::class, 'generate'])->name('generate')->middleware('web');