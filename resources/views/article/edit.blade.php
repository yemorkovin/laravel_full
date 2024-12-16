@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Редактировать новость</h2>
    <form method="POST" action="{{ route('article.update', $article) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Заголовок</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $article->name }}" required>
        </div>
        <div class="form-group">
            <label for="shortDesc">Содержимое</label>
            <textarea name="shortDesc" id="content" class="form-control" rows="5" required>{{ $article->shortDesc }}</textarea>
        </div>
        <div class="form-group">
            <label for="shortDesc">Полный текст</label>
            <textarea name="shortDesc" id="content" class="form-control" rows="5" required>{{ $article->desc }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
</div>
@endsection
