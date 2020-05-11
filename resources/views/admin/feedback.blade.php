@extends('layouts.admin')

@section('title', 'Питання від користувачів')

@section('active-feedback', 'selected')

@section('custom-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}"> --}}
@endsection

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Питання від користувачів</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Питання від користувачів</li>
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
         <div class="card-body">

            @isset($email_send)
                <div class="alert alert-primary text-center" role="alert">
                    {{ $email_send }}
                </div>
            @endisset

            @isset($error_send)
                <div class="alert alert-danger text-center" role="alert">
                    {{ $error_send }}
                </div>
            @endisset

             <div class="table-responsive">
                <table class="table table-bordered" id="category-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Ім'я користувача</th>
                            <th>Пошта</th>
                            <th>Питання</th>
                            <th>Дата додавання</th>
                            <th class="t-c">Дії</th>
                        </tr>
                    </thead>
                </table>
             </div>
         </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#category-table').DataTable({
                language: {
                "emptyTable": "Дані відсутні в таблиці",
                "loadingRecords": "Завантаження...",
                "processing": "Завантаження..."
                },
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.feedbacksJson') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user_name', name: 'user_name' },
                    { data: 'user_email', name: 'user_email' },
                    { data: 'message', name: 'message' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });

    </script>
@endsection
