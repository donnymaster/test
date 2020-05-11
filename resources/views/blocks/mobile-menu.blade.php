                  <!-- modile menu -->
                  <a href="#" id="menuBtn">
                    <span class="lines"></span>
                </a>
                <div class="mainMenu">
                    <ul>
                        <li>
                            <a href="{{ route('broadcasts.index') }}">ТРАНСЛЯЦІЇ</a>
                        </li>
                        <li>
                            <a href="{{ route('teams.index') }}">КОМАНДИ</a>
                        </li>
                        <li>
                            <a href="{{ route('players.index') }}">СПОРТСМЕНИ</a>
                        </li>
                        @if (Auth::check())
                        <li>
                            <a href="{{ route('user.index') }}">Аккаунт</a>
                        </li>
                       @if (Auth::user()->role->name_role == 'user')
                        <li>
                            <a href="{{ route('feedback.create') }}">Зв'язок з адміністрацією</a>
                        </li>
                       @endif
                       @if (Auth::user()->role->name_role == 'moderator')
                        <li>
                            <a href="{{ route('admin.index') }}">Управління сайтом</a>
                        </li>
                       @endif
                        <li>
                            <a href="#"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"
                            >Вихід</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="btn suBtn">
                                    Вхід
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}" class="btn suBtn">
                                    Реєстрація
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- end -->
