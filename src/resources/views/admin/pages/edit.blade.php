@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="/admin/pages">View all pages</a>
                </div>
                <div class="card-header">
                    {{ $page->title }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="post" id="post" />

                        <div class="form-group">
                            <label for="title">Post Title</label>
                            <input id="title" type="text" name="title" class="form-control" value="{{ $page->title }}" />
                        </div>


                        <div class="form-group">
                            <label for="content">Post</label>

                            <div id="editor">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Initialize Quill editor -->
<script>
    (function()
    {
        var quill = new Quill('#editor', {
            theme: 'snow'
        });
        
        var editor = document.getElementById("editor");
        var post = document.getElementById("post");
        
        quill.on('text-change', function (){
            updatePost();
        });

        function updatePost()
        {
            post.value = editor.children[0].innerHTML;
        }

        updatePost();
    }());
</script>

@endsection


