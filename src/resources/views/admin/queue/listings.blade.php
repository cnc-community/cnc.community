@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <h3 class="mt-4">Dashboard</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php foreach($news as $newsItem): ?>
                        <div>
                            <a href="{{ route('admin.queue.edit', ['id' => $newsItem->id ]) }}">{{ $newsItem->title}}</a>
                            
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
