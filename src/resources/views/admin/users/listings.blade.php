@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

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
