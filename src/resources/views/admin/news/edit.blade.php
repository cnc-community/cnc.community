@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="page-title">
                <h3 class="mt-4">
                    {{ $newsItem->title }}
                </h3>
                <a href="/admin/news">Back to all news</a>
            </div>

            <div class="card">
                <div class="card-body">
                      <form method="post" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="title">Post Title</label>
                            <input id="title" type="text" name="title" class="form-control" value="{{ $newsItem->title }}" />
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="{{ \App\News::APPROVED }}">Approve</option>
                                <option value="{{ \App\News::DELETE }}">Permanently delete</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" class="form-control" name="category_id">
                            @foreach(\App\Category::all() as $category)
                                <option value="{{ $category->id}}" {{ $category->id == $newsItem->category_id ? "selected": ""}}>
                                {{ $category->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            @if($newsItem->image)
                            <div style="margin-bottom: 15px">
                                <img src="{{ asset($newsItem->image) }}" />
                            </div>
                            @endif
                            
                            <label for="image">Choose a new image</label>
                            <input id="image" type="file" name="image" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="content">Post</label>
c
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
    .create( document.querySelector( '#editor_{{ $newsItem->id }}' ) )
    .catch( error => {
        console.error( error );
    } );
</script>
@endsection


