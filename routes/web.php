<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TypePeopleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::group([
    'middleware' => ['auth', 'verified',],
    'prefix' => 'dashboard',
    'controller' => DashboardController::class,
], function () {
    Route::get('/', 'index')->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'users',
    'controller' => UserController::class,
], function () {
    Route::get('/', 'index')->name('users');
    Route::patch('/{user}', 'update')->name('users.update');
});

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'typePeople',
    'controller' => TypePeopleController::class,
], function () {
    Route::get('/', 'index')->name('typePeople');
    Route::post('/', 'store')->name('typePeople.store');
    Route::patch('/{typePeople}', 'update')->name('typePeople.update');
    Route::delete('/{typePeople}', 'destroy')->name('typePeople.destroy');
});



require __DIR__.'/auth.php';
