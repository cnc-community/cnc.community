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
                    Add page
                </div>

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
                            <label for="template">Select a template</label>
                            <select id="template" name="template" class="form-control"  required>
                                @foreach($templates as $template)
                                <option value="{{ $template->id}}">{{$template->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Slug Category</label>
                            <input id="category" type="text" name="slug_category" class="form-control" placeholder="e.g red-alert" required />
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input id="slug" type="text" name="slug" class="form-control" placeholder="e.g how-to-play" required/>
                        </div>

                        <div class="form-group">
                            <label for="editor">Post</label>
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
        let quill = new Quill('#editor', {
            theme: 'snow'
        });
        
        let editor = document.getElementById("editor");
        let post = document.getElementById("content");
        
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


