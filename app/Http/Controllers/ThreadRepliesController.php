<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadReplies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Purify\Facades\Purify;

class ThreadRepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'replyContent' => ['required'],
            'thread' => ['required', 'integer'],
        ]);

        $threadReplies = new ThreadReplies();
        $threadReplies->user_id = Auth::user()->id;
        $threadReplies->thread_id = $request->thread;
        $threadReplies->content = Purify::clean($request->replyContent);
        $threadReplies->save();

        Log::info('stored thingy: ' . $threadReplies);

        return Redirect::refresh(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThreadReplies  $threadReplies
     * @return \Illuminate\Http\Response
     */
    public function show(ThreadReplies $threadReplies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThreadReplies  $threadReplies
     * @return \Illuminate\Http\Response
     */
    public function edit(ThreadReplies $threadReplies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThreadReplies  $threadReplies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThreadReplies $threadReplies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThreadReplies  $threadReplies
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThreadReplies $threadReplies)
    {
        //
    }
}
