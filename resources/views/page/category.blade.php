@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title text-center">{{ $category->name }}</h1>
                        <h6 class="card-subtitle mb-2 text-muted text-center">共有: {{ $category->articles_count }} 篇文章</h6>

                        @foreach($category->articles as $key => $article)
                            <a href="{{ route('article', ['url_name' => $article->url_name]) }}">{{ $key + 1 }}. 《{{ $article->title }}》 / {{ $article->user->name }} / {{ $article->created_at->diffForHumans() }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection