@extends('layouts.admin')

@section('content')
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <style>
        .custom-fields {
            padding: 15px 0;
        }

        .custom-fields .field {
            padding: 15px 0;
        }
    </style>

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
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <form method="post">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $page->id }}" />

                            <div class="form-group">
                                <label for="title">Page Title</label>
                                <input id="title" type="text" name="title" class="form-control" value="{{ $page->title }}" required />
                            </div>

                            <div class="form-group">
                                <label for="description">Page description</label>
                                <input id="description" type="text" name="description" class="form-control" value="{{ $page->description }}" required />
                            </div>

                            <div class="form-group">
                                <label for="template">Select a template</label>
                                <select id="template" name="template" class="form-control" required>
                                    @foreach ($templates as $template)
                                        <option value="{{ $template->id }}" <?php echo $template->id == $page->template_id ? 'selected' : ''; ?>>
                                            {{ $template->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category">Slug Category</label>
                                <input id="category" type="text" name="slug_category" class="form-control" placeholder="e.g red-alert"
                                    value="{{ $page->category()->slug }}" required disabled />
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input id="slug" type="text" name="slug" class="form-control" placeholder="e.g how-to-play" value="{{ $page->slug }}"
                                    required disabled />
                            </div>

                            <div class="custom-fields">
                                <h4>Custom Fields</h4>
                                <p>
                                    Create a custom html element to render in the page template.
                                </p>

                                <a href="{{ route('admin.pages.fields.add', $page->id) }}" class="btn btn-secondary">Add custom field to page</a>

                                @foreach ($customFields as $field)
                                    <div class="field">
                                        <div class="form-group">
                                            <div class="details">
                                                <ul class="list-unstyled">
                                                    <li><strong>Name:</strong> {{ $field->name }}</li>
                                                    <li><strong>Key:</strong> {{ $field->key }}</li>
                                                </ul>
                                            </div>
                                            <textarea id="editor_{{ $field->id }}" name="custom_field_{{ $field->id }}">{{ $field->getContent() }}</textarea>
                                        </div>

                                        <script>
                                            ClassicEditor
                                                .create(document.querySelector('#editor_{{ $field->id }}'), {
                                                    toolbar: ['heading', '|', 'bold', 'link', 'bulletedList', 'numberedList', 'imageUpload', 'mediaEmbed',
                                                        'alignment:right'
                                                    ],

                                                    ckfinder: {
                                                        // Update the uploadUrl to point to your Laravel route handling image uploads
                                                        uploadUrl: '{{ route('uploadImage') }}?_token={{ csrf_token() }}',
                                                    },
                                                    mediaEmbed: {
                                                        previewsInData: true,
                                                        providers: [{
                                                            name: 'YouTube',
                                                            url: /^https?:\/\/(?:www\.)?youtube\.com\/watch\?v=(.+)$/,
                                                            html: match => {
                                                                const urlParams = new URLSearchParams(new URL(match.input).search);
                                                                const videoId = urlParams.get('v');
                                                                return `<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://www.youtube.com/embed/${videoId}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen></iframe></div>`;
                                                            }
                                                        }]
                                                    }
                                                }).catch(error => {
                                                    console.error(error);
                                                });
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
