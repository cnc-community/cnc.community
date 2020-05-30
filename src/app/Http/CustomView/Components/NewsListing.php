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
                        new NewsItem(
                            $newsItem->title, 
                            $newsItem->url(), 
                            $newsItem->excerpt(), 
                            $newsItem->image, 
                            $newsItem->category(),
                            $newsItem->created_at->diffForHumans(),
                            $newsItem->readTime(),
                            $newsItem->type
                        ); 
                        ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php 
    }
}