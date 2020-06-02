<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class GenericBoxItem extends AbstractCustomView
{
    private $image;
    private $url;
    private $title;
    private $description;

    public function __construct(
        $image,
        $url,
        $title,
        $description
        )
    {
        $this->image = $image;
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->renderContents();
    }

    public function render()
    {
        ?>
            <article class="item generic-box-item">
                    <div class="image">
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank" class="image-link">
                            <img src="<?php echo $this->image ?>" alt="<?php echo $this->title ?>" alt="<?php echo $this->title; ?>" loading="lazy" />
                        </a>

                        <div class="button">
                             <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank" class="btn-link">
                                <i class="icon-link"></i>
                            </a>
                        </div>
                    <div>
                            
                    <h3 class="title">
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank">
                        <?php echo $this->title ;?>
                        </a>
                    </h3>

                    <?php if($this->description): ?>
                    <div class="description">
                        <p>
                            <?php echo $this->description; ?>
                        </p>
                    </div>
                    <?php endif; ?>
            </article>
        <?php
    }
}