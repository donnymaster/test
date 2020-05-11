<div class="broadcast__item">
    <div class="logo_broadcast">
        <img src="{{ $broadcast->logo }}" alt="broad-img" class="broad-fon">
        <div class="status-broadcast">
            @if ($broadcast->status == 'у прямому ефірі')
                <img src="{{ asset('img/online-1.png') }}" alt="status" class="img-status">
            @else
                <img src="{{ asset('img/offline-2.png') }}" alt="status" class="img-status">
            @endif
        </div>
    </div>
    <div class="desc_broadcast">
        <div class="desc_broadcast__head-m">
           <a class="desc_broadcast__title line-link" href="{{ route('broadcasts.show', ['broadcast' => $broadcast->id]) }}">
           {{ Str::limit($broadcast->name, 32) }} </a>
            <div class="card-teams-info__city-m"> {{ $broadcast->kind_sport->name_kind_sport }}</div>
            <div class="status-noty">
                <div class="add-noty">
                    <form action="#">

                    </form>
                </div>
            </div>
        </div>
        <div class="desc_broadcast__desc">
            {{ Str::limit($broadcast->description, 210) }}
        </div>
    </div>
</div>
