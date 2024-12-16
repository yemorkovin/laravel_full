@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="text-center">
        <h1 class="display-4">{{$data['company_info']['title']}}</h1>
        <p class="lead">{{$data['company_info']['content']}}</p>
        <a href="{{$data['company_info']['preview_image']}}" class="btn btn-primary">{{$data['company_info']['button']}}</a>
    </div>
    <h2>Последние новости</h2>
    <div class="row">
        @foreach ($news as $key=>$item)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item['name'] }}</h5>
                        <p><a href='/public/galery/{{$key+1}}'><img src='/public/{{$item["preview_image"]}}' width='100%'></a></p>
                        @if(isset($item['shortDesc']))
                        <p class="card-text">{{ $item['shortDesc'] }}</p>
                        @endif
                        <a href="{{ route('article.show', $key+1) }}" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
@endsection
