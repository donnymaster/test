@extends('layouts.admin')

@section('title', $team->name)

@section('active-teams', 'selected')

@section('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">{{ $team->name }}</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Головна</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.teams') }}">Команди</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $team->name }}</li>
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
          <form class="form-horizontal" method="POST" action="{{ route('teams.update', ['team' => $team->id]) }}" enctype="multipart/form-data">
              @csrf
              @method('put')
              <div class="card-body">
                  <h4 class="card-title t-c">{{ $team->name }}</h4>
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
                          <input required type="text" class="form-control" name="name" id="name" placeholder="назва" value="{{ $team->name }}">
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
                                    {{ $team->kind_sport->name_kind_sport == $sport->name_kind_sport ? 'selected' : null }}
                                    >{{ $sport->name_kind_sport }}</option>
                            @empty
                                <option value="0">Відсутні</option>
                            @endforelse
                        </select>
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
                          <input required type="text" class="form-control" name="city" id="city" placeholder="місто" value="{{ $team->city }}">
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
                          <textarea required id="description" name="description" class="form-control">{{ $team->description }}</textarea>
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="validatedCustomFile" class="col-md-3 m-t-10 text-right">Змінити аватар</label>
                      <div class="col-md-9">
                        @error('logo')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" id="validatedCustomFile" name="logo">
                              <label class="custom-file-label" for="validatedCustomFile">Виберіть файл...</label>
                              <div class="invalid-feedback">Example invalid custom file feedback</div>
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                    <label for="validatedCustomFile" class="col-md-3 m-t-10 text-right">Поточний аватар</label>
                    <div class="col-md-9">
                        <a target="_blank" href="{{ Storage::url($team->logo) }}" class="badge badge-info">Відкрити в новому вікні</a>
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

</script>
@endsection
