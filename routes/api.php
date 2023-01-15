<?php

use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Thread;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/api/internal')->group(function () {
    Route::get('/categories', [HomeController::class, 'index'])->name('api-categories');
    Route::get('/threads/count/{forum_id}', function ($forum_id) {
        return response()->json(count(Thread::where('forum_id', $forum_id)->get()));
    })->name('api-thread-count');
});
