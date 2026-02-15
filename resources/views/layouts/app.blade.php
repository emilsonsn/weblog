<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('devstarit.app_name', 'DevStarIT') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="https://emilsonsouza.com.br/assets/img/favicon.ico" rel="icon">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .min-h-screen {
            min-height: 100vh;
        }
        .bg-gray-900 {
            background: linear-gradient(180deg,#0f172a 0%,#020617 100%);
        }
        .bg-dark {
            background-color: #020617 !important;
            border-bottom: 1px solid #1f2937;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: .5px;
        }
        .nav-link {
            color: #e5e7eb !important;
        }
        .nav-link:hover {
            color: #60a5fa !important;
        }
        .search-box input {
            background: #020617;
            border: 1px solid #1f2937;
            color: #e5e7eb;
        }
        .search-box input::placeholder{
            color: #9ca3af;
        }
        .search-box input:focus {
            border-color: #2563eb;
            box-shadow: none;
        }
        .search-box button {
            border-color: #2563eb;
            color: #60a5fa;
        }
        .search-box button:hover {
            background: #2563eb;
            color: #fff;
        }
        .max-w-7xl {
            max-width: 1100px;
        }
        .text-gray-400 {
            color: #9ca3af;
        }
        .pagination {
            justify-content: center;
        }

        footer {
            border-top: 1px solid #1f2937;
            margin-top: 60px;
            padding: 25px 0;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .image-circle{
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            display: inline-block;
            margin-right: 10px;
        }
         .image-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="min-h-screen bg-gray-900">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
            <div class="container max-w-7xl">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    <div class="d-flex align-items-center">
                        <div class="image-circle">
                            <img src="{{ asset('images/Eu.png') }}" class="img-fluid" style="max-height: 40px;">
                        </div>
                        {{ config('devstarit.app_name') }}
                    </div>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <form class="d-flex search-box" role="search" action="{{ route('home.index') }}">
                                <input class="form-control me-2" type="search" name="search" placeholder="Buscar artigos...">
                                <button class="btn btn-outline-primary" type="submit">Buscar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            <div class="container max-w-7xl">
                @yield('content')
            </div>
        </main>

        <footer>
            © {{ date('Y') }} {{ config('devstarit.app_name') }} • Conteúdo sobre programação e tecnologia
        </footer>
    </div>
</body>
</html>
