<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Thread;
use App\Models\ThreadReplies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Stevebauman\Purify\Facades\Purify;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create($forum_id)
    {
        return Inertia::render('ThreadCreate', ['forum' => $forum_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required'],
            'forum' => ['required', 'integer'],
        ]);

        $thread = new Thread();
        $thread->title = $request->input('title');
        $thread->content = Purify::clean($request->input('content'));
        $thread->forum_id = $request->input('forum');
        $thread->user_id = Auth::user()->id;
        $thread->locked = false;
        $thread->save();

        return Redirect::route('thread.show', $thread);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Inertia\Response
     */
    public function show(Thread $thread)
    {
        $poster = User::where('id', $thread->user_id)->first();

        return Inertia::render('Thread', ['thread' => $thread, 'poster' => ['name' => $poster->name, 'role' => $poster->getRoleNames(), 'profile_photo_url' => $poster->profile_photo_url], 'replies' => count(ThreadReplies::where('thread_id', $thread->id)->get())]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
