@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-12">

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
                            <input id="name" type="text" name="name"  class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email"  class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" class="form-control" />
                        </div>
                        
                        <div class="form-group">
                            <label for="role">User Role</label>
                            <select id="role" name="role" class="form-control">
                                <option value="{{ \App\User::ROLE_ADMIN }}">Admin</option>
                                <option value="{{ \App\User::ROLE_EDITOR }}">Editor</option>
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

