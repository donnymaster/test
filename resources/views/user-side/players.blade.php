@extends('layouts.user-side')

@section('title', 'Спортсмени')

@section('header-custom', 'logo-teams')

@section('content-footer')
  <div class="container">
    <div class="index__offer">
        <h1 class="offer__title">
            Спортсмени
        </h1>
        <h3 class="offer_desc">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia hic pariatur magni.
            Magnam, blanditiis incidunt? Expedita explicabo, corporis repellendus temporibus
            dolorum libero eius repellat optio quia impedit debitis facilis consequatur!Esse
            in ad officiis labore, distinctio atque quos maiores, repudiandae aliquid corporis
            alias non totam odit, ut officia numquam quam fugiat ducimus eius! Nisi accusamus
            nihil sapiente cupiditate temporibus quisquam.
        </h3>
    </div>
  </div>
@endsection

@section('content-main')

<div class="container">
    <div class="two-column">
        <div class="two-column__filter">

              @include('blocks.filter-teams')

        </div>
        <div class="two-column__elements">
                @if($players->total() != 0)

                    <div class="elements__header">
                        <div class="title-header">
                            Спортсмени
                        </div>

                        @include('blocks.sort-items', ['parent_link' => 'players.index'])

                    </div>
                    <div class="team-wrapped {{ $players->total() <= 2 ? 'j-c-e' : null }}">

                        @php
                            $route_name = 'players.show';
                            $parameter_name = 'player';
                        @endphp

                        @foreach ($players as $item)

                            @include('blocks.card-item', compact('item'))

                        @endforeach

                    </div>

                    <div class="page-links">
                        {{ $players->appends(request()->query())->links() }}
                    </div>

                @else
                    <h1 class="not-items">Спортсмени відсутні</h1>
                @endif
        </div>
    </div>
  </div>
@endsection
