<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class WorkShopItem extends AbstractCustomView
{
    private $title;
    private $previewUrl;
    private $fileUrl;
    private $fileDescription;
    private $timeCreated;
    private $tags;
    private $favourites;
    private $views;

    public function __construct($title, $previewUrl, $timeCreated, $tags, $fileUrl, $favourites, $views)
    {
        $this->title = $title; 
        $this->previewUrl = $previewUrl; 
        $this->timeCreated = $timeCreated; 
        $this->tags = $tags; 
        $this->fileUrl = $fileUrl;
        $this->favourites = $favourites;
        $this->views = $views;

        $this->renderContents();
    }

    public function render()
    {
        ?>
            <article class="article-item">
                <?php if($this->previewUrl):?>
                    <a href="<?php echo $this->fileUrl; ?>" target="_blank" rel="nofollow" title="<?php echo $this->title; ?>">
                        <div class="image">
                            <img src="<?php echo $this->previewUrl ?>" alt="<?php echo $this->title ?>" loading="lazy" />
                        </div>
                    </a>
                <?php endif; ?>
             
                <div class="article-info">
                    <?php /*
                    <?php if($this->type == News::NEWS_EXTERNAL):?>
                    <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="article-type"  rel="nofollow noreferrer" target="_blank">
                        <i class="icon-link"></i>
                    </a>
                    <?php else: ?>
                    <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="article-type" target="self">
                        <i class="icon-article"></i>
                    </a>
                    <?php endif; ?>
                    */?>

                    <h3 class="title">
                        <?php /*
                        <?php if($this->type == News::NEWS_EXTERNAL):?>
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank">
                            <?php echo $this->title ?>
                        </a>
                        <?php else: ?>
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>">
                            <?php echo $this->title ?>
                        </a>
                        <?php endif; ?>
                        */?>
                        <?php echo $this->title ;?>
                    </h3>
                    
                    <div class="article-meta">
                        <div class="meta">
                            <div class="tags">
                                <?php foreach($this->tags as $tag ):?>
                                    <div class="tag">
                                        <?php echo $tag["tag"]; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="date">
                                <p class="published">
                                </p>
                                <p class="read-time">
                                    Favourited (<?php echo $this->favourites;?>)
                                </p>
                                <p class="read-time">
                                    Views (<?php echo $this->views;?>)
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="description">
                        <?php echo $this->fileDescription; ?>
                    </div>

                    <div class="buttons">
                        <?php /*
                        <?php if($this->type == News::NEWS_EXTERNAL):?>
                        <a href="<?php echo $this->url; ?>"
                            title="<?php echo $this->title; ?>"
                            target="_blank"
                             rel="nofollow noreferrer"
                            class="btn btn-readmore">
                            Go to Link 
                        </a>
                        <?php else: ?>
                        <a href="<?php echo $this->url; ?>"
                            title="<?php echo $this->title; ?>"
                            class="btn btn-readmore">
                            Go to Article
                        </a>
                        <?php endif; ?>
                        */?>
                    </div>
                </div>
            </article>
        <?php
    }
}