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
                    <?php foreach($news as $newsItem): ?>
                        <div>
                            <a href="{{ route('admin.news.edit', ['id' => $newsItem->id ]) }}">{{ $newsItem->title}}</a>
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
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
