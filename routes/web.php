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

Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [AuthController::class, 'authenticate'])->middleware('guest');
Route::get('/signup', [AuthController::class, 'signUp'])->middleware('guest');
Route::post('/signup', [AuthController::class, 'store'])->middleware('guest');

Route::post('/signout', [AuthController::class, 'signOut'])->middleware('auth');

Route::get('/dashboard', function () {
  return view('dashboard.index', [
    'title' => 'Dashboard'
  ]);
})->middleware('auth');
