<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::resource('users', UserController::class);
Route::get('get-users', [UserController::class, 'getUsers'])->name('users.getUsers');


Route::get('/', function () {
    return view('welcome');
});
