<div class="user-logo">
    <img class="user-logo-img" src="{{ Storage::url(Auth::user()->avatar) }}" alt="user-logo">
    <div class="user-menu d-none">
        <ul class="menu-items">
            <li class="menu-item">
                <a class="menu-item__link" style="text-decoration: none;" href="{{ route('user.index') }}">Аккаунт</a>
            </li>
            @if (Auth::user()->role->name_role == 'user')
            <li class="menu-item">
                <a class="menu-item__link" style="text-decoration: none;" href="{{ route('feedback.create') }}">Зв'язок з адміністрацією</a>
            </li>
            @endif
           @if (Auth::user()->role->name_role == 'moderator')
            <li class="menu-item">
                <a class="menu-item__link" style="text-decoration: none;" href="{{ route('admin.index') }}">Управління сайтом</a>
            </li>
           @endif
            <li class="menu-item">
                <a class="menu-item__link" href="#"
                onclick="event.preventDefault();
                         document.getElementById('logout-form-desktop').submit();"
                >Вихід</a>
                <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</div>
