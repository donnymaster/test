@if (!Auth::check())
    <div class="nav__btn">
        <a href="{{ route('login') }}" class="btn">
            Вхід
        </a>
        <a href="{{ route('register') }}" class="btn m-l-10">
            Реєстрація
        </a>
    </div>
@endif
