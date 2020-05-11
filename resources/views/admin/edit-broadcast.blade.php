@extends('layouts.admin')

@section('title', $broadcast->name)

@section('active-broad', 'selected')

@section('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Редагувати трансляцію</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Головна</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.players') }}">Трансляції</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $broadcast->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-main')

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-9">
      <div class="card">
          <form class="form-horizontal" method="POST" action="{{ route('broadcasts.update', ['broadcast' => $broadcast->id]) }}">
              @csrf
              @method('put')
              <div class="card-body">
                  <h4 class="card-title t-c">{{ $broadcast->name }}</h4>
                  @if (session('update'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('update') }}
                    </div>
                  @endif


                  <div class="form-group row">
                    <label for="name" class="col-sm-3 text-right control-label col-form-label">Назва</label>
                    <div class="col-sm-9">
                      @error('name')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                        <input required type="text" class="form-control" name="name" id="name" placeholder="назва" value="{{ $broadcast->name }}">
                    </div>
                </div>

                <div class="form-group row">
                      <label for="description" class="col-sm-3 text-right control-label col-form-label">Опис</label>
                      <div class="col-sm-9">
                      @error('description')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                          <textarea required id="description" name="description" class="form-control">{{ $broadcast->description }}</textarea>
                      </div>
                  </div>

                <div class="form-group row">
                    <label for="kind_sport_id" class="col-md-3 m-t-15 text-right">Вид спорту</label>
                    <div class="col-md-9">
                      @error('kind_sport_id')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                        <select required name="kind_sport_id" id="kind_sport_id" class="select2 form-control custom-select" style="width: 100%; height:36px;">

                                @forelse ($kind_sports as $sport)
                                      <option value="{{ $sport->id }}"
                                        {{ $broadcast->kind_sport->name_kind_sport == $sport->name_kind_sport ? 'selected' : null }}
                                        >{{ $sport->name_kind_sport }}</option>
                                  @empty
                                      <option value="0">Відсутні</option>
                                  @endforelse
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="url_video" class="col-sm-3 text-right control-label col-form-label">Посилання на відео</label>
                  <div class="col-sm-9">
                    @error('url_video')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                      <input required type="text" class="form-control" name="url_video" id="url_video" placeholder="посилання на відео" value="{{ $broadcast->url_video }}">
                  </div>
              </div>

                <div class="form-group row">
                    <label for="team-1" class="col-md-3 m-t-15 text-right">Команда 1</label>
                    <div class="col-md-9">
                      @error('team_id_1')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                          <input class="form-control d-none" value="{{ $broadcast->team_1->id }}" type="text" id="hidden_team_1" name="team_id_1" value hidden>
                          <input required autocomplete="off" value="{{ $broadcast->team_1->name }}" class="typeahead_1 form-control" type="text" id="team-1" name="default_1">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="team-1" class="col-md-3 m-t-15 text-right">Гравці з першої команди</label>
                    <div class="col-md-9">
                          <div class="wrapped-dynamic-players-1">
                          </div>
                    </div>
                  </div>

                <div class="form-group row">
                    <label for="team-2" class="col-md-3 m-t-15 text-right">Команда 2</label>
                    <div class="col-md-9">
                        @error('team_id_2')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                            <input class="form-control d-none" value="{{ $broadcast->team_2->id }}" type="text" id="hidden_team_2" name="team_id_2" value hidden>
                            <input required autocomplete="off" value="{{ $broadcast->team_2->name }}" class="typeahead_2 form-control" type="text" id="team-2" name="default_2">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="team-2" class="col-md-3 m-t-15 text-right">Гравці з другої команди</label>
                    <div class="col-md-9">
                          <div class="wrapped-dynamic-players-2">
                          </div>
                    </div>
                </div>

              <div class="form-group row">
                  <label for="datepicker-autoclose" class="col-md-3 m-t-15 text-right">Дата початку</label>
                  <div class="col-md-9 input-group">
                      @error('video_start_date')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                      <input type="text" class="form-control" value="{{ $video_start_date }}" required autocomplete="off" name="video_start_date" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                      <div class="input-group-append">
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="video_start_time" class="col-md-3 m-t-15 text-right">Час початку</label>
                  <div class="col-md-9">
                      @error('video_start_time')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                      <input id="video_start_time" value="{{ $broadcast->video_start_time }}" required autocomplete="off" name="video_start_time" type='time' class="form-control" />
                  </div>
              </div>

                  <div class="form-group row">
                    <label for="validatedCustomFile" class="col-md-3 m-t-10 text-right">Обкладинка трансляції</label>
                    <div class="col-md-9">
                        <a target="_blank" href="{{ $broadcast->logo }}" class="badge badge-info">Відкрити в новому вікні</a>
                    </div>
                </div>
              </div>
              <div class="border-top">
                  <div class="card-body d-flex justify-content-center">
                      <button type="submit" class="btn btn-primary">Оновити</button>
                  </div>
              </div>
          </form>
      </div>
    </div>
