<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>Вхід</title>

    <link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

     <!-- Styles -->
     <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="page">
        <div class="container">
            <div class="wrapped">
                <div class="login">
                    <div class="login__title">Вхід</div>
                    <form class="login__form" method="POST" action="{{ route('login') }}">
                        @csrf

                       <label class="login__input-text" for="email">Логін</label>
                       <input type="email" id="email" name="email" class="login__input" required autocomplete="email" autofocus>
                       @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                       <label class="login__input-text" for="password">Пароль</label>
                       <input type="password" id="password" name="password" class="login__input" required autocomplete="current-password">
                       @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                       <div class="form__footer">
                        <div class="login__account">Немає облікового запису?
                            <a href="{{ route('register') }}" class="login__account-link">Створи</a></div>
                       </div>
                        <button class="form__btn">Увійти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>


