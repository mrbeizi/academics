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

<div class="container flex-grow-1">
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- MULAI TOMBOL TAMBAH -->
                        <div class="mb-3">
                            <a href="javascript:void(0)" class="btn btn-primary btn-md" id="tombol-tambah"><i class="fa fa-plus"></i> Add Data</a>
                        </div>
                        
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

                    <!-- MULAI MODAL FORM TAMBAH/EDIT-->
                    <div class="modal fade" id="tambah-edit-modal" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-judul"></h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                        <div class="row">
                                            <div class="col-sm-12">

                                                <input type="hidden" name="id" id="id">

                                                <div class="form-group">
                                                    <label for="name" class="col-sm-12 control-label">Nama Pengguna</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" id="name" name="name" value="" required>
                                                        <span class="text-danger" id="nameErrorMsg"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="name" class="col-sm-12 control-label">E-mail</label>
                                                    <div class="col-sm-12">
                                                        <input type="email" class="form-control" id="email" name="email" value="" required>
                                                        <span class="text-danger" id="emailErrorMsg"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="password" class="col-sm-12 control-label">Password</label>
                                                    <div class="col-sm-12">
                                                        <input type="password" class="form-control" id="password" name="password" value="" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="level" class="col-sm-12 control-label">Level</label>
                                                    <div class="col-sm-12">
                                                        <select name="level" id="level" class="form-control required" style="cursor:pointer;">
                                                            <option value="">Level Pengguna</option>
                                                            <option value="admin">Admin</option>
                                                            <option value="user">User</option>
                                                        </select>
                                                        <span class="text-danger" id="levelErrorMsg"></span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-sm-offset-2 col-sm-12">
                                                <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="create">Simpan</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR MODAL -->
                    
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

    //TOMBOL TAMBAH DATA
    $('#tombol-tambah').click(function () {
        $('#button-simpan').val("create-post");
        $('#id').val('');
        $('#form-tambah-edit').trigger("reset");
        $('#modal-judul').html("Tambah User Baru");
        $('#tambah-edit-modal').modal('show');
    });

    
  </script>
@endsection