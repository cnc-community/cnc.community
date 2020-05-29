<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class WorkShopListingSlider extends AbstractCustomView
{
    private $_workShopItems;
    private $env;
    private $id;

    public function __construct($env, $id, $_workShopItems)
    {
        $this->env = $env;
        $this->id = $id;
        $this->_workShopItems = $_workShopItems;
        $this->renderContents();
    }

    public function render()
    {
        ?>
            <div class="workshop-items">
                <div id="<?php echo $this->id; ?>" class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach($this->_workShopItems as $workShopItem ):?>
                            <div class="swiper-slide">
                            <?php 
                                new WorkShopItem(
                                    $workShopItem->title,
                                    $workShopItem->preview_url,
                                    null,
                                    $workShopItem->tags,
                                    $workShopItem->favorited,
                                    $workShopItem->views,
                                    null,
                                    $workShopItem->steamUrl(),
                                    $workShopItem->lifetime_playtime_sessions,
                                    $workShopItem->subscriptions
                                );
                            ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <?php /*
            <div class="pagination">
            <div class="swiper-pagination"></div>
            </div>
            */?>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            <?php $this->env->startSection('scripts'); ?>
            <script src="/assets/vendor/swiper.min.js"></script>
            <script>
                (function(){
                    let swiper = new Swiper("#<?php echo $this->id; ?>", {
                        slidesPerView: 4,
                        spaceBetween: 25,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        breakpoints: {
                            340: {
                                slidesPerView: 1,
                                allowSlidePrev: true,
                                allowSlideNext: true,
                            },
                            768: {
                                slidesPerView: 2,
                                allowSlidePrev: true,
                                allowSlideNext: true,
                            },
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 20,
                            },
                            1450: {
                                slidesPerView: 4,
                            },
                        }
                    });
                    console.log(swiper);
                })();
            </script>
            <?php $this->env->stopSection(); ?>
        <?php 
    }
}