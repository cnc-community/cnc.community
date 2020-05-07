@extends('layouts.admin')

@section('content')
<style>
    .custom-fields 
    {
        padding: 15px 0;
    }

    .custom-fields .field
    {
        padding: 15px 0;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="/admin/pages">View all pages</a>
                </div>
                <div class="card-header">
                    Edit page
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

                        <input type="hidden" name="id" value="{{$page->id}}" />
                        
                        <div class="form-group">
                            <label for="title">Page Title</label>
                            <input id="title" type="text" name="title" class="form-control"  value="{{ $page->title }}" required/>
                        </div>

                        <div class="form-group">
                            <label for="description">Page description</label>
                            <input id="description" type="text" name="description" class="form-control" value="{{ $page->description }}" required/>
                        </div>

                        <div class="form-group">
                            <label for="template">Select a template</label>
                            <select id="template" name="template" class="form-control"  required>
                                @foreach($templates as $template)
                                <option value="{{ $template->id}}" <?php echo $template->id == $page->template_id ? "selected": ""; ?>
                                >
                                    {{$template->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Slug Category</label>
                            <input id="category" 
                                type="text" 
                                name="slug_category" 
                                class="form-control" 
                                placeholder="e.g red-alert" 
                                value="{{ $page->category()->slug }}" 
                                required 
                                disabled
                            />
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input id="slug" 
                                type="text" 
                                name="slug" 
                                class="form-control" 
                                placeholder="e.g how-to-play" 
                                value="{{ $page->slug}}" 
                                required 
                                disabled
                            />
                        </div>
                        
                        <div class="custom-fields">
                            <h4>Custom Fields</h4>
                            <p>
                                Create a custom html element to render in the page template.
                            </p>

                            <a href="{{ route('admin.pages.fields.add', $page->id) }}" class="btn btn-secondary">Add custom field to page</a>

                            @foreach($customFields as $field)
                            <div class="field">
                                <div class="form-group">
                                    <div class="details">
                                        <ul class="list-unstyled">
                                            <li><strong>Name:</strong> {{ $field->name }}</li>
                                            <li><strong>Key:</strong> {{ $field->key }}</li>
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


