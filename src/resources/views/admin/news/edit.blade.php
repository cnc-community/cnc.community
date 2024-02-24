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
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title">Post Title</label>
                                <input id="title" type="text" name="title" class="form-control" value="{{ $newsItem->title }}" />
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="postType">Post Type</label>
                                    <select id="postType" class="form-control" name="type" required>
                                        <option>- Select Post Type -</option>
                                        <option value="<?php echo \App\News::NEWS_INTERNAL; ?>" {{ $newsItem->type == \App\News::NEWS_INTERNAL ? 'selected' : '' }}>Article</option>
                                        <option value="<?php echo \App\News::NEWS_EXTERNAL; ?>" {{ $newsItem->type == \App\News::NEWS_EXTERNAL ? 'selected' : '' }}>Link</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="url">Url (Only use with Post Type as Link)</label>
                                    <input id="url" type="text" name="url" class="form-control" value={{ $newsItem->url }} required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content">Excerpt</label>
                                <textarea id="excerpt" name="excerpt" class="form-control">{!! $newsItem->excerpt !!}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="content">Post</label>
                                <textarea id="editor_{{ $newsItem->id }}" name="post">{!! $newsItem->post !!}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="author">Author</label>
                                <select id="author" class="form-control" name="author">
                                    <option value="-1">- Select Author -</option>
                                    <?php foreach($users as $user): ?>
                                    <option value="{{ $user->id }}" {{ $user->id == $newsItem->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
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
                                            <strong>Note:</strong> A primary category should not be changed once set, it will be locked after an hour from
                                            publishing to prevent 404's.
                                        </em>
                                    </small>
                                </div>
                                <?php endif; ?>
                                <label for="category">Primary Category</label>
                                <select id="category" class="form-control" name="category_id" {{ $disableCategory == true ? 'disabled' : '' }}>
                                    @foreach (\App\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $newsItem->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="categories">Other Categories</label>
                                <select id="categories" class="form-control" name="categories[]" multiple>
                                    @foreach (\App\News::categoriesExcludingPrimary($newsItem->category_id) as $category)
                                        <option value="{{ $category->id }}" {{ $newsItem->hasCategory($category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                @if ($newsItem->image)
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

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor_{{ $newsItem->id }}'), {
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
@endsection
