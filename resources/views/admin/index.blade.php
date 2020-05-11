@extends('layouts.admin')

@section('title', 'Головна')

@section('active-main', 'selected')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Головна</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Статистика</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-main')

<div class="row">
    <div class="col-12">
        <div class="card">
            <h4 class="card-title t-c p-3">Графік відвідуваності трансляцій з виду спорту за останні 30 днів</h4>
            <div>
                @if ($chart_views_sport != null)
                    {!! $chart_views_sport->container() !!}
                @else
                <h1 class="text-center">Дані відсутні</h1>
                @endif
            </div>
            <div class="hr"></div>
            <h4 class="card-title t-c p-3">Відвідуваність всіх видів спорту за останні 30 днів</h4>
            <div>
                @if ($chart_type_sport != null)
                    {!! $chart_type_sport->container() !!}
                @else
                    <h1 class="text-center">Дані відсутні</h1>
                @endif
            </div>
            <div class="hr"></div>
            <h4 class="card-title t-c p-3">Кількість запитань від користувачів за останні 30 днів</h4>
            <div>
                @if ($chart_feedback != null)
                    {!! $chart_feedback->container() !!}
                @else
                    <h1 class="text-center">Дані відсутні</h1>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection


@section('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

    @if ($chart_type_sport != null)
        {!! $chart_type_sport->script() !!}
    @endif

    @if ($chart_views_sport != null)
        {!! $chart_views_sport->script() !!}
    @endif

    @if ($chart_feedback != null)
        {!! $chart_feedback->script() !!}
    @endif
@endsection
