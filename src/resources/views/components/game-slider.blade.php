<div class="swiper-container">
    <div class="swiper-wrapper">

        @php
            $games = [
                ['slug' => 'tiberian-dawn', 'title' => 'Tiberian Dawn', 'logo' => 'tiberian-dawn-logo.png', 'classname' => 'tiberian-dawn'],
                ['slug' => 'red-alert', 'title' => 'Red Alert', 'logo' => 'red-alert-logo.png', 'classname' => 'red-alert'],
                ['slug' => 'tiberian-sun', 'title' => 'Tiberian Sun', 'logo' => 'tiberian-sun-logo.png', 'classname' => 'tiberian-sun'],
                ['slug' => 'red-alert-2', 'title' => 'Red Alert 2', 'logo' => 'red-alert-2-logo.png', 'classname' => 'red-alert-2'],
                ['slug' => 'renegade', 'title' => 'Renegade', 'logo' => 'renegade-logo.png', 'classname' => 'renegade'],
                ['slug' => 'generals', 'title' => 'Generals', 'logo' => 'generals-logo.png', 'classname' => 'generals'],
                ['slug' => 'command-and-conquer-3', 'title' => 'C&C 3', 'logo' => 'cnc-3-logo.png', 'classname' => 'cnc-3'],
                ['slug' => 'red-alert-3', 'title' => 'Red Alert 3', 'logo' => 'red-alert-3-logo.png', 'classname' => 'red-alert-3'],
                ['slug' => 'other-cnc-games', 'title' => 'Other C&C Games', 'logo' => 'more-cnc-games.png', 'classname' => 'more-cnc-games'],
            ];
        @endphp

        @foreach ($games as $game)
            <a href="{{ $game['slug'] }}{{ isset($howToPlayLinks) ? '/how-to-play' : '' }}"
                class="swiper-slide box {{ str_replace('-', ' ', $game['slug']) }} {{ $game['classname'] }}" title="How to play {{ $game['title'] }}">
                <div class="logo">
                    <img src="{{ Vite::asset("resources/assets/images/boxes/logos/{$game['logo']}") }}" loading="lazy" alt="{{ $game['title'] }} logo" />
                </div>
            </a>
        @endforeach

    </div>
</div>

<div class="swiper-button-prev"></div>
<div class="swiper-button-next"></div>

@section('scripts')
    <script src="/static/vendor/swiper.min.js"></script>
    <script>
        (function() {
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
                        slidesPerView: 9,
                        spaceBetween: 10,
                        noSwiping: true,
                        allowSlidePrev: false,
                        allowSlideNext: false,
                    },
                }
            });
        })();
    </script>
@endsection
