@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
            <h3>Pages</h3>
            @foreach($pageCategories as $category)

                <a href="{{ $category->url() }}">{{ $category->title }}</a> <br/>
            @endforeach
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Official News</div>

                <div class="card-body">
                    @foreach($officialNews as $newsItem)
                        <div>
                            <a href="{{ $newsItem->url }}" rel="nofollow" title="{{ $newsItem->title }}" target="_blank">{{ $newsItem->title}}</a>
                            <a href="{{ $newsItem->url }}" rel="nofollow" title="{{ $newsItem->title }}" target="_blank">
                                <img src="{{ asset($newsItem->image) }}" style="max-width: 100%" alt="{{ $newsItem->title}}"/>
                            </a>
                            <div>
                            {!! $newsItem->post !!}
                            </div>
                            <div>
                                <ul class="list-unstyled">
                                    <li>
                                        <small>Updated</small> <small>- {{ $newsItem->updated_at->diffForHumans() }}</small> 
                                    </li>
                                    <li>
                                        <small>Category</small> <small>- {{ $newsItem->category()->name }}</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    <a href="news/official-news" title="Official News" class="btn btn-primary">View all Official News</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Community News</div>

                <div class="card-body">
                    @foreach($communityNews as $newsItem)
                        <div>
                            <a href="{{ $newsItem->url }}" rel="nofollow" title="{{ $newsItem->title }}" target="_blank">{{ $newsItem->title}}</a>
                            <a href="{{ $newsItem->url }}" rel="nofollow" title="{{ $newsItem->title }}" target="_blank">
                                <img src="{{ asset($newsItem->image) }}" style="max-width: 100%" alt="{{ $newsItem->title}}"/>
                            </a>
                            <div>
                            {!! $newsItem->post !!}
                            </div>
                            <div>
                                <ul class="list-unstyled">
                                    <li>
                                        <small>Updated</small> <small>- {{ $newsItem->updated_at->diffForHumans() }}</small> 
                                    </li>
                                    <li>
                                        <small>Category</small> <small>- {{ $newsItem->category()->name }}</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    <a href="news/community-news" title="Community News" class="btn btn-primary">View all Community News</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
