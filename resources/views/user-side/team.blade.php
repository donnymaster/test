@extends('layouts.user-side')

@section('title', $team->name)

@section('header-custom', 'h-auto-2')

@section('content-main')

<div class="container">
    <div class="account-breadcrumbs">
        <a href="{{ route('teams.index') }}" class="link-breadcrumbs">
            Команди
        </a>
        <img src="{{ asset('img/chevron-right.png') }}" alt="arrow-right" class="right-arrow">
        <a href="#" class="link-breadcrumbs">
            {{ $team->name }}
        </a>
    </div>
  </div>

  <div class="container">
    <div class="team">
        <div class="team__logo">
            <img src="{{ Storage::url($team->logo)  }}" alt="team">
        </div>
        <div class="team__desc">
            <div class="team-name">
                {{ $team->name }}
                <span class="team-abbr">{{ $team->abbr }}</span>
            </div>
            <div class="wrapped-team-info">
                <div class="team-type-sport">{{ $team->kind_sport->name_kind_sport }}</div>
            <div class="team-city">{{ $team->city }}</div>
            </div>
            <div class="team-desc">
               {{ $team->description }}
            </div>
        </div>
    </div>
  </div>
  <div class="container">
      <div class="team-line"></div>
  </div>

  <div class="container">
    <div class="players-in-team">
        <div class="title-players">Гравці в команді</div>
        <div class="wrapped-items-players">

            @php
                $route_name = 'players.show';
                $parameter_name = 'player';
            @endphp

            @forelse ($players as $item)

                @include('blocks.card-item', compact('item'))

            @empty
                <h1 class="not-items">Гравці відсутні</h1>
            @endforelse
        </div>

        <div class="page-links">
            {{ $players->links() }}
        </div>
      </div>
  </div>

@endsection
