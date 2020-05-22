@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="page-title">
                <h3 class="mt-4">
                    Users
                </h3>
                <a href="{{ route('admin.news.add', '') }}" class="btn btn-primary" title="Add new news item">Add new</a>
            </div>

            <div class="card">
                <div class="card-body">
                  @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" name="name" value="{{ $userItem->name}}" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" value="{{ $userItem->email}}" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" class="form-control" />
                        </div>
                        
                        <div class="form-group">
                            <label for="role">User Role</label>
                            <select id="role" name="role" class="form-control">
                                <option value="{{ \App\User::ROLE_ADMIN }}" {{ \App\User::ROLE_ADMIN == $userItem->role ? "selected": ""}}>Admin</option>
                                <option value="{{ \App\User::ROLE_EDITOR }}"  {{ \App\User::ROLE_EDITOR == $userItem->role ? "selected": ""}}>Editor</option>
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

