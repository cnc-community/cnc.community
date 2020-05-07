@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Funny</div>

                <div class="card-body">
                    @foreach($funnyItems as $funnyItem)
                        <div>
                            <a href="{{ $funnyItem->url() }}" rel="nofollow" title="{{ $funnyItem->title }}" target="_blank">{{ $funnyItem->title}}</a>
                            <div>
                                <ul class="list-unstyled">
                                    <li>
                                        <small>Updated</small> <small>- {{ $funnyItem->updated_at->diffForHumans() }}</small> 
                                    </li>
                                    <li>
                                        <small>Category</small> <small>- {{ $funnyItem->category()->name }}</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach

                    {{ $funnyItems->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
