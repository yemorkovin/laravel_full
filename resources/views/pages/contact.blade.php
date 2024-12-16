@extends('layouts.app')

@section('title', $data['title'])

@section('content')
    <h2>{{$data['text']}}</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif 

    <form action="{{ route('contact.store') }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Сообщение</label>
            <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
            @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
@endsection
