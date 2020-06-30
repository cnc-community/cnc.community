<?php 

namespace App\Http\Services;

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
        if ($result != null )
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
        $image = Image::make($url)
            ->resize(600, null, function ($constraint) 
            {
                $constraint->aspectRatio();
            });

        // 16:9
        $newImage = Image::canvas(600, 337.50, "#000")
            ->insert($image, 'center', 0, 0)
            ->encode('jpg', 75);
        
        // Unique image name
        $newImagePath = sha1($newImage) . ".jpg";
        Storage::disk('public')->put($newImagePath, $newImage);
        
        return "storage/" . $newImagePath;
    }

    public static function storeImage($file)
    {
        $fileWithoutExtension = $file->getClientOriginalName();
    
        //get filename without extension
        $filename = pathinfo($fileWithoutExtension, PATHINFO_FILENAME);
        
        //Upload File
        $path = $file->store(
            $filename, 'public'
        );

        return "storage/" . $path;
    }
}