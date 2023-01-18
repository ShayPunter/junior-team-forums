<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Validates, uploads and returns an image URL
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg'],
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $path = public_path('images/');
        $image->move($path, $imageName);

        $imageUrl = asset('images/'.$imageName);

        return response()->json(['url' => $imageUrl]);
    }
}
