@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <?php foreach($news as $newsItem): ?>
                        <div>
                            <h3>{{ $newsItem->title}}</h3>
                            <div>
                                <img src="{{$newsItem->image}}"/>
                            </div>
                            <div>
                            {!! $newsItem->post !!}
                            </div>
                            <div>
                            <a href="{{ $newsItem->url }}">Go to article</a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
