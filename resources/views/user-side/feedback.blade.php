@extends('layouts.user-side')

@section('title', 'Форма зв\'язку з адміністрацією')

@section('header-custom', 'h-auto-2')

@section('content-main')

<div class="container">
    <div class="wrapped-feedback">
        <div class="feedback">
            @if (session('send'))
                <div class="send-message">
                    {{ session('send') }}
                </div>
            @endif
            <h1 class="feedback__title">
                Форма зв'язку з адміністрацією
            </h1>
            <form class="feedback__form" method="POST" action="{{ route('feedback.store') }}">
                @csrf
                <div class="form-header">
                    <div class="group-input">
                        <label class="label-form" for="user-name">Від кого</label>
                        <input class="input-forms" required type="text" id="user-name" name="user_name" value="{{ $user_name }}">

                        @error('user_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="group-input">
                        <label class="label-form" for="email">Ваша пошта</label>
                        <input class="input-forms" required type="email" id="email" name="user_email" value="{{ $user_email }}">

                        @error('user_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>
                <div class="form-body">
                    <div class="group-textarea">
                        <label class="label-form" for="body">Ваше повідомлення</label>
                        <textarea class="body-feedback" required name="message" id="body"></textarea>

                        @error('message')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>
                <button class="btn btn-feedback">Надіслати</button>
            </form>
        </div>
    </div>
  </div>

@endsection

