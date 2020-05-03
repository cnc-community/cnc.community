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
                    Add Page Category
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

                        <div class="form-group">
                            <label for="title">Page Category Title</label>
                            <input id="title" type="text" name="title" class="form-control" placeholder="E.g Red Alert" required/>
                        </div>

                        <div class="form-group">
                            <label for="description">Page Category Title</label>
                            <input id="description" type="text" name="description" class="form-control" placeholder="E.g Red Alert Category Page" required/>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input id="slug" type="text" name="slug" class="form-control" placeholder="E.g red-alert" required/>
                        </div>

                        <div class="form-group">
                            <label for="template">Page template</label>
                            <select id="template" name="template" class="form-control" required>
                                @foreach($templates as $template)
                                <option value="{{ $template->id}}">{{$template->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection