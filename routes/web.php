<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'check'])->name('home');
Route::get('/re/{shortUrlCode}', [ShortUrlController::class, 'redirect']);
Route::get('/sa/dashboard', [SuperAdminController::class, 'dashboard'])->name('sa.dashboard')->middleware('role:super_admin');
Route::get('/sa/clients', [SuperAdminController::class, 'clients'])->name('sa.clients')->middleware('role:super_admin');
Route::get('/sa/generated-short-urls', [SuperAdminController::class, 'generatedShortUrls'])->name('sa.generatedShortUrls')->middleware('role:super_admin');
Route::get('/sa/invite', [SuperAdminController::class, 'getInviteForm'])->name('sa.inviteform')->middleware('role:super_admin');

Route::get('/a/invite', [AdminController::class, 'getInviteForm'])->name('a.inviteform')->middleware('role:admin');
Route::get('/a/dashboard', [AdminController::class, 'dashboard'])->name('a.dashboard')->middleware('role:admin');

Route::get('/m/dashboard', [MemberController::class, 'dashboard'])->name('m.dashboard')->middleware('role:member');

Route::get('/generate', [ShortUrlController::class, 'getGenerateShortUrlForm'])->name('generate-form');
Route::get('/a/generated-short-urls', [AdminController::class, 'generatedShortUrls'])->name('a.generateShortUrls')->middleware('role:admin');
Route::get('/a/members', [AdminController::class, 'members'])->name('a.members')->middleware('role:super_admin');