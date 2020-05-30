@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="page-title">
                <h3 class="mt-4">
                    Add News Item
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

                    <form method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="post" id="post" />

                        <div class="form-group">
                            <label for="title">Post Title</label>
                            <input id="title" type="text" name="title" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" class="form-control" name="category_id">
                            @foreach(\App\Category::all() as $category)
                                <option value="{{ $category->id}}">
                                {{ $category->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Choose a new image</label>
                            <input id="image" type="file" name="image" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="content">Post</label>

                            <textarea id="editor" name="post">
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .catch( error => {
        console.error( error );
    } );
</script>

@endsection


