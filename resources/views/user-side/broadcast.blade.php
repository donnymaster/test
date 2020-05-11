@extends('layouts.user-side')

@section('title', $broadcast->name)

@section('header-custom', 'h-auto-2')

@section('content-main')

@section('custom-container', 'custom')

@if ($is_valid)
    @if ($status == 'у прямому ефірі')
        @section('css')
        @if (Auth::check())
        <script src="{{ asset('js/user-chat.js') }}" defer></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        @endif
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            .chat
            {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            ul li.border-b {
                border-bottom: 2px solid #81b928;
            }

            .chat li
            {
                margin-bottom: 10px;
                padding-bottom: 5px;
                border-bottom: 1px dotted #B3A9A9;
            }

            .chat li.left .chat-body
            {
                margin-left: 60px;
            }

            .chat li.right .chat-body
            {
                margin-right: 60px;
            }


            .chat li .chat-body p
            {
                margin: 0;
                color: #777777;
            }

            .panel .slidedown .glyphicon, .chat .glyphicon
            {
                margin-right: 5px;
            }

            .panel-body
            {
                overflow-y: scroll;
                height: 400px;
            }
          </style>
        @endsection
    @endif
@endif

<div class="container">
    <div class="account-breadcrumbs" style="margin-bottom:10px;margin-top:20px">
        <a href="{{ route('broadcasts.index') }}" class="link-breadcrumbs">
            Трансляції
        </a>
        <img src="{{ asset('img/chevron-right.png') }}" alt="arrow-right" class="right-arrow">
        <a href="#" class="link-breadcrumbs">
            {{ $broadcast->name }}
        </a>
    </div>
    <div class="wrapped-top">
    <div class="info-teams">
        <div class="title-into-teams">
            Команди
        </div>
        <div class="broad-team">
            <img src="{{ Storage::url($broadcast->team_1->logo) }}" alt="logo-team" class="logo-team">
            <div class="wrap">
            <a style="text-decoration: none" 
               href="{{ route('teams.show', ['team' => $broadcast->team_1->id]) }}" 
               class="go-team line-link">{{ Str::limit($broadcast->team_1->name, 17) }}
            </a>
            <img src="{{ asset('img/custom-select.png') }}" alt="show/hide" id="btn-team-1">
            <div class="block-team-1">
                <div class="title-block">
                    Гравці в команді
                </div>
                @php
                    $team_1 = json_decode($broadcast->players_in_broadcast->team_1_players, true) ?? array();
                @endphp
                @forelse ($team_1 as $item)
                    <div class="player-item-team">
                        <a class="lenk-player line-link" href="{{ route('players.show', ['player' => $item['id']]) }}">
                            {{ Str::limit($item['name'] . ' ' . $item['surname'], 30) }}
                        </a>
                    </div>
                @empty
                    <div class="player-item-team">
                        Гравці відсутні
                    </div>
                @endforelse
            </div>
            </div>
        </div>
        <div class="broad-team">
            <img src="{{ Storage::url($broadcast->team_2->logo) }}" alt="logo-team" class="logo-team">
            <div class="wrap">
            <a style="text-decoration: none" 
               href="{{ route('teams.show', ['team' => $broadcast->team_2->id]) }}" 
               class="go-team line-link">{{ Str::limit($broadcast->team_2->name, 17) }}
            </a>
            <img src="{{ asset('img/custom-select.png') }}" alt="show/hide" id="btn-team-2">
            <div class="block-team-2">
                <div class="title-block">
                    Гравці в команді
                </div>
                @php
                    $team_2 = json_decode($broadcast->players_in_broadcast->team_2_players, true) ?? array();
                @endphp
                @forelse ($team_2 as $item)
                    <div class="player-item-team">
                        <a class="lenk-player line-link" href="{{ route('players.show', ['player' => $item['id']]) }}">
                            {{ Str::limit($item['name'] . ' ' . $item['surname'], 30) }}
                        </a>
                    </div>
                @empty
                    <div class="player-item-team">
                        Гравці відсутні
                    </div>
                @endforelse
            </div>
            </div>
        </div>
    </div>
</div>
  </div>

  @if ($is_valid)
    @if ($status == 'в майбутньому')
        <input type="text" hidden id="date" value="{{ $date_start }}">
        <div class="container">
            <h2 class="title-info title-info-m">
                <div class="mr-30">До початку залишилося</div> <div class="date"></div>
            </h2>
            <div class="video-upcoming">
                {!!
                    $video
                !!}
            </div>
        </div>
    @endif

    @if ($status == 'у прямому ефірі')
    <div class="container">
        <div class="wrapped-broadcast">
            <div class="video-broadcast">
                {!!
                    $video
                !!}
            </div>
        </div>
        <div class="container">
            <div class="team-line"></div>
        </div>
        @if (Auth::check())
        <div class="container">
            {{--  --}}
            <div id="moderator">
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <span class="glyphicon glyphicon-comment"></span> Події що відбулися в трансляції
                                </div>
                                <div class="panel-body">
                                        <chat-messages :messages="messages" :user="{{ Auth::user() }}"></chat-messages>
                                </div>
                                    @if (Auth::user()->role->name_role == 'moderator')
                                        <div class="panel-footer">

                                            <chat-form
                                            v-on:messagesent="addMessage"
                                            :user="{{ Auth::user() }}"
                                            ></chat-form>

                                        </div>
                                    @endif
                            </div>
                        </div>
            </div>
            {{--  --}}
            {{--  --}}
            <div class="chat-broadcast">
                <input type="text" hidden id="id_broadcast" value="{{ $broadcast->identifier }}" />
                <input type="text" hidden id="user_id" value="{{ Auth::user()->id }}" />
                <div id="app">
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <span class="glyphicon glyphicon-comment"></span> Чат
                                </div>
                                <div class="panel-body" id="scroll-1">                   
                                    <chat-messages :messages="messages" :user="{{ Auth::user() }}"></chat-messages>
                                </div>
                                    <div class="panel-footer">

                                        <chat-form
                                        v-on:messagesent="addMessage"
                                        :user="{{ Auth::user() }}"
                                        ></chat-form>

                                    </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        @endif
        @if (Auth::check())
        <div class="container">
            <div class="team-line"></div>
        </div>
        @endif
        <div class="container">
            <h2 class="title-broad">
                опис
            </h2>
            <div class="desc-broad">
                {{ $broadcast->description }}
            </div>
        </div>
    </div>
    @endif

  @else
    <div class="container">
        <h2 class="title-info">
            Трансляція була видалена
        </h2>
    </div>
    <div class="container">
        <div class="team-line"></div>
    </div>
    <div class="container">
        <h2 class="title-broad">
            опис
        </h2>
        <div class="desc-broad" style="margin-bottom:60px">
            {{ $broadcast->description }}
        </div>
    </div>
  @endif

@endsection
 @if ($is_valid)
    @if ($status == 'в майбутньому')
        @section('script')
            <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
            <script src="{{ asset('js/timezz.min.js') }}"></script>
            <script>
                new TimezZ('.date', {
                    date: document.querySelector('#date').getAttribute('value'),
                    days: 'днів',
                    hours: 'годин',
                    minutes: 'хвилин',
                    seconds: 'секунд',
                    numberTag: 'span',
                    letterTag: 'i',
                    stop: false, // stop the countdown timer?
                });
            </script>
        @endsection
    @endif
@endif
@section('players_in_broadcast')
        <script>
            $('#btn-team-1').on('click', function(){
                $('.block-team-1').toggleClass('show-team');
            });
            $('#btn-team-2').on('click', function(){
                $('.block-team-2').toggleClass('show-team');
            });
        </script>
@endsection
