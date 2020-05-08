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
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank">
                            <img src="<?php echo $this->image ?>" alt="<?php echo $this->title ?>" loading="lazy" />
                        </a>
                    </div>
                <?php endif; ?>

                <div class="article-info">
                    <?php if($this->type == News::NEWS_EXTERNAL):?>
                    <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="article-type"  rel="nofollow noreferrer" target="_blank">
                        <i class="icon-link"></i>
                    </a>
                    <?php else: ?>
                    <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="article-type" target="self">
                        <i class="icon-article"></i>
                    </a>
                    <?php endif; ?>

                    <h3 class="title">
                        <?php if($this->type == News::NEWS_EXTERNAL):?>
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank">
                            <?php echo $this->title ?>
                        </a>
                        <?php else: ?>
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>">
                            <?php echo $this->title ?>
                        </a>
                        <?php endif; ?>
                    </h3>

                    <div class="article-meta">
                        <div class="meta">
                            <div class="tags">
                                <div class="tag">
                                    <a href="/news/<?php echo $this->category->slug; ?>" title="<?php echo $this->category->name;?>">
                                        <?php echo $this->category->name; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="date">
                                <p class="published">
                                    <?php if($this->type == News::NEWS_INTERNAL) : ?>
                                        Article published
                                    <?php else: ?>
                                        Link posted
                                    <?php endif; ?>
                                    <?php echo $this->publishedDate ?>
                                </p>
                                <?php if($this->type == News::NEWS_INTERNAL) : ?>
                                <p class="read-time"><?php echo $this->readTime ?> read</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="description">
                        <?php echo $this->post; ?>
                    </div>

                    <div class="buttons">
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
                    </div>
                </div>
            </article>
        <?php
    }
}