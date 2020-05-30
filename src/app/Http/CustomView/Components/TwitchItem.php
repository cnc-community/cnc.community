<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class TwitchItem extends AbstractCustomView
{
    private $title;
    private $url;
    private $username;
    private $image;
    private $viewers;

    public function __construct($title, $url, $username, $image, $viewers)
    {
        $this->title = $title;
        $this->url = $url;
        $this->username = $username; 
        $this->image = $image;
        $this->viewers = $viewers;

        $this->renderContents();
    }

    public function render()
    {
        ?>
            <div class="item twitch-embed">
                <div class="stream-header">
                    <div class="stream-title">
                        <h3>
                            <a href="<?php echo $this->url; ?>" 
                                rel="nofollow" 
                                target="_blank" 
                                title="<?php echo $this->username; ?>">
                                <?php echo $this->username; ?>
                            </a>
                        </h3>
                    </div>
                    <div class="viewer-count">
                        <?php echo $this->viewers; ?> viewers
                    </div>
                </div>
                <div class="preview">
                    <a href="<?php echo $this->url; ?>" rel="nofollow" target="_blank" title="<?php echo $this->username; ?>">
                        <img src="<?php echo $this->image; ?>" alt="Stream preview from <?php echo $this->username; ?>" />
                    </a>
                </div>
                <div class="description">
                    <p>
                        <?php echo $this->title; ?>
                    </p>
                </div>
            </div>
        <?php
    }
}