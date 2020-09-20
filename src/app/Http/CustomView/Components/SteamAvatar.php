<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class SteamAvatar extends AbstractCustomView
{
    private $title;
    private $avatarImageSrc;
    private $avatarUrl;

    public function __construct($title, $avatarImageSrc, $avatarUrl)
    {
        $this->title = $title;
        $this->avatarImageSrc = $avatarImageSrc;
        $this->avatarUrl = $avatarUrl;

        $this->renderContents();
    }

    public function render()
    {
        ?>
        <div class="steam-avatar">
            
            <?php if($this->avatarUrl): ?>
            <div class="leaderboard-profile-social">
                <a href="<?php echo $this->avatarUrl; ?>" title="Steam for <?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank">
                    <i class="icon-steam"></i>
                </a>
            </div>
            <?php endif; ?>

            <?php new Avatar($this->title, $this->avatarImageSrc, $this->avatarUrl); ?>
        </div>
        <?php 
    }
}