@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Youdao</div>

                    <div class="card-body">
                        <a class="btn btn-primary" href="{{ youdao_oauth2_url()}}">登录有道云笔记</a>
                        <p>{{ youdao_access2_url() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection