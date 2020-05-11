@extends('layouts.admin')

@section('title', $player->name)

@section('active-players', 'selected')

@section('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Редагувати гравця</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Головна</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.players') }}">Гравці</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $player->name }}</li>
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
          <form class="form-horizontal" method="POST" action="{{ route('players.update', ['player' => $player->id]) }}" enctype="multipart/form-data">
              @csrf
              @method('put')
              <div class="card-body">
                  <h4 class="card-title t-c">{{ $player->name }}</h4>
                  @if (session('update'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('update') }}
                    </div>
                  @endif
                  <div class="form-group row">
                      <label for="name" class="col-sm-3 text-right control-label col-form-label">Ім'я</label>
                      <div class="col-sm-9">
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          <input required type="text" class="form-control" name="name" id="name" placeholder="ім'я" value="{{ $player->name }}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="surname" class="col-sm-3 text-right control-label col-form-label">Прізвище</label>
                      <div class="col-sm-9">
                        @error('surname')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          <input required type="text" class="form-control" name="surname" id="surname" placeholder="прізвище" value="{{ $player->surname }}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="game_number" class="col-sm-3 text-right control-label col-form-label">Ігровий номер</label>
                      <div class="col-sm-9">
                        @error('game_number')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          <input required type="number" min="0" name="game_number" class="form-control" id="game_number" placeholder="ігровий номер" value="{{ $player->game_number }}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="city" class="col-sm-3 text-right control-label col-form-label">Місто</label>
                      <div class="col-sm-9">
                        @error('city')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          <input required type="text" class="form-control" name="city" id="city" placeholder="місто" value="{{ $player->city }}">
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
                          <textarea required id="description" name="description" class="form-control">{{ $player->description }}</textarea>
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
                                            {{ $player->kind_sport->name_kind_sport == $sport->name_kind_sport ? 'selected' : null }}
                                            >{{ $sport->name_kind_sport }}</option>
                                    @empty
                                        <option value="0">Відсутні</option>
                                    @endforelse
                          </select>
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="team" class="col-md-3 m-t-15 text-right">Команда</label>
                      <div class="col-md-9">
                        @error('team_id')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                            <input value="{{ $player->teams->id }}" class="typeahead form-control d-none" type="text" id="hidden_team" name="team_id" value hidden>
                          <input value="{{$player->teams->name}}" required autocomplete="off" class="typeahead form-control" type="text" id="team_id" name="default">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="datepicker-autoclose" class="col-md-3 m-t-15 text-right">Дата народження</label>
                      <div class="col-md-9 input-group">
                        @error('date_birth')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          <input value="{{ $date_birth }}" autocomplete="off" required name="date_birth" type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                          <div class="input-group-append">
                              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="validatedCustomFile" class="col-md-3 m-t-10 text-right">Змінити аватар</label>
                      <div class="col-md-9">
                        @error('avatar_update')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" id="validatedCustomFile" name="avatar_update">
                              <label class="custom-file-label" for="validatedCustomFile">Виберіть файл...</label>
                              <div class="invalid-feedback">Example invalid custom file feedback</div>
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                    <label for="validatedCustomFile" class="col-md-3 m-t-10 text-right">Поточний аватар</label>
                    <div class="col-md-9">
                        <a target="_blank" href="{{ Storage::url($player->avatar) }}" class="badge badge-info">Відкрити в новому вікні</a>
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
    $('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        },
        afterSelect :function (item){
            var id = item.id;
            $('#hidden_team').attr('value', id);
        }
    });
</script>
@endsection