</div>
    <input type="text" hidden id="players" value="{{ $broadcast->json_players }}">
@endsection


@section('custom-js')
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script src=".{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script>
    //***********************************//
    // For select 2
    //***********************************//
    $(".select2").select2();


     /*datwpicker*/
    jQuery('.mydatepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    var path = "{{ route('admin.complete.teams') }}";
    var root_path = "{{ route('root') }}";
    var url_players = "{{ route('admin.complete.players') }}";
    var url_delete_img = "{{ asset('img/delete.png') }}";

    $('input.typeahead_1').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        },
        afterSelect :function (item){
            var id = item.id;
            $('#hidden_team_1').attr('value', id);
             // вывод игроков команды
             $.get(`${url_players}?id=${id}`, function(data){
                if(data.length === 0){
                    clearChildElements($('.wrapped-dynamic-players-1'));
                    let none_players = document.createElement('div');
                    none_players.innerText = 'Гравці відсутні';
                    $('.wrapped-dynamic-players-1').append(none_players);
                }else{
                    clearChildElements($('.wrapped-dynamic-players-1'));
                    renderPlayers(data, $('.wrapped-dynamic-players-1'), 1);
                }
            });
        }
    });

    $('input.typeahead_2').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        },
        afterSelect :function (item){
            var id = item.id;
            $('#hidden_team_2').attr('value', id);

            $.get(`${url_players}?id=${id}`, function(data){
                if(data.length === 0){
                    clearChildElements($('.wrapped-dynamic-players-2'));
                    let none_players = document.createElement('div');
                    none_players.innerText = 'Гравці відсутні';
                    $('.wrapped-dynamic-players-2').append(none_players);
                }else{
                    clearChildElements($('.wrapped-dynamic-players-2'));
                    renderPlayers(data, $('.wrapped-dynamic-players-2'), 2);
                }
            });
        }
    });

    function renderPlayers(data, el, id_team){
        data.forEach(function(player, index){
            let wrapped = document.createElement('div');
            wrapped.classList.add('player-wrapped');

            let hide_input = document.createElement('input');
            hide_input.name = `players_team_${id_team}_${index}`;
            hide_input.setAttribute('value', `{"name":"${player.name}","surname":"${player.surname}","id":"${player.id}"}`);
            hide_input.hidden = true;
            wrapped.appendChild(hide_input);

            let player_link = document.createElement('a');
            player_link.textContent = `${player.name} ${player.surname}`;
            player_link.href = `${root_path}/players/${player.id}`;
            player_link.target = "_blank";
            wrapped.appendChild(player_link);

            let delete_img = document.createElement('img');
            delete_img.src = url_delete_img;
            delete_img.onclick = deletePlayer;
            wrapped.appendChild(delete_img);

            el.append(wrapped);
        });
    }

    function deletePlayer(e){
        var path = e.path || (e.composedPath && e.composedPath());
        path[1].remove();
    }

    function clearChildElements(el){
       el.empty();
    }

    // выбрать игроков
    var url_init_players = "{{ route('admin.complete.all-teams-init') }}";
    function getPlayersOnUpdate(){
        id_players = $('#players').val();
        $.get(`${url_init_players}?id=${id_players}`, function(data){

               render_to_update($('.wrapped-dynamic-players-1'), JSON.parse(data[0].team_1_players), 1);
               render_to_update($('.wrapped-dynamic-players-2'), JSON.parse(data[0].team_2_players), 2);

            });
    }
    getPlayersOnUpdate();
    
    function render_to_update(el, data, id_team){
        if(data == null){
            let none_players = document.createElement('div');
            none_players.innerText = 'Гравці відсутні';
            $(`.wrapped-dynamic-players-${id_team}`).append(none_players);
            return;
        }
        data.forEach(function(player, index){
            let wrapped = document.createElement('div');
            wrapped.classList.add('player-wrapped');

            let hide_input = document.createElement('input');
            hide_input.name = `players_team_${id_team}_${index}`;
            hide_input.setAttribute('value', `{"name":"${player.name}","surname":"${player.surname}","id":"${player.id}"}`);
            hide_input.hidden = true;
            wrapped.appendChild(hide_input);

            let player_link = document.createElement('a');
            player_link.textContent = `${player.name} ${player.surname}`;
            player_link.href = `${root_path}/players/${player.id}`;
            player_link.target = "_blank";
            wrapped.appendChild(player_link);

            let delete_img = document.createElement('img');
            delete_img.src = url_delete_img;
            delete_img.onclick = deletePlayer;
            wrapped.appendChild(delete_img);

            el.append(wrapped);
        });
    }

</script>
@endsection
