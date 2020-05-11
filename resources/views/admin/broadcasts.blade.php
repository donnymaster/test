@extends('layouts.admin')

@section('title', 'Трансляції')

@section('active-broad', 'selected')

@section('custom-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}"> --}}
@endsection

@section('create-btn')
     <a type="button" href="{{ route('broadcasts.create') }}" class="btn btn-primary">Додати трансляцію</a>
@endsection

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Трансляції</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Трансляції</li>
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
            @if (session('delete'))
                <div class="alert alert-danger text-center" role="alert">
                    {{ session('delete') }}
                </div>
            @endif
             <div class="table-responsive">
                <table class="table table-bordered" id="category-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Назва</th>
                            <th>Команда 1</th>
                            <th>Команда 2</th>
                            <th>Статус</th>
                            <th>Дата трансляції</th>
                            <th class="t-c">Дії</th>
                        </tr>
                    </thead>
                </table>
             </div>
         </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Видалити трансляцію</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h4>Ви впевнені що хочете видалити трансляцію?</h4>
        </div>
        <!-- Modal footer -->
        <form action="{{ route('broadcasts.destroy', ['broadcast' => 0]) }}" method="POST" id="delete-form">
            @csrf
            @method('delete')
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" id="SubmitDeleteProductForm">Так</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Ні</button>
            </div>
        </form>
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
                ordering: true,
                ajax: '{!! route('admin.broadcastsJson') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'team_id_1', name: 'team_1.name' },
                    { data: 'team_id_2', name: 'team_2.name' },
                    { data: 'status', name: 'status' },
                    { data: 'video_start', name: 'video_start_date' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
        $('#category-table').on( 'draw.dt', function () {
           $('.delete-item').on('click', function(){
                var link = $('#delete-form').attr("action");
                var num_last = link.lastIndexOf('/') + 1;
                var new_link = link.substr(0, num_last) + $(this).attr('data-id');
                $('#delete-form').attr('action', new_link);
           });
        } );
    </script>
@endsection
