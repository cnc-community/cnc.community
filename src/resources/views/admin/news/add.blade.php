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
                            <input id="title" type="text" name="title" class="form-control" required />
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="postType">Post Type</label>
                                <select id="postType" class="form-control" name="type" required>
                                    <option>- Select Post Type -</option>
                                    <option value="<?php echo \App\News::NEWS_INTERNAL; ?>">Article</option>
                                    <option value="<?php echo \App\News::NEWS_EXTERNAL; ?>">Link</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="url">Url (Only use with Post Type as Link)</label>
                                <input id="url" type="text" name="url" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Excerpt</label>
                            <textarea id="excerpt" name="excerpt" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="editor">Post</label>
                            <textarea id="editor" name="post">
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="author">Author</label>
                            <select id="author" class="form-control" name="author" required>
                            <option>- Select Author -</option>
                            <?php foreach($users as $user): ?>
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Primary Category</label>
                            <select id="category" class="form-control" name="category_id" required>
                            @foreach(\App\Category::all() as $category)
                                <option value="{{ $category->id}}">
                                {{ $category->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="categories">Other Categories</label>
                            <select id="categories" class="form-control" name="categories[]" multiple required>
                            @foreach(\App\Category::all() as $category)
                                <option value="{{ $category->id}}">
                                {{ $category->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Thumbnail Image</label>
                            <input id="image" type="file" name="image" class="form-control" />
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
var editor = $('#editor');

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


