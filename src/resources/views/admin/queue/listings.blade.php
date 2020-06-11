@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <h3 class="mt-4">Pending Feed Items</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{ $news->links() }}
                </div>
                <div class="card-body admin-listings">
                    <?php foreach($news as $newsItem): ?>
                        <div class="card admin-item col-md-6">
                            <div class="card-body">
                                <h4>
                                    <a href="{{ route('admin.queue.edit', ['id' => $newsItem->id ]) }}">{{ $newsItem->title}}</a>
                                </h4>
                                <ul class="list-unstyled">
                                    <li>
                                        <small>Updated</small> <small>- {{ $newsItem->updated_at->diffForHumans() }}</small> 
                                    </li>
                                    <li>
                                        <small>Feed from - {{ $newsItem->feed_source }}</small>
                                    </li>
                                    <li>
                                        <small>Category</small> <small>- {{ $newsItem->category()->name }}</small>
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
