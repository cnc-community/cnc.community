@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="page-title">
                <h3 class="mt-4">
                    Edit Page Category - {{$category->title}}
                </h3>
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

                        <input type="hidden" name="id" value="{{ $category->id }}" />

                        <div class="form-group">
                            <label for="title">Page Category Title</label>
                            <input id="title" type="text" name="title" class="form-control" value="{{ $category->title }}"/>
                        </div>

                        <div class="form-group">
                            <label for="description">Page Category Description</label>
                            <input id="description" type="text" name="description" class="form-control" value="{{ $category->description }}" required/>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input id="slug" type="text" name="slug" class="form-control" value="{{ $category->slug }}" required/>
                        </div>

                        <div class="form-group">
                            <label for="template">Page template</label>
                            <select id="template" name="template" class="form-control" required>
                                @foreach($templates as $template)
                                <option value="{{ $template->id}}"  <?php echo $template->id == $category->template_id ? "selected": ""; ?>>
                                {{$template->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="custom-fields">
                            <h5>Custom Fields</h5>
                            <p>
                                Create a custom html element to render in the page template.
                            </p>

                            <p>
                                <a href="{{ route('admin.pages.category.fields.add', $category->id) }}" class="btn btn-secondary">Add custom field to page</a>
                            </p>
                        
                            @foreach($customFields as $field)
                            <div class="field">
                                <div class="form-group">
                                    <div class="details">
                                        <ul class="list-unstyled">
                                            <li><strong>Name:</strong> {{ $field->name }}</li>
                                            <li><strong>Page Template Key:</strong> {{ $field->key }}</li>
                                        </ul>
                                    </div>
                                    <textarea id="editor_{{ $field->id }}" name="custom_field_{{ $field->id }}">
                                        {{ $field->getContent() }}
                                    </textarea>
                                </div>

                                <script>
                                        new Jodit('#editor_{{ $field->id }}');
                                </script>
                            </div>
                            @endforeach
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection