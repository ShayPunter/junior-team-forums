<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
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
    $categories = \App\Models\Category::all();



    foreach ($categories as $category) {

    }

    return Inertia::render('Welcome', [
        '' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'inject_user_role',
])->prefix('/admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/logout-perform', 'LogoutController@perform')->name('logout.perform');

    Route::resource('/users', UserController::class)->name('index', 'users');
    Route::resource('/roles', RolesController::class)->name('index', 'roles');
    Route::resource('/category', CategoriesController::class)->name('index', 'category');
    Route::resource('/forums', ForumController::class)->name('index', 'forums');
});
