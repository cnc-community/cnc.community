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
            
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                <div class="card-body">
                      <form method="post" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="title">Post Title</label>
                            <input id="title" type="text" name="title" class="form-control" value="{{ $newsItem->title }}" />
                        </div>

                        <div class="form-group">
                            <label for="content">Excerpt</label>
                            <textarea id="excerpt" name="excerpt" class="form-control">{!! $newsItem->excerpt  !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="content">Post</label>
                            <textarea id="editor_{{ $newsItem->id }}" name="post">{!! $newsItem->post  !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="author">Author</label>
                            <select id="author" class="form-control" name="author">
                            <option>- Select Author -</option>
                            <?php foreach($users as $user): ?>
                            <option value="{{ $user->id }}" {{ $user->id == $newsItem->user_id ? "selected": ""}}>{{ $user->name }}</option>
                            <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option value="{{ \App\News::APPROVED }}">Approve</option>
                                <option value="{{ \App\News::DELETE }}">Permanently delete</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <?php $disableCategory = false; ?>

                            <?php if($newsItem->type == \App\News::NEWS_INTERNAL): ?>
                            <?php 
                                $date = \Carbon\Carbon::parse($newsItem->created_at);
                                $now = \Carbon\Carbon::now();
                                $disableCategory = $date->diffInHours($now) > 1;
                            ?>
                            <div class="form-group">
                                <small>
                                    <em>
                                        <strong>Note:</strong> A primary category should not be changed once set, it will be locked after an hour from publishing to prevent 404's. 
                                    </em>
                                </small>
                            </div>
                            <?php endif; ?>
                            <label for="category">Primary Category</label>
                            <select id="category" class="form-control" name="category_id" {{ $disableCategory == true ? "disabled": ""}}>
                            @foreach(\App\Category::all() as $category)
                                <option value="{{ $category->id}}" {{ $category->id == $newsItem->category_id ? "selected": ""}}>
                                {{ $category->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="categories">Other Categories</label>
                            <select id="categories" class="form-control" name="categories[]" multiple>
                            @foreach(\App\News::categoriesExcludingPrimary($newsItem->category_id) as $category)
                                <option value="{{ $category->id}}" {{ $newsItem->hasCategory($category->id) ? "selected": ""}}>
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

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var editor = $('#editor_{{ $newsItem->id }}');

$(editor).summernote
({
    callbacks: {
    onImageUpload: function(files) 
        {
            uploadImage(files[0]);
        }
    }
});

function onUploadSuccess(url)
{
    var image = document.createElement("img");
    image.src = url;
    
    editor.summernote('insertNode', image);
}

function uploadImage(file)
{
    var formData = new FormData();
    formData.append("upload", file)
    
    $.ajax({
        url: '{{ route('upload') }}',
        data: formData,
        contentType: false,
        processData: false,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function(url) 
        {
            onUploadSuccess(url);
        },
        error: function(data) {
            alert("Error uploading file");
        }
    });
}
</script>
@endsection


