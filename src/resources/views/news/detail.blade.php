@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">News</div>

                <div class="card-body">
                    <div>
                        <a href="{{ $newsItem->url() }}" rel="nofollow" title="{{ $newsItem->title }}" target="_blank">{{ $newsItem->title}}</a>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
