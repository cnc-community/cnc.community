<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class Avatar extends AbstractCustomView
{
    private $title;
    private $imgSrc;

    public function __construct($title, $imgSrc)
    {
        $this->title = $title;
        $this->imgSrc = $imgSrc;

        $this->renderContents();
    }

    public function render()
    {
        ?>
        <div class="profile-avatar" aria-label="Avatar for <?php echo $this->title; ?>">
            <div class="profile-avatar-fx"></div>
            <div class="profile-avatar-image" style="background-image: url(<?php echo $this->imgSrc; ?>)"></div>
        </div>
        <?php
    }
}