<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class TwitchListing extends AbstractCustomView
{
    private $_twitchStreams;

    public function __construct($_twitchStreams)
    {
        $this->_twitchStreams = $_twitchStreams;
        $this->renderContents();
    }

    public function render()
    {
        ?>
         <div class="twitch-streams">
            <?php foreach($this->_twitchStreams as $twitchItem):?>
                <?php 
                    $image = \App\Http\Services\TwitchHelper::getTwitchThumbnailUrl($twitchItem["thumbnail_url"], 960, 540);
                    $url = "https://www.twitch.tv/".$twitchItem['user_name'];

                    new TwitchItem(
                        $twitchItem["title"],
                        $url,
                        $twitchItem["user_name"],
                        $image,
                        $twitchItem["viewer_count"]
                    ); 
                ?>
            <?php endforeach; ?>
        </div>
        <?php 
    }
}