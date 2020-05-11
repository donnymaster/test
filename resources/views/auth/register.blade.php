<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>Реєстрація</title>

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
                    <div class="login__title">Реєстрація</div>
                    <form class="login__form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                       <label class="login__input-text" for="name">Нік</label>
                       <input type="text" id="name" name="name" class="login__input">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                       <label class="login__input-text" for="login">Пошта</label>
                       <input type="text" id="login" name="email" class="login__input">

                       @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                       <label class="login__input-text" for="password">Пароль</label>
                       <input type="password" id="password" name="password" class="login__input">

                       @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                       <label class="login__input-text" for="email">Підтвердіть пароль</label>
                       <input type="password" id="email" name="password_confirmation" class="login__input">
                       <div class="register__avatar">
                           <div class="register__avatar-title">
                            Аватар
                           </div>
                           <div class="register__avatar-images">
                               <div class="register__avatar-image-item register__avatar-image-item--men">
                                <img src="{{ asset('img/men.png') }}" alt="men" id="men" class="register__avatar-image">
                               </div>
                               <div class="register__avatar-image-item register__avatar-image-item--girl">
                                <img src="{{ asset('img/girl.png') }}" alt="girl" id="girl" class="register__avatar-image">
                               </div>
                               <div class="register__avatar-image-item">
                                <img src="{{ asset('img/other.png') }}" alt="other" id="other" class="register__avatar-image">
                                </div>
                           </div>
                       </div>
                       <input type="text" name="default_image" id="default_image" hidden value>
                       <input type="file" name="user-castom-img" id="img_file" hidden accept=".jpg, .jpeg, .png">
                       <div class="form__footer">
                        <div class="login__account">
                            <a href="{{ route('login') }}" class="login__account-link">Аккаунт є?</a> </div>
                       </div>
                        <button class="form__btn">Увійти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/register.js') }}"></script>
</body>







{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
