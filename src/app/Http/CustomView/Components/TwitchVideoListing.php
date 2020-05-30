<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class TwitchVideoListing extends AbstractCustomView
{
    private $_twitchVideos;

    public function __construct($_twitchVideos)
    {
        $this->_twitchVideos = $_twitchVideos;
        $this->renderContents();
    }

    public function render()
    {
        ?>
        <div class="twitch-streams">
            <div class="items-wrap">
                <?php foreach($this->_twitchVideos as $twitchItem):?>
                    <?php 
                        if ($twitchItem["thumbnail_url"] == null) 
                        {
                            continue;
                        }
                    
                        $image = \App\Http\Services\TwitchHelper::getTwitchThumbnailUrl($twitchItem["thumbnail_url"], 960, 540);
                        $url = "https://www.twitch.tv/".$twitchItem['user_name'];
                        new TwitchVideoItem(
                            $twitchItem["title"],
                            $url,
                            $twitchItem["user_name"],
                            $image,
                            $twitchItem["view_count"]
                        ); 
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php 
    }
}