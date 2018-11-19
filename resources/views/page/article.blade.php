@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body markdown-body">
                        <h1 class="card-title text-center">{{ $article->title }}</h1>
                        <div class="info-block text-center text-muted">
                            <span class="oi oi-timer"></span><span>{{ $article->updated_at }}</span>&nbsp;&nbsp;
                            <span class="oi oi-person"></span><span>{{ $article->user->name }}</span>&nbsp;&nbsp;
                            <span class="oi oi-eye"></span><span class="view_count">0</span>&nbsp;&nbsp;
                        </div>
                        {!! $article->markdown !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card right-card">
                    <div class="card-header">目录</div>
                    <div class="card-body">
                        <ul>
                            @foreach($list as $h1)
                                <li><a href="#{{ $h1['name'] }}">{{ $h1['name'] }}</a></li>
                                @if (isset($h1['child']))
                                    <ul>
                                        @foreach($h1['child'] as $h2)
                                            <li><a href="#{{ $h2['name'] }}">{{ $h2['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                @include("layouts.ads")
            </div>
        </div>
    </div>
@endsection