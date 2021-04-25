<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Image;
use Illuminate\Support\Facades\Storage;

class FeedHelper
{
    public function __construct()
    {
    }

    public static function getImageUrlFromString(string $string)
    {
        preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $string, $result);
        if ($result != null)
        {
            return array_pop($result);
        }
        return null;
    }

    /**
     * Creates image and returns path relative to storage dir
     */
    public static function createImageFromUrl($url)
    {
        try
        {
            $image = Image::make($url)
                ->resize(null, 600, function ($constraint)
                {
                    $constraint->aspectRatio();
                })
                ->encode('jpg', 75);

            // Unique image name
            $newImagePath = sha1($image) . ".jpg";
            Storage::disk('public')->put($newImagePath, $image);

            return "storage/" . $newImagePath;
        }
        catch (Exception $ex)
        {
        }
    }

    public static function storeImage($file)
    {
        $fileWithoutExtension = $file->getClientOriginalName();

        //get filename without extension
        $filename = pathinfo($fileWithoutExtension, PATHINFO_FILENAME);

        //Upload File
        $path = $file->store(
            $filename,
            'public'
        );

        return "storage/" . $path;
    }
}
