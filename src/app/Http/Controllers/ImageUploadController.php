<?php

namespace App\Http\Controllers;

use App\Http\Services\FeedHelper;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload'))
        {
            $image = FeedHelper::createImageFromUrl($request->upload);

            return response()->json(['url' => asset($image), 'uploaded' => true]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
