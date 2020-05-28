<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class WorkShopItem extends AbstractCustomView
{
    private $title;
    private $previewUrl;
    private $description;
    private $timeCreated;
    private $tags;
    private $favourites;
    private $views;
    private $playCount;

    public function __construct(
        $title, 
        $previewUrl, 
        $timeCreated, 
        $tags, 
        $favourites, 
        $views,
        $description,
        $url,
        $playCount
        )
    {
        $this->title = $title; 
        $this->previewUrl = $previewUrl; 
        $this->timeCreated = $timeCreated; 
        $this->tags = $tags; 
        $this->favourites = $favourites;
        $this->views = $views;
        $this->description = $description;
        $this->url = $url;
        $this->playCount = $playCount;

        $this->renderContents();
    }

    public function render()
    {
        ?>
            <article class="workshop-item">
                <?php if($this->previewUrl):?>
                    <a href="<?php echo $this->url; ?>" target="_blank" rel="nofollow" title="<?php echo $this->title; ?>">
                        <div class="image">
                            <div>
                                <div class="workshop-meta">
                                    <div class="meta">
                                        <div class="tags">
                                            <?php foreach($this->tags as $tag ):?>
                                                <div class="tag">
                                                    <?php echo $tag["tag"]; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <?php if($this->timeCreated): ?>
                                        <div class="date-posted">
                                            <?php echo date('F j, Y, g:i a',$this->timeCreated); ?>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($this->description): ?>
                                        <div class="description">
                                            <p>
                                                <?php echo $this->description; ?>
                                            </p>
                                        </div>
                                        <?php endif; ?>

                                        <div class="file-data">
                                            <!-- <div class="played">
                                                <i class="icon-globe"></i> <?php echo $this->playCount;?>
                                            </div> -->
                                            <div class="favourites">
                                                <i class="icon-heart"></i> <?php echo $this->favourites;?>
                                            </div>
                                            <!-- <div class="views">
                                                <i class="icon-eye"></i> <?php echo $this->views;?>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img src="<?php echo $this->previewUrl ?>" alt="<?php echo $this->title ?>" loading="lazy" />
                        </div>
                    </a>
                <?php endif; ?>
             
                <div class="workshop-info">
                    <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="workshop-type"  rel="nofollow noreferrer" target="_blank">
                        <i class="icon-link"></i>
                    </a>
                    <h3 class="title">
                        <?php echo $this->title ;?>
                    </h3>
                </div>
            </article>
        <?php
    }
}