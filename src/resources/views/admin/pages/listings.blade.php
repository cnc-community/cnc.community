@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="page-title">
                <h3 class="mt-4">
                    Pages
                </h3>
            </div>

            <div class="card">
                <div class="card-body">
                    <div style="padding-bottom: 15px">
                        <a href="{{ route('admin.pages.add', '') }}" class="btn btn-primary" title="Add page">Add page</a>
                        <a href="{{ route('admin.pages.category.add', '') }}" class="btn btn-primary" title="Add page">Add page category</a>
                    </div>
                    
                    <h5>Pages</h5>
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
                    <h5>Page Categories</h5>
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
