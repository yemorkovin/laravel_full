@extends('layouts.app')

@section('title', 'Галерея')

@section('content')
    <div class="row">
        <div class="col-md-12">
        <img src='/public/{{$full_image}}' width='100%'>
        </div>
        
    </div>
@endsection
