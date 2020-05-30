<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;
use App\News;

class NewsItem extends AbstractCustomView
{
    private $title;
    private $url;
    private $post;
    private $image;
    private $publishedDate;
    private $type;

    public function __construct($title, $url, $post, $image, $category, $publishedDate, $readTime, $type)
    {
        $this->title = $title;
        $this->url = $url;
        $this->post = $post; 
        $this->image = $image;
        $this->category = $category;
        $this->publishedDate = $publishedDate;
        $this->readTime = $readTime;
        $this->type = $type;

        $this->renderContents();
    }

    public function render()
    {
        ?>
            <article class="item news-item <?php if(!$this->image): ?>no-image<?php endif; ?>">
                <div class="image">
                    <?php if($this->image): ?>
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank" class="image-link">
                            <img src="<?php echo $this->image ?>" alt="<?php echo $this->title ?>" alt="<?php echo $this->title; ?>" loading="lazy" />
                        </a>
                    <?php endif; ?>
                    <div>
                        <h3 class="title">
                            <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank">
                                <?php echo $this->title ;?>
                            </a>
                        </h3>
                        <?php if($this->publishedDate): ?>
                        <div class="meta-info">
                            <div class="date">
                                <?php echo $this->publishedDate; ?>
                            </div>
                            <div clacss="type">
                                <?php if($this->type == News::NEWS_EXTERNAL): ?>
                                Link
                                <?php else: ?>
                                Article
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    
                        <?php if($this->post): ?>
                        <div class="description">
                            <?php echo $this->post; ?>
                        </div>
                        <?php endif; ?>
                        <div class="buttons flex">
                            <?php if($this->type == News::NEWS_EXTERNAL): ?>
                            <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="btn btn-icon btn-readmore"  rel="nofollow noreferrer" target="_blank">
                                Go to link <i class="icon-link"></i>
                            </a>
                            <?php else: ?>
                            <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="btn btn-icon btn-readmore" target="self">
                                Read article <i class="icon-article"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </article>
            <?php
    }
}