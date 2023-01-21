<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ThreadController;
use App\Http\Controllers\ThreadRepliesController;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\ThreadReplies;
use App\Models\User;
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

// / (home page)
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

// /forums/{id} (gets the forums and threads)
Route::get('/forums/{id}', [FrontendController::class, 'get_forum'])->name('view-forum');

// /thread (thread resource)
Route::resource('/thread', ThreadController::class)->name('index', 'thread')->name('create', 'thread.notinuse');

// /logout-perform (logs out a user when they hit this url)
Route::get('/logout-perform', [\App\Http\Controllers\LogoutController::class, 'logout'])->name('logout.perform');

Route::middleware(['auth:sanctum'])->group(function () {
    // /forums/{forum_id}/create (create thread in forum)
    Route::get('/forums/{forum_id}/create', [ThreadController::class, 'create'])->name('thread.create');

    // /threadReplies (thread-replies resource management route)
    Route::resource('/threadReplies', ThreadRepliesController::class)->name('store', 'threadReplies.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'inject_user_role',
    'can:admin.view',
    'role:admin',
])->prefix('/admin')->group(function () {
    // /admin/dashboard (admin dashboard)
    Route::get('/dashboard', function () {
        $users = count(User::all());
        $threads = count(Thread::all()) + count(ThreadReplies::all());

        return Inertia::render('Dashboard', ['threads' => $threads, 'users' => $users]);
    })->name('dashboard');

    // /users (resource URLs for managing users)
    Route::resource('/users', UserController::class)->name('index', 'users');
    // /roles (resource URLs for managing roles)
    Route::resource('/roles', RolesController::class)->name('index', 'roles');
    // /category (resource URLs for managing forum categories
    Route::resource('/category', CategoriesController::class)->name('index', 'category');
    // /forums (resource URLs for managing forums
    Route::resource('/forums', ForumController::class)->name('index', 'forums');
});
