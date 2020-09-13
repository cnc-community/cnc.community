<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class Avatar extends AbstractCustomView
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
        <?php if($this->avatarUrl == null): ?>
        <div class="profile-avatar" aria-label="Avatar for <?php echo $this->title; ?>">
        <?php else: ?>
        <a class="profile-avatar" href="<?php echo $this->avatarUrl; ?>" rel="nofollow noreferrer" target="_blank" title="Avatar for <?php echo $this->title; ?>">

        <?php endif; ?>
            <div class="profile-avatar-fx"></div>
            <div class="profile-avatar-image" style="background-image: url('<?php echo $this->avatarImageSrc; ?>')"></div>
        
        <?php if($this->avatarUrl == null): ?>
        </div>
        <?php else: ?>
        </a>
        <?php endif; ?>
        <?php
    }
}