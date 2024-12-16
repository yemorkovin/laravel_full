@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $articles->name }}</h1>
    <p>{{ $articles->desc }}</p>
    
    <h3>Комментарии:</h3>
    @foreach($articles->comments as $comment)
        <div>
            <p>{{ $comment->content }}</p>
            <p><small>Добавлено: {{ $comment->created_at->diffForHumans() }}</small></p>
            @if(auth()->check() && auth()->user()->role == 'moderator')
                @if($comment->approved)
                    <button disabled class="btn btn-success">Одобрено</button>
                @else
                    <form method="POST" action="{{ route('comments.approve', $comment->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Одобрить</button>
                    </form>
                    <form method="POST" action="{{ route('comments.reject', $comment->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Отклонить</button>
                    </form>
                @endif
            @endif
        </div>
    @endforeach

    @if(auth()->check())
        <form method="POST" action="{{ route('comments.store', $articles->id) }}">
            @csrf
            <textarea name="content" class="form-control" required></textarea>
            <button type="submit" class="btn btn-primary mt-2">Добавить комментарий</button>
        </form>
    @endif
</div>
@endsection
