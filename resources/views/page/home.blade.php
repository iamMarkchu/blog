@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @foreach($articles as $article)
                    <div class="card article-card">
                        <div class="card-header">{{ $article->title }}</div>
                        <img src="{{ $article->cover }}" alt="mongodb" class="card-img-top" width="100%">
                        <div class="card-footer text-muted">
                            <div class="article-item">
                                <span class="oi oi-timer"></span>
                                <span>{{ $article->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="article-item">
                                <span class="oi oi-tag"></span>
                                @foreach($article->tags as $tag)
                                    <a href="{{ route("tag", ["url_name" => $tag->url_name]) }}" class="btn btn-light btn-sm" role="button" aria-pressed="true">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                            <div class="article-item">
                                <span class="oi oi-person"></span>
                                <span>{{ $article->user->name }}</span>
                            </div>
                            <div class="article-item float-right">
                                <a href="{{ route("article", ["url_name" => $article->url_name]) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">阅读全文</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $articles->links() }}
            </div>
            <div class="col-md-4">
                <div class="card right-card">
                    <div class="card-body">
                        <h5 class="card-title">公告栏</h5>
                        我是公告栏
                    </div>
                </div>
                <div class="card right-card">
                    <div class="card-header">标签栏</div>
                    <div class="card-body">
                        @foreach($tags as $tag)
                            <a href="{{ route("tag", ["url_name" => $tag->url_name]) }}" class="btn btn-outline-success tag-item" role="button" aria-pressed="true">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="card right-card">
                    <div class="card-header">类别栏</div>
                    <div class="card-body">
                        @foreach($categories as $category)
                            <a href="{{ route("category", ["url_name" => $category->url_name]) }}" class="btn btn-outline-primary tag-item" role="button" aria-pressed="true">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
