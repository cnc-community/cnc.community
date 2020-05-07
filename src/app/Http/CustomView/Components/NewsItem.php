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
    private $category;
    private $publishedDate;
    private $readTime;
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
         <article class="article-item">
                <?php if($this->image):?>
                    <div class="image">
                        <img src="<?php echo $this->image ?>" alt="<?php echo $this->title ?>" />
                    </div>
                <?php endif; ?>

                <div class="article-info">
                    <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="article-type" rel="nofollow" target="_blank">
                        <i class="icon-link"></i>
                    </a>

                    <h3 class="title">
                        <?php echo $this->title ?>
                    </h3>

                    <div class="article-meta">
                        <div class="meta">
                            <div class="tags">
                                <div class="tag">
                                    <?php echo $this->category ?>
                                </div>
                            </div>
                            <div class="date">
                                <p class="published">Posted <?php echo $this->publishedDate ?></p>
                                <?php if($this->type == News::NEWS_INTERNAL) : ?>
                                <p class="read-time"><?php echo $this->readTime ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="description">
                        <?php echo $this->post; ?>
                    </div>

                    <div class="buttons">
                        <a href="<?php echo $this->url; ?>"
                            title="<?php echo $this->title; ?>"
                            target="_blank"
                            rel="nofollow"
                            class="btn btn-readmore">
                            View Article
                        </a>
                    </div>
                </div>
            </article>
        <?php
    }
}