<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthController::class, 'index'])->middleware('guest');
// Route::post('/', [AuthController::class, 'index']);
Route::get('/signup', [AuthController::class, 'signUp'])->middleware('guest');
Route::post('/signup', [AuthController::class, 'store'])->middleware('guest');
