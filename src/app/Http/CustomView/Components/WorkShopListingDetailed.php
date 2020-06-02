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
        <div class="workshop-listings">
            <div class="items-wrap">
                <?php foreach($this->_workShopItems as $workShopItem ):?>
                    <?php 
                    new WorkShopItem(
                        $workShopItem->title,
                        $workShopItem->preview_url,
                        $workShopItem->time_created,
                        $workShopItem->tags,
                        $workShopItem->favorited,
                        $workShopItem->views,
                        $workShopItem->file_description,
                        $workShopItem->steamUrl(),
                        $workShopItem->lifetime_playtime_sessions,
                        $workShopItem->subscriptions
                    );
                    ?>
            <?php endforeach; ?>
            </div>
        </div>
        <?php 
    }
}