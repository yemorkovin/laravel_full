@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Новости</h2>
    <a href="{{ route('article.create') }}" class="btn btn-primary mb-3">Добавить новость</a>
    <table class="table">
        <thead>
            <tr>
                <th>Заголовок</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>
                    <a href="{{ route('article.show', $item) }}" class="btn btn-success btn-sm">Просмотреть</a>
                    <a href="{{ route('article.edit', $item) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('article.destroy', $item) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $articles->links() }}
</div>
@endsection
