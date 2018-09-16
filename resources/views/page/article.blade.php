@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center">{{ $article->title }}</h1>
                    {!! $article->markdown !!}
                </div>
            </div>
        </div>
    </div>
@endsection