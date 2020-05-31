@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="page-title">
                <h3 class="mt-4">
                    Users
                </h3>
                <a href="{{ route('admin.users.add', '') }}" class="btn btn-primary" title="Add new news item">Add new</a>
            </div>

            <div class="card">
                <div class="card-body">
                     @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <?php foreach($users as $userItem): ?>
                        <div>
                            <a href="{{ route('admin.users.edit', ['id' => $userItem->id ]) }}">
                                {{ $userItem->name}} - ( {{$userItem->role }} )
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
