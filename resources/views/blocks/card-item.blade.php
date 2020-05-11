<a class="card-teams-item" href="{{ route($route_name, [$parameter_name => $item->id]) }}">
    <div class="card-teams-item--link">
        <img class="card-link-arrow" src="{{ asset('img/forward-arrow.png') }}" alt="arrow">
    </div>
        <div class="card-teams-img">
            @isset($item->avatar)
                <img src="{{ Storage::url($item->avatar) }}" alt="team">
            @endisset
            @isset($item->logo)
            <img src="{{ Storage::url($item->logo) }}" alt="team">
        @endisset
        </div>
        <div class="card-teams-body">
            <div class="card-teams-title">
                @isset($item->abbr)
                    {{ $item->name }}
                @endisset
                {{-- @isset($item->surname)
                    {{ $item->surname }} <span class="year_player">{{ $item->date_birth }}</span>
                @endisset --}}
                @isset($item->surname)
                    {{ $item->surname }} <span class="year_player">{{ \Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::parse($item->date_birth)) }} років</span>
                @endisset
            </div>
            <div class="card-teams-info">
                <div class="card-teams-info__city">
                    {{ $item->city }}
                </div>
                <div class="card-teams-info__sport">
                    {{ $item->kind_sport->name_kind_sport }}
                </div>
            </div>
            <div class="card-teams-desc">
                {{ Str::words($item->description, 20 , '...') }}
            </div>
        </div>
</a>
