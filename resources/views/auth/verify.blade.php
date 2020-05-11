<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>Підтвердження пошти</title>

    <link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

     <!-- Styles -->
     <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="page">
        <div class="container">
            <div class="wrapped top-block">
                <div class="login send-email">
                    <div class="card">
                        <div class="card-header">Перевірте свою адресу електронної пошти</div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    На вашу електронну адресу надіслано нове посилання для підтвердження
                                </div>
                            @endif

                            Перш ніж продовжувати, перегляньте свій електронний лист на наявність підтвердження.
                            {{ __('Якщо ви не отримали електронний лист') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-reset">натисніть тут, щоб подати запит на інший</button>.
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
