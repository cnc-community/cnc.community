@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="page-title">
                <h3 class="mt-4">
                    Add New Page
                </h3>
                <a href="/admin/news">Back to all news</a>
            </div>

            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{Session::get('error')}}
                    </div>
                    @endif

                    <form method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="content" id="content" required />

                        <div class="form-group">
                            <label for="title">Page Title</label>
                            <input id="title" type="text" name="title" class="form-control"  required/>
                        </div>

                        <div class="form-group">
                            <label for="description">Page description</label>
                            <input id="description" type="text" name="description" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label for="template">Page template</label>
                            <select id="template" name="template" class="form-control" required>
                                @foreach($templates as $template)
                                <option value="{{ $template->id}}">{{$template->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="category">Page category</label>
                            <select id="category" name="category" class="form-control" required>
                                @foreach($categories as $category)
                                <option value="{{ $category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input id="slug" type="text" name="slug" class="form-control" placeholder="e.g how-to-play" required/>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


