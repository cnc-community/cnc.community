@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Panel</div>

                <div class="card-body">
                    <h4>Pages</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
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

                <div class="card-body">
                    <h4>Page Categories</h4>
                    <?php foreach($categories as $category): ?>
                    <div>
                        <a href="{{ route('admin.pages.category.edit', ['id' => $category->id ]) }}">{{ $category->title}}</a>
                        <div>
                            <ul class="list-unstyled">
                                <li>
                                    <small>Updated</small> <small>- {{ $category->updated_at->diffForHumans() }}</small> 
                                </li>
                                <li>
                                    <small>Description</small> <small>- {{ $category->description }}</small>
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
