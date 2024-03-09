<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class OnlineBox extends AbstractCustomView
{
    private $title;
    private $url;
    private $logo;
    private $externalLink;
    private $gameAbrev;
    private $onlineCount;
    private $steamInGameCount;

    public function __construct($title, $url, $logo, $externalLink, $gameAbrev, $onlineCount, $steamInGameCount = null)
    {
        $this->title = $title;
        $this->url = $url;
        $this->logo = $logo;
        $this->externalLink = $externalLink;
        $this->gameAbrev = $gameAbrev;
        $this->onlineCount = $onlineCount;
        $this->steamInGameCount = $steamInGameCount;

        $this->renderContents();
    }

    public function render()
    {
?>
        <a href="<?php echo $this->url; ?>" <?php if ($this->externalLink == true) : ?> target="_blank" rel="nofollow noreferrer" <?php endif; ?> title="<?php echo $this->title; ?>" class="stat-game-box stat-game--image-<?php echo $this->gameAbrev; ?>">

            <div class="stat-game-box-logo">
                <img src="<?php echo $this->logo; ?>" alt="Game Logo" />
            </div>
            <div class="stat-game-online-count">
                <?php echo $this->title; ?>
                <div>
                    <?php if ($this->onlineCount > 0) : ?>
                        <strong><?php echo $this->onlineCount; ?> online</strong>
                    <?php endif; ?>
                </div>
                <div style="color:#e5e5e5">
                    <?php if ($this->steamInGameCount > 0) : ?>
                        <strong style="font-size:1rem"><?php echo $this->steamInGameCount; ?> Players On Steam</strong>
                    <?php endif; ?>
                </div>
            </div>
        </a>
<?php
    }
}
