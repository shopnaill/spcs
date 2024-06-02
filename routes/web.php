<?php

use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Http\Controllers\SupportRequestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Route::get('/api/support-request', [SupportRequestController::class, 'receive']);
Route::get('/dashboard', [SupportRequestController::class, 'dashboard']);
Route::get('/home', [SupportRequestController::class, 'dashboard'])->name('home');

Auth::routes();

