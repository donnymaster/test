@extends('layouts.user-side')

@section('title', $player->name)

@section('header-custom', 'h-auto-2')

@section('content-main')

<div class="container">
    <div class="account-breadcrumbs">
        <a href="{{ route('players.index') }}" class="link-breadcrumbs">
            Спортсмени
        </a>
        <img src="{{ asset('img/chevron-right.png') }}" alt="arrow-right" class="right-arrow">
        <a href="#" class="link-breadcrumbs">
            {{ $player->name }}
        </a>
    </div>
  </div>

  <div class="container">
    <div class="team">
        <div class="team__logo">
            <img src="{{ Storage::url($player->avatar) }}" alt="team">
        </div>
        <div class="team__desc">
            <div class="team-name">
                {{ $player->name }}
                {{ $player->surname }}
                <span class="team-abbr"> | Ігровий номер {{ $player->game_number }}</span>
            </div>
            <div class="wrapped-team-info">
                <div class="team-city">{{ $player->city }}</div>
                <div class="team-type-sport">{{ $player->kind_sport->name_kind_sport }}</div>
                <div class="team-type-sport">
                    <a href="{{ route('teams.show', ['team' => $player->teams->id]) }}" class="link-team">
                        {{ $player->teams->name }}
                    </a>
                </div>
            </div>
            <div class="team-desc">
               {{ $player->description }}
            </div>
        </div>
    </div>
  </div>
  <div class="container">
      <div class="team-line"></div>
  </div>
  <div class="team-and-broadcasts">
      <!-- cards -->
  </div>

@endsection
