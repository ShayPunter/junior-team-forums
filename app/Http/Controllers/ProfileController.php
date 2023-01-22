<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadReplies;
use App\Models\User;
use Inertia\Inertia;

class ProfileController extends Controller
{

    /**
     * Shows the selected resource
     *
     * @param $id
     * @return \Inertia\Response
     */
    public function show($id) {
        $threads = Thread::where('user_id', $id)->get();
        $threadReplies = ThreadReplies::where('user_id', $id)->get();

        $combined = [];

        foreach ($threads as $thread) {
            $thread->type = 'thread';
            array_push($combined, $thread);
        }

        foreach ($threadReplies as $threadReply) {
            $threadReply->type = 'thread_reply';
            $threadReply->title = Thread::find($threadReply->thread_id)->first()->title;
            array_push($combined, $threadReply);
        }

        usort($combined, function($a, $b) {
            return $b->created_at <=> $a->created_at;
        });

        $user = User::find($id);

        return Inertia::render('Profile', ['profile' => $user, 'activity' => $combined, 'roles' => $user->getRoleNames()]);
    }
}
