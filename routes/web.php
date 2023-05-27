<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('register');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/check_email', [App\Http\Controllers\HomeController::class, 'check_email'])->name('check_email');
Route::post('/register_user', [App\Http\Controllers\HomeController::class, 'register_user'])->name('register_user');
Route::post('/generate_qr_code', [App\Http\Controllers\HomeController::class, 'generate_qr_code'])->name('generate_qr_code');
Route::get('/edit_profile/{id}', [App\Http\Controllers\HomeController::class, 'edit_profile'])->name('edit_profile');
Route::post('/update_profile', [App\Http\Controllers\HomeController::class, 'update_profile'])->name('update_profile');
Route::get('/show_list', [App\Http\Controllers\HomeController::class, 'show_list'])->name('show_list');
Route::get('/fetch_user_list', [App\Http\Controllers\HomeController::class, 'fetch_user_list'])->name('fetch_user_list');