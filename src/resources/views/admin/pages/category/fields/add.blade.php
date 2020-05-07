@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="/admin/pages">View all pages</a>
                </div>
                <div class="card-header">
                    Add custom field
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
                        <input type="hidden" value="{{ $category->id }}" name="id"/>
                        <div class="form-group">
                            <label for="key">Key that will be used to identify in templates</label>
                            <input id="key" type="text" name="key" class="form-control" placeholder="E.g how_to_play_video" required/>
                        </div>

                        <div class="form-group">
                            <label for="name">Name of Custom Field</label>
                            <input id="name" type="text" name="name" class="form-control" placeholder="E.g Video" required/>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection