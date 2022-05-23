<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\User\UserController;

Route::get('',[HomeController::class,'index'])->name('admin.home');
Route::resource('tasks',TaskController::class)->names('admin.tasks');
Route::resource('users',UserController::class)->names('admin.users');