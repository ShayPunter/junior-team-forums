<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ForumController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Forum::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Forums/Index', ['forums' => Forum::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Forums/Create', ['categories' => Category::all()]);
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
            'name' => ['required', 'string'],
            'category' => ['required', 'integer'],
        ]);

        $forum = new Forum();
        $forum->name = $request->input('name');
        $forum->category_id = $request->input('category');
        $forum->position = count(Forum::all()) + 1;
        $forum->save();

        return Redirect::route('forums')->with('success', 'Forum created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Inertia\Response
     */
    public function edit(Forum $forum)
    {
        return Inertia::render('Forums/Edit', ['forum' => $forum, 'categories' => Category::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Forum $forum)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'category' => ['required', 'integer'],
        ]);

        echo $request->name;

        $forum->name = $request->name;
        $forum->category_id = $request->category;
        $forum->update();

        return Redirect::route('forums')->with('success', 'Forum edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Forum $forum)
    {
        $forum->delete();

        return Redirect::route('forums')->with('success', 'Forum deleted successfully.');
    }
}
