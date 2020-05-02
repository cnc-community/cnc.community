@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pages</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('admin.pages.add', '') }}" class="btn btn-primary" title="Add page">Add page</a>
                    </div>
                    <?php foreach($pages as $page): ?>
                        <div>
                            <a href="{{ route('admin.pages.edit', ['id' => $page->id ]) }}">{{ $page->title}}</a>
                            <div>
                                <ul class="list-unstyled">
                                    <li>
                                        <small>Updated</small> <small>- {{ $page->updated_at->diffForHumans() }}</small> 
                                    </li>
                                    <li>
                                        <small>Description</small> <small>- {{ $page->description }}</small>
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
