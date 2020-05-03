@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Category</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <?php foreach($pages as $page): ?>
                        <div>
                            <a href="{{ $page->url() }}">{{ $page->title}}</a>
                        </div>
                    <?php endforeach; ?>

                    <h3>How to get {{ $category->title }}</h3>
                    <?php echo App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::WHERE_TO_GET_GAMES); ?>
                    
                    <h3>How to play  {{ $category->title }}</h3>
                    <?php echo App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::HOW_TO_PLAY_LISTINGS); ?>

                    <h3>Mods for {{ $category->title }}</h3>
                    <?php echo App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::HOW_TO_PLAY_LISTINGS); ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
