<article class="item generic-box-item">
    <div class="image">
        <a href="{{ $url }}" title="{{ $title }}" rel="nofollow noreferrer" target="_blank" class="image-link">
            <img src="{{ Vite::asset($image) }}" alt="{{ $title }}" loading="lazy">
        </a>

        <div class="button">
            <a href="{{ $url }}" title="{{ $title }}" rel="nofollow noreferrer" target="_blank" class="btn-link">
                <i class="icon-link"></i>
            </a>
        </div>
        <div>
            <h3 class="title">
                <a href="{{ $url }}" title="{{ $title }}" rel="nofollow noreferrer" target="_blank">
                    {{ $title }}
                </a>
            </h3>

            <div class="description">
                <p>
                    {{ $description }}
                </p>
            </div>
        </div>
    </div>
</article>