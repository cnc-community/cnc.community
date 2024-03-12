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
    private $categories;
    private $feedSource;
    private $author;

    public function __construct($title, $url, $post, $image, $categories, $publishedDate, $readTime, $type, $feedSource, $author)
    {
        $this->title = $title;
        $this->url = $url;
        $this->post = $post;
        $this->image = $image;
        $this->categories = $categories;
        $this->publishedDate = $publishedDate;
        $this->readTime = $readTime;
        $this->type = $type;
        $this->feedSource = $feedSource;
        $this->author = $author;

        $this->renderContents();
    }

    public function render()
    {
?>
        <article class="item news-item">
            <div class="image">
                <?php if ($this->type == News::NEWS_EXTERNAL) : ?>
                    <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank" class="image-link">
                    <?php else : ?>
                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="btn-link">
                        <?php endif; ?>

                        <?php if ($this->image) : ?>
                            <img src="/<?php echo $this->image ?>" alt="<?php echo $this->title; ?>" />
                        <?php else : ?>
                            <img src="/static/no-image.jpg" alt="<?php echo $this->title; ?>" />
                        <?php endif; ?>
                        </a>

                        <div class="button">
                            <?php if ($this->type == News::NEWS_EXTERNAL) : ?>
                                <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="btn-link" rel="nofollow noreferrer" target="_blank">
                                    <i class="icon-link" aria-label="Link Icon"></i>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" class="btn-link">
                                    <i class="icon-article" aria-label="Article Icon"></i>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div>
                            <div class="post-meta">
                                <div class="meta-author">
                                    <div class="author">
                                        <?php if ($this->feedSource) : ?>
                                            <div class="avatar <?php echo strtolower($this->feedSource); ?>"></div>
                                        <?php else : ?>
                                            <div class="avatar" style="background-image: url(/static/logo.svg)">
                                            </div>
                                        <?php endif; ?>

                                        <div class="author-data">
                                            <div class="name">
                                                <?php if ($this->feedSource) : ?>
                                                    <?php echo $this->feedSource; ?>
                                                <?php elseif ($this->author) : ?>
                                                    <?php echo $this->author->name; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="date"><?php echo $this->publishedDate; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="post-preview">
                                <h3 class="title">
                                    <?php if ($this->type == News::NEWS_EXTERNAL) : ?>
                                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>" rel="nofollow noreferrer" target="_blank">
                                            <?php echo $this->title; ?>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo $this->url; ?>" title="<?php echo $this->title; ?>">
                                            <?php echo $this->title; ?>
                                        </a>
                                    <?php endif; ?>
                                </h3>
                                <?php if ($this->publishedDate) : ?>
                                    <div class="categories">
                                        <?php foreach ($this->categories as $category) : ?>
                                            <div class="category">
                                                <a href="/news/<?php echo $category->slug; ?>" title="<?php echo $category->name; ?>">
                                                    <?php echo $category->name; ?>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->post) : ?>
                                    <div class="description">
                                        <p>
                                            <?php echo $this->post; ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
            </div>
        </article>
<?php
    }
}
