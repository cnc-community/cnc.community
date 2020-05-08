<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;
use Illuminate\View\Factory;
use Illuminate\Support\Env;

class Swiper extends AbstractCustomView
{
    private $env;
    public function __construct($env)
    {
        $this->env = $env;
        $this->renderContents();
    }

    public function render()
    {
        ?>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <a href="red-alert" class="swiper-slide box red-alert" title="How to play Red Alert">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/red-alert-logo.png" alt="Red Alert logo" />
                        </div>
                    </a>

                    <div class="swiper-slide box tiberian-sun">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/tiberian-sun-logo.png" alt="Tiberian Sun logo" />
                        </div>
                    </div>

                    <div class="swiper-slide box red-alert-2">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/red-alert-logo.png" alt="Red Alert logo" />
                        </div>
                    </div>

                    <div class="swiper-slide box renegade">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/renegade-logo.png" alt="Renegade logo" />
                        </div>
                    </div>

                    <div class="swiper-slide box generals">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/generals-logo.png" alt="Generals logo" />
                        </div>
                    </div>

                    <div class="swiper-slide box red-alert-3">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/red-alert-3-logo.png" alt="Red Alert 3 logo" />
                        </div>
                    </div>

                    <div class="swiper-slide box cnc-3">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/cnc-3-logo.png" alt="C&C 3 logo" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            <?php $this->env->startSection('scripts'); ?>
            <script src="assets/vendor/swiper.min.js"></script>
            <script>
                (function(){
                    let swiper = new Swiper(".swiper-container", {
                        slidesPerView: 1,
                        loop: true, 
                        spaceBetween: 30,
                        freeMode: true,
                        autoplay: true,
                        pagination: false,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        breakpoints: {
                            340: {
                                slidesPerView: 2,
                                spaceBetween: 10,
                            },
                            768: {
                                slidesPerView: 5,
                                spaceBetween: 10,
                            },
                            1024: {
                                slidesPerView: 7,
                                spaceBetween: 10,
                            },
                            1280: {
                                slidesPerView: 8,
                                spaceBetween: 10,
                            },
                        }
                    });
                })();
            </script>
            <?php $this->env->stopSection(); ?>
        <?php 
    }
}