@extends('layouts.backend')
@section('title','Fakultas')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('fakultas.index')}}">@yield('title')</a>
      </li>
      <li class="breadcrumb-item active">Data</li>
    </ol>
</nav>
</div>
@endsection

@section('content')

<div class="container flex-grow-1 container-p-y">
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- MULAI TOMBOL TAMBAH -->
                        <div style="float: left">
                            <a href="javascript:void(0)" class="btn btn-info btn-sm" id="tombol-tambah"><i class="fa fa-plus"></i> Add Data</a>
                        </div>
                        <br>
                        <br>                        
                        
                        <!-- AKHIR TOMBOL -->
                        <div class="card-datatable table-responsive pt-0">
                            <table class="table table-borderless table-hover table-sm" id="table_fakultas">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Periode</th>
                                <th>Nama Fakultas</th>
                                <th>Arsip</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
         
@endsection
@section('script')
  
  <!-- Core JS -->
  <script>
      $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // DATATABLE
    $(document).ready(function () {
        $.noConflict();
        var table = $('#table_fakultas').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('fakultas.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'id_periode',name: 'id_periode'},
                {data: 'nama_id',name: 'nama_id'},
                {data: 'is_archived',name: 'is_archived'},
                {data: 'action',name: 'action'},
            ]
        });
    });

    
  </script>
@endsection