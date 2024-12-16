<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Новостной сайт')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Новостной сайт</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('about')) active @endif" href="{{ route('about') }}">О нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('contact')) active @endif" href="{{ route('contact') }}">Контакты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('article.index')) active @endif" href="{{ route('article.index') }}">Новости</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">Выйти</button>
                            </form>
                        </li>
                        <li class="nav-item nav-link">
                            Ваша роль {{auth()->user()->role}}
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login.form') }}">Войти</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('create.form') }}">Регистрация</a></li>
                    @endauth
                    @if(auth()->check())
    @php
        $notifications = auth()->user()->unreadNotifications;
    @endphp
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Уведомления ({{ $notifications->count() }})
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
            @forelse ($notifications as $notification)
                <li>
                    <a class="dropdown-item" href="{{ route('article.show', $notification->data['id']) }}">
                        {{ $notification->data['title'] }}
                    </a>
                </li>
            @empty
                <li>
                    <a class="dropdown-item text-muted" href="#">Нет новых уведомлений</a>
                </li>
            @endforelse
        </ul>
        <div id="app">
            <notifications></notifications>
        </div>
    </li>
@endif

                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-4">
        <p class="mb-0">&copy; Петров Иван Иванович гр. 444</p>
       
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
