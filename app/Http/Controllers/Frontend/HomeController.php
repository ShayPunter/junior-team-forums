<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Forum;
use App\Models\Thread;

class HomeController extends Controller
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

        foreach ($categories as $category) {
            $forums = Forum::where('category_id', $category->id)->get();

            $forumArray[] = ['category' => $category, 'forums' => $forums];
        }

        return response()->json(['categories' => $forumArray]);
    }
}
