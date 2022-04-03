<?php

use App\Http\Controllers\AdminAlternativeController;
use App\Http\Controllers\AdminCriteriaController;
use App\Http\Controllers\AdminTourismObjectController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardCriteriaComparisonController;
use App\Http\Controllers\DashboardProfileController;
use App\Http\Controllers\DashboardRankController;
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

Route::middleware('guest')->group(function () {
  Route::get('/', [AuthController::class, 'index'])->name('login');
  Route::post('/', [AuthController::class, 'authenticate']);
  Route::get('/signup', [AuthController::class, 'signUp']);
  Route::post('/signup', [AuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {
  Route::post('/signout', [AuthController::class, 'signOut']);

  Route::get('/dashboard', function () {
    return view('dashboard.index', [
      'title' => 'Dashboard'
    ]);
  });

  Route::get('dashboard/profile', [DashboardProfileController::class, 'index']);
  Route::put('dashboard/profile/{user}', [DashboardProfileController::class, 'update']);

  Route::get('dashboard/criteria-comparisons', [DashboardCriteriaComparisonController::class, 'index']);
  Route::post('dashboard/criteria-comparisons', [DashboardCriteriaComparisonController::class, 'store']);

  Route::get('dashboard/criteria-comparisons/{criteria_analysis}', [DashboardCriteriaComparisonController::class, 'show']);

  Route::put('dashboard/criteria-comparisons/{criteria_analysis}', [DashboardCriteriaComparisonController::class, 'updateValue']);

  Route::delete('dashboard/criteria-comparisons/{criteria_analysis}', [DashboardCriteriaComparisonController::class, 'destroy']);

  Route::get('dashboard/criteria-comparisons/result/{criteria_analysis}', [DashboardCriteriaComparisonController::class, 'result']);

  Route::get('dashboard/final-ranking', [DashboardRankController::class, 'index']);
  Route::get('dashboard/final-ranking/{criteria_analysis}', [DashboardRankController::class, 'show']);

  Route::resources([
    'dashboard/tourism-objects' => AdminTourismObjectController::class,
    'dashboard/criterias'       => AdminCriteriaController::class,
    'dashboard/users'           => AdminUserController::class,
    'dashboard/alternatives'    => AdminAlternativeController::class
  ], ['except' => 'show']);
});
