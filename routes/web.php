<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\TypePeopleController;
use App\Http\Controllers\TypeStageController;
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

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'typeStage',
    'controller' => TypeStageController::class,
], function () {
    Route::get('/', 'index')->name('typeStage');
    Route::post('/', 'store')->name('typeStage.store');
    Route::patch('/{typeStage}', 'update')->name('typeStage.update');
    Route::delete('/{typeStage}', 'destroy')->name('typeStage.destroy');
});

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'people',
    'controller' => PeopleController::class,
], function () {
    Route::get('/', 'index')->name('people');
    Route::post('/', 'store')->name('people.store');
    Route::put('/{people}', 'update')->name('people.update');
    Route::delete('/{people}', 'destroy')->name('people.destroy');
});

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'processes',
    'controller' => ProcessController::class,
], function () {
    Route::get('/', 'index')->name('processes');
    Route::get('/create', 'create')->name('processes.create');
    Route::post('/', 'store')->name('processes.store');
    Route::get('/{process}', 'show')->name('processes.show');
    Route::get('/{process}/edit', 'edit')->name('processes.edit');
    Route::put('/{process}', 'update')->name('processes.update');
    Route::delete('/{process}', 'destroy')->name('processes.destroy');
    Route::put('/{process}/changeStatus', 'changeStatus')->name('processes.changeStatus');
});

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'stages',
    'controller' => StageController::class,
], function () {

    Route::get('/{process}/create', 'create')->name('stages.create');
    Route::get('/edit/{stage}', 'edit')->name('stage.edit');
    Route::put('/{stage}', 'update')->name('stage.update');
    Route::delete('/{stage}', 'destroy')->name('stage.destroy');
    Route::put('/{stage}/changeStatus', 'changeStatus')->name('stage.changeStatus');
    Route::get('/{stage}', 'show')->name('stages.show');
    Route::post('/', 'store')->name('stages.store');
});



require __DIR__.'/auth.php';
