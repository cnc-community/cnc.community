<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Image;
use App\News;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->test();
        $news = News::all();
        return view('home', ["news" => $news]);
    }

    private function test()
    {
        // $xml = simplexml_load_file("https://forums.cncnz.com/forum/27-command-conquer-news.xml/") or die("Failed to load");
        $xml = simplexml_load_file("https://www.ppmsite.com/news/rss/ppm_all.xml") or die("Failed to load");
        foreach($xml->channel->children() as $newsItem)        
        {
            if ($newsItem == null)
            {
                continue;
            }

    
            if (strlen($newsItem->title) > 0)
            {
                $feed_uuid = sha1($newsItem->link);
                
                $news = News::where("feed_uuid", $feed_uuid)->first();
                if ($news != null)
                {
                    continue;
                }

                $news = new News();
                $news->title = $newsItem->title;

                preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $newsItem->description, $result);
                
                $foo = array_pop($result);
                if ($foo)
                {
                    $image = Image::make($foo)
                        ->resize(600, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                    $photo = Image::canvas(600, 337.50, "#000")
                        ->insert($image, 'center', 0, 0)
                        ->encode('jpg', 75);

                    $file = sha1($foo).".jpg";
                    Storage::disk('public')->put($file, $photo);

                    $path = asset('storage/' . $file);

                    $news->image = $path;

                    echo "<img src='" . $path . "' />";
                }
                
                // echo "<div>";
                // echo strip_tags($newsItem->description);
                // echo "</div>";
                
                echo "</div>";

                $news->url = $newsItem->url;
                $news->post = strip_tags($newsItem->description, ["<p><a>"]);
                $news->feed_uuid = $feed_uuid;
                $news->save();
            }
        }
        
    }
}
