@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Добавить новость</h2>
    <form method="POST" action="{{ route('article.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Заголовок</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="shortDesc">Содержимое</label>
            <textarea name="shortDesc" id="shortDesc" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="desc">Полный текст</label>
            <textarea name="desc" id="desc" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Категория</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
