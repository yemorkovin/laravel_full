@extends('layouts.app')

@section('title', 'Новости')

@section('content')
    <h2>Последние новости</h2>
    <div class="row">
        @foreach ($articles as $item)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">{{ Str::limit($item->shortDesc, 100) }}</p>
                        <a href="{{ route('article.show', $item->id) }}" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $articles->links('pagination::bootstrap-5') }}
@endsection
