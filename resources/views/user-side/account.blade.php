@extends('layouts.user-side')

@section('title', 'Аккаунт')

@section('header-custom', 'h-auto-2')

@section('script')
    <script src="{{ asset('js/tabs.js') }}"></script>
    <script src="{{ asset('js/register.js') }}"></script>
@endsection

@section('content-main')

    <div class="container">
        <div class="account-breadcrumbs">
            <a href="{{ route('root') }}" class="link-breadcrumbs">
                Головна
            </a>
            <img src="{{ asset('img/chevron-right.png') }}" alt="arrow-right" class="right-arrow">
            <a href="#" class="link-breadcrumbs">
                Аккаунт
            </a>
        </div>
    </div>

    <div class="container">
        <div class="two-column">
            <div class="two-column__filter">
              <div class="account-tabs">
                <div class="account-tabs--title">
                    Ваші налаштування
                </div>
                <div class="account-tabs--body">
                    <div class="tabs-nav__item is-active" data-tab-name="1">
                        Особисті налаштування
                    </div>
                </div>
              </div>
            </div>
            <div class="two-column__elements flex-1">
                   <div class="account-settings">
                       <div class="account-settings__title">
                        Налаштування
                       </div>
                       <div class="account-settings__body">
                        <div class="tab tab-1 is-active">
                            <form class="login__form" method="POST" action="{{ route('user.update', ['user' => $user_info->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                @if (session('update'))
                                    <div class="send-message">
                                        {{ session('update') }}
                                    </div>
                                @endif

                                <label class="login__input-text" for="name">Ім'я</label>
                                <input required type="text" id="name" name="nick" class="login__input" value="{{$user_info->nick}}">
                                @error('nick')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label class="login__input-text" for="password">Пароль</label>
                                <input required type="password" id="password" name="password" class="login__input">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label class="login__input-text" for="email">Пошта</label>
                                <input required type="email" id="email" name="email" class="login__input" value="{{$user_info->email}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="register__avatar">
                                    <div class="register__avatar-title">
                                     Аватар
                                    </div>
                                    <div class="register__avatar-images">

                                        @if (
                                            $user_info->avatar != 'public/avatar/men.png'
                                         && $user_info->avatar != 'public/avatar/girl.png'
                                        )
                                            <div class="register__avatar-image-item
                                            {{$user_info->avatar == 'public/avatar/men.png' ? 'register__avatar-image-item--line' : null}}
                                            ">
                                                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="men" id="old" class="register__avatar-image">
                                            </div>
                                        @endif

                                        <div class="register__avatar-image-item register__avatar-image-item--men
                                        {{$user_info->avatar == 'public/avatar/men.png' ? 'register__avatar-image-item--line' : null}}
                                        ">
                                            <img src="{{ asset('img/men.png') }}" alt="men" id="men" class="register__avatar-image">
                                        </div>

                                        <div class="register__avatar-image-item register__avatar-image-item--girl
                                        {{$user_info->avatar == 'public/avatar/girl.png' ? 'register__avatar-image-item--line' : null}}
                                        ">
                                            <img src="{{ asset('img/girl.png') }}" alt="girl" id="girl" class="register__avatar-image">
                                        </div>

                                        <div class="register__avatar-image-item">
                                            <img src="{{ asset('img/other.png') }}" alt="other" id="other" class="register__avatar-image">
                                        </div>

                                    </div>
                                </div>
                                <input type="text" name="default_image" id="default_image" hidden value>
                                <input type="file" name="img" id="img_file" hidden accept=".jpg, .jpeg, .png">
                               <div class="wrapped-form-btn">
                                <button class="update-btn">Оновити</button>
                               </div>
                             </form>
                        </div>
                       </div>
                   </div>
            </div>
        </div>
    </div>

@endsection
