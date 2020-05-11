@extends('layouts.admin')

@section('title', 'Форма відповіді на питання')

@section('active-feedback', 'selected')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Форма відповіді на питання</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Форма відповіді на питання</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-main')

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
      <div class="card">
          <form class="form-horizontal" method="POST" action="{{ route('admin.answerQuestion') }}">
              @csrf
              <div class="card-body">
                  <h4 class="card-title t-c">Форма відповіді на питання</h4>
                    <div class="form-group row">
                        <label for="description" class="col-sm-2 text-right control-label col-form-label">Питання від {{ $feedback->user_name }}</label>
                        <div class="col-sm-10">
                            <textarea id="description" class="form-control h-250">{{ $feedback->message }}</textarea>
                        </div>
                    </div>

                    <input type="text" hidden name="user_name" value="{{ $feedback->user_name }}">
                    <input type="text" hidden name="user_email" value="{{ $feedback->user_email }}">
                    <input type="text" hidden name="id" value="{{ $feedback->id }}">

                    <div class="form-group row">
                        <label for="answer-admin" class="col-sm-2 text-right control-label col-form-label">Ваша відповідь</label>
                        <div class="col-sm-10">
                        @error('answer-admin')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                            <textarea required id="answer-admin" name="answer-admin" class="form-control h-250"></textarea>
                        </div>
                    </div>
              </div>
              <div class="border-top">
                  <div class="card-body d-flex justify-content-center">
                      <button type="submit" class="btn btn-primary">Надіслати</button>
                  </div>
              </div>
          </form>
      </div>
    </div>
</div>

@endsection

