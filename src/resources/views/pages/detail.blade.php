@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Standard Page Detail - {{ $page->title }}</div>

                <div class="card-body">
                    {{ $page->description }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
