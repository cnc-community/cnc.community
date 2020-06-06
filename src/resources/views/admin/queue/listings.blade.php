@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <h3 class="mt-4">Pending Feed Items</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body admin-listings">

                    <?php foreach($news as $newsItem): ?>
                        <div class="card admin-item col-md-3">
                            <div class="card-body">
                                <h4>
                                    <a href="{{ route('admin.news.edit', ['id' => $newsItem->id ]) }}">{{ $newsItem->title}}</a>
                                </h4>
                                <ul class="list-unstyled">
                                    <li>
                                        <small>Updated</small> <small>- {{ $newsItem->updated_at->diffForHumans() }}</small> 
                                    </li>
                                    <li>
                                        <small>Category</small> <small>- {{ $newsItem->category()->name }}</small>
                                    </li>
                                </ul>
                                <div style="padding-top:5px; padding-bottom: 5px;">
                                    <img src="/<?php echo $newsItem->image ?>" loading="lazy" style="max-width: 100%" />
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
