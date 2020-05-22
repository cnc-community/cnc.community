<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class WorkShopListing extends AbstractCustomView
{
    private $_workShopItems;

    public function __construct($_workShopItems)
    {
        $this->_workShopItems = $_workShopItems;
        $this->renderContents();
    }

    public function render()
    {
        ?>
        <section class="articles">
            <?php foreach($this->_workShopItems as $workShopItem ):?>
                <?php 
                    new WorkShopItem(
                        $workShopItem->title,
                        $workShopItem->preview_url,
                        $workShopItem->time_created,
                        $workShopItem->tags,
                        $workShopItem->file_url,
                        $workShopItem->favorited,
                        $workShopItem->views
                    );
                ?>
            <?php endforeach; ?>
        </section>
        <?php 
    }
}