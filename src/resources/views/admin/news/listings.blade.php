@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="page-title">
                <h3 class="mt-4">
                    News
                </h3>
                <a href="{{ route('admin.news.add', '') }}" class="btn btn-primary" title="Add new news item">Add new</a>
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    {{ $news->links() }}
                </div>
                <div class="card-body admin-listings">
                    <?php foreach($news as $newsItem): ?>
                        <div class="card admin-item col-md-3">
                            <div class="card-body">
                                <h4>
                                    <a href="{{ route('admin.news.edit', ['id' => $newsItem->id ]) }}">{{ $newsItem->title}}</a>
                                </h4>
                                <ul class="list-unstyled">
                                    <li>
                                        <?php if($newsItem->type == \App\News::NEWS_INTERNAL): ?>
                                        <small>Type: Article</small>
                                        <?php else: ?>
                                        <small>Type: Link</small>
                                        <?php endif; ?>
                                    </li>
                                    <?php if($newsItem->feed_source): ?>
                                    <li>
                                        <small>News source: {{ $newsItem->feed_source }}</small>
                                    </li>
                                    <?php endif; ?>
                                    
                                    <?php if($newsItem->author()): ?>
                                    <li>
                                        <small>Author: {{ $newsItem->author()->name }} </small>
                                    </li>
                                    <?php endif; ?>
                                    <li>
                                        <small>Updated</small> <small>- {{ $newsItem->updated_at->diffForHumans() }}</small> 
                                    </li>
                                    <li>
                                        <small>Created</small> <small>- {{ $newsItem->created_at->diffForHumans() }}</small> 
                                    </li>
                                    <li>
                                        <small>Categories</small> 
                                        - 
                                        <small>
                                        @foreach($newsItem->categories() as $category)
                                            {{ $category->name }},
                                        @endforeach
                                        </small>
                                    </li>
                                </ul>
                                <?php if($newsItem->image): ?>
                                <div style="padding-top:5px; padding-bottom: 5px;">
                                    <img src="/<?php echo $newsItem->image ?>" loading="lazy" style="max-width: 100%" />
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="card-body">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
