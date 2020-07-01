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
            <div class="image">
                    <div class="post-meta">
                        <div class="meta-author">
                            <div class="author">
                                <div class="avatar steam"></div>
                                <div class="author-data">
                                    <div class="name"> 
                                        Steam                                                                                    
                                    </div>
                                    <div class="date">
                                    <?php if($this->timeCreated): ?>
                                    <div class="meta-info">
                                        <div class="date"><?php echo date('F j, Y, g:i a',$this->timeCreated); ?></div>
                                    </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank" class="image-link">
                        <img src="<?php echo $this->previewUrl ?>" alt="<?php echo $this->title ?>" alt="<?php echo $this->title; ?>" loading="lazy" />
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
                    </a>
                    <div>
                        <div class="post-preview">
                            <h3 class="title">
                                <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank">
                                <?php echo $this->title ;?>
                                </a>
                            </h3>
                            <div class="categories">
                                <?php foreach($this->tags as $tag ):?>
                                    <div class="category">
                                        <a href="https://steamcommunity.com/workshop/browse/?appid=1213210&requiredtags[]=<?php echo $tag["tag"]; ?>" title="<?php echo $tag["tag"]; ?>" rel="nofollow noreferrer" target="_blank">
                                            <?php echo $tag["tag"]; ?>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        <?php
    }
}