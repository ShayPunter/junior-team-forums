<?php

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ImageController;
use App\Models\Thread;
use App\Models\ThreadReplies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/internal')->group(function () {
    Route::get('/categories', [FrontendController::class, 'index'])->name('api-categories');

    Route::get('/threads/count/{forum_id}', function ($forum_id) {
        return response()->json(count(Thread::where('forum_id', $forum_id)->get()));
    })->name('api-thread-count');

    Route::get('/threads/replies/count/{thread_id}', function ($thread_id) {
        return response()->json(count(ThreadReplies::where('forum_id', $thread_id)->get()));
    })->name('api-thread-replies-count');

    Route::get('/forum/', [FrontendController::class, 'show'])->name('api-forum');

    Route::get('/user/{id}/public', function ($id) {
        $name = \App\Models\User::where('id', $id)->pluck('name');
        $profile = \App\Models\User::where('id', $id)->pluck('profile_photo_url');

        return response()->json(['user_profile' => ['name' => $name, 'profile_photo_url' => $profile]]);
    })->name('api-user');

    Route::get('/threadReplies/{thread_id}', function ($thread_id) {
        // loop through thread replies to get user
        $threadRepliesArray = [];

        foreach (ThreadReplies::where('thread_id', $thread_id)->get() as $threadReply) {
            $user = User::where('id', $threadReply->user_id)->first();

            $threadRepliesArray[] = ['threadReply' => $threadReply, 'poster' => ['name' => $user->name, 'role' => $user->getRoleNames(), 'profile_photo_url' => $user->profile_photo_url]];
        }

        return response()->json($threadRepliesArray);
    })->name('api-thread-replies');

    Route::post('/uploadImage', [ImageController::class, 'uploadImage'])->name('api-uploadImage');

    Route::post('/permission-check', function (Request $request) {
        $user = User::find($request->user);
        $roles = $user->getRoleNames();

        if ($roles->contains('admin')) {
            return response()->json(['can' => true]);
        }

        if ($user->can($request->permission)) {
            return response()->json(['can' => true]);
        }

        return response()->json(['can' => false]);
    })->name('permission-check');
});
