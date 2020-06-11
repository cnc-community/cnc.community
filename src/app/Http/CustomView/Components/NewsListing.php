<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class NewsListing extends AbstractCustomView
{
    private $_newsItems;

    public function __construct($newsItems)
    {
        $this->_newsItems = $newsItems;
        $this->renderContents();
    }

    public function render()
    {
        ?>
            <div class="news-listings">
                <div class="items-wrap">
                    <?php foreach($this->_newsItems as $newsItem):?>
                        <?php 
                        $news = \App\News::find($newsItem->id);
                        if ($news == null) 
                        {
                            continue;
                        }
                        new NewsItem(
                            $news->title, 
                            $news->url(), 
                            $news->excerpt(), 
                            $news->image, 
                            $news->categories(),
                            $news->created_at->diffForHumans(),
                            $news->readTime(),
                            $news->type,
                            $news->feed_source,
                            $news->author()
                        ); 
                        ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php 
    }
}