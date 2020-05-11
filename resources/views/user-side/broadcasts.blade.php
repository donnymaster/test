@extends('layouts.user-side')

@section('title', 'Трансляції')

@section('header-custom', 'logo-broadcast')

@section('content-footer')
    <div class="container">
        <div class="index__offer">
            <h1 class="offer__title">
                Трансляції
            </h1>
            <h3 class="offer_desc">
                Користуючись нашим сайтом у вас з'являється можливість
                полегшити своє життя. При перегляді спортивних
                трансляцій у вас є можливість коментувати матч в
                прямому ефірі, адміністрація бере на себе стежити за
                тим щоб в чаті співрозмовники вели себе порядно. Так
                само адміністрація буде вам повідомляти в прямому ефірі
                що відбувається в спортивному змаганні.
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
            @if($broadcasts->total() != 0)

                <div class="elements__header">
                    <div class="title-header">
                        Трансляції
                    </div>

                </div>
                <div class="broadcast-wrapped {{ $broadcasts->total() <= 2 ? 'j-c-e' : null }}">

                    @foreach ($broadcasts as $broadcast)

                        @include('blocks.broadcast-item', compact('broadcast'))

                    @endforeach

                </div>

                <div class="page-links">
                    {{ $broadcasts->appends(request()->query())->links() }}
                </div>

            @else
                <h1 class="not-items">Трансляції відсутні</h1>
            @endif
    </div>
    </div>
  </div>
@endsection

