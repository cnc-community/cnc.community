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
    private $subscriptions;

    public function __construct(
            $title, 
            $previewUrl, 
            $timeCreated, 
            $tags, 
            $favourites, 
            $views,
            $description,
            $url,
            $playCount,
            $subscriptions
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
        $this->subscriptions = $subscriptions;

        $this->renderContents();
    }

    public function render()
    {
        ?>
            <article class="item workshop-item">
                <?php if($this->previewUrl):?>
                    <div class="image">
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank" class="image-link">
                            <img src="<?php echo $this->previewUrl ?>" alt="<?php echo $this->title ?>" alt="<?php echo $this->title; ?>" loading="lazy" />
                        </a>
                        <div>
                            
                            <h3 class="title">
                                <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank">
                                <?php echo $this->title ;?>
                                </a>
                            </h3>

                            <?php if($this->timeCreated): ?>
                            <div class="meta-info">
                                <div class="date">
                                    <?php echo date('F j, Y, g:i a',$this->timeCreated); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                                                        
                            <div class="tags">
                                <?php foreach($this->tags as $tag ):?>
                                    <div class="tag">
                                        <?php echo $tag["tag"]; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php if($this->description): ?>
                            <div class="description">
                                <p>
                                    <?php echo $this->description; ?>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
             
                <div class="workshop-info">
                    <div class="file-data">
                        <div class="file-item played">
                            <i class="icon-check"></i> <?php echo $this->subscriptions;?> subs
                        </div>
                        <div class="file-item favourites">
                            <i class="icon-heart"></i> <?php echo $this->favourites;?> favs
                        </div>
                        <div class="file-item views">
                            <i class="icon-eye"></i> <?php echo $this->views;?> views
                        </div>
                    </div>
                </div>
            </article>
        <?php
    }
}