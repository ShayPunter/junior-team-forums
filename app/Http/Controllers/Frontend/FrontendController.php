<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\ThreadReplies;
use Inertia\Inertia;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::all();
        $forumArray = [];
        $forumSubArray = [];

        foreach ($categories as $category) {
            $forums = Forum::where('category_id', $category->id)->get();

            foreach ($forums as $forum) {
                $forumSubArray[] = ['forum' => $forum, 'threadCount' => count(Thread::where('forum_id', $forum->id)->get())];
            }

            $forumArray[] = ['category' => $category, 'forums' => $forumSubArray];
            $forumSubArray = [];
        }

        return response()->json(['categories' => $forumArray]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Forum $forum)
    {
        $threads = [];

        foreach (Thread::where('forum_id', $forum->id)->get() as $thread) {
            $threads = [$thread, 'replies' => count(ThreadReplies::where('thread_id', $thread->id)->get())];
        }

        return response()->json(['forum' => $forum, 'threads' => $threads]);
    }

    /**
     * Display the forum resource with thread
     *
     * @param $id
     * @return \Inertia\Response
     */
    public function get_forum($id)
    {
        $threads = [];

        foreach (Thread::where('forum_id', $id)->get() as $thread) {
            $threads[] = ['thread' => $thread, 'replies' => count(ThreadReplies::where('thread_id', $thread->id)->get())];
        }

        return Inertia::render('Forum', ['forum' => Forum::where('id', $id)->first(), 'threads' => $threads]);
    }
}
