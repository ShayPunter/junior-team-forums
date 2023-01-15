<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\ThreadController;
use App\Models\Forum;
use App\Models\ThreadReplies;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Thread;

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
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/forums/{id}', function ($id) {
    $threads = [];

    foreach (Thread::where('forum_id', $id)->get() as $thread) {

        $threads[] = ['thread' => $thread, 'replies' => count(ThreadReplies::where('thread_id', $thread->id)->get())];

    }

    return Inertia::render('Forum', ['forum' => Forum::where('id', $id)->first(), 'threads' => $threads]);
})->name('view-forum');

Route::resource('/thread', ThreadController::class)->name('index', 'thread')->name('create', 'thread.notinuse');
Route::get('/forums/{forum_id}/create', [ThreadController::class, 'create'])->name('thread.create');
Route::resource('/threadReplies', \App\Http\Controllers\ThreadRepliesController::class)->name('store', 'threadReplies.store');

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
