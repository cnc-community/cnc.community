<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class GameSlider extends AbstractCustomView
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
                    <a href="tiberian-dawn" class="swiper-slide box tiberian-dawn" title="How to play Tiberian Dawn">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/tiberian-dawn-logo.png" loading="lazy" alt="Tiberian Dawn logo" />
                        </div>
                    </a>
                    <a href="red-alert" class="swiper-slide box red-alert" title="How to play Red Alert">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/red-alert-logo.png" loading="lazy" alt="Red Alert logo" />
                        </div>
                    </a>

                    <a href="tiberian-sun" class="swiper-slide box tiberian-sun" title="How to play Tiberian Sun">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/tiberian-sun-logo.png" loading="lazy" alt="Tiberian Sun logo" />
                        </div>
                    </a>

                    <a href="red-alert-2" class="swiper-slide box red-alert-2" title="How to play Red Alert 2">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/red-alert-2-logo.png" loading="lazy" alt="Red Alert 2 logo" />
                        </div>
                    </a>

                    <a href="renegade" class="swiper-slide box renegade" title="How to play Renegade">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/renegade-logo.png" loading="lazy" alt="Renegade logo" />
                        </div>
                    </a>

                    <a href="generals" class="swiper-slide box generals" title="How to play Generals">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/generals-logo.png" loading="lazy" alt="Generals logo" />
                        </div>
                    </a>

                    <a href="command-and-conquer-3"  class="swiper-slide box cnc-3" title="How to play C&C 3">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/cnc-3-logo.png" loading="lazy" alt="C&C 3 logo" />
                        </div>
                    </a>

                    <a href="red-alert-3" class="swiper-slide box red-alert-3" title="How to play Red Alert 3">
                        <div class="logo">
                            <img src="assets/images/boxes/logos/red-alert-3-logo.png" loading="lazy" alt="Red Alert 3 logo" />
                        </div>
                    </a>
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
                        loop: false, 
                        spaceBetween: 30,
                        freeMode: false,
                        autoplay: false,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        breakpoints: {
                            340: {
                                slidesPerView: 3,
                                spaceBetween: 10,
                                noSwiping: false,
                                allowSlidePrev: true,
                                allowSlideNext: true,
                            },
                            768: {
                                slidesPerView: 5,
                                spaceBetween: 10,
                                noSwiping: false,
                                allowSlidePrev: true,
                                allowSlideNext: true,
                            },
                            1024: {
                                slidesPerView: 7,
                                spaceBetween: 10,
                                noSwiping: false,
                                allowSlidePrev: true,
                                allowSlideNext: true,
                            },
                            1280: {
                                slidesPerView: 8,
                                spaceBetween: 10,
                                noSwiping: true,
                                allowSlidePrev: false,
                                allowSlideNext: false,
                            },
                        }
                    });
                })();
            </script>
            <?php $this->env->stopSection(); ?>
        <?php 
    }
}