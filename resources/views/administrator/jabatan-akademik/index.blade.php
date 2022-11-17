@extends('layouts.backend')
@section('title','Jabatan Akademik')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('jabatan-akademik.index')}}">@yield('title')</a>
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
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="tombol-tambah" data-bs-toggle="tooltip" data-bs-placement="top" title="Add data"><i class="bx bx-sm bx-plus-circle bx-spin-hover"></i></a>
                        </div>
                        
                        <!-- AKHIR TOMBOL -->
                            <table class="table table-hover table-responsive" id="table_jabatan_akademik">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Period</th>
                                  <th>Name</th>
                                  <th>Jabatan</th>
                                  <th>Fakultas</th>
                                  <th>Prodi</th>
                                  <th>Actions</th>
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                        <div class="row">
                                            <div class="col-sm-12">                                                
                                                <input type="hidden" name="id" id="id">
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label for="id_periode" class="form-label">Year Period*</label>
                                                        <select class="form-select" id="id_periode" name="id_periode" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            @foreach($getPeriode as $data)
                                                            <option value="{{$data->id}}">{{$data->nama_periode}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="idPeriodeErrorMsg"></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="id_pegawai" class="form-label">Nama Pegawai*</label>
                                                        <select class="form-select" id="id_pegawai" name="id_pegawai" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            @foreach($getPegawai as $data)
                                                            <option value="{{$data->id}}">{{$data->nama_in}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="idPegawaiErrorMsg"></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="id_jabatan" class="form-label">Jabatan*</label>
                                                        <select class="form-select" id="id_jabatan" name="id_jabatan" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            @foreach($getJabatan as $data)
                                                            <option value="{{$data->id}}">{{$data->nama_in}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="idJabatanErrorMsg"></span>
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="fakultas" class="form-label">Fakultas*</label>
                                                            <select class="form-select" id="fakultas" name="fakultas" aria-label="Default select example" style="cursor:pointer;">
                                                                <option value="">- Choose -</option>
                                                                @foreach($getFakultas as $data)
                                                                <option value="{{$data->id}}">{{$data->nama_id}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger" id="fakultasErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="prodi" class="form-label">Prodi*</label>
                                                            <select class="form-select" id="prodi" name="prodi" aria-label="Default select example" style="cursor:pointer;">
                                                                <option value="">- Choose -</option>
                                                                @foreach($getProdi as $data)
                                                                <option value="{{$data->id}}">{{$data->nama_id}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger" id="prodiErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-offset-2 col-sm-12">
                                                <hr class="mt-2">
                                                <div class="float-sm-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="create">Save</button>
                                                </div>
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
        var table = $('#table_jabatan_akademik').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('jabatan-akademik.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nama_periode',name: 'nama_periode'},
                {data: 'nama_pegawai',name: 'nama_pegawai'},
                {data: 'nama_jabatan',name: 'nama_jabatan'},
                {data: 'nama_fakultas',name: 'nama_fakultas'},
                {data: 'nama_prodi',name: 'nama_prodi'},
                {data: 'action',name: 'action'},
            ]
        });
    });

    //TOMBOL TAMBAH DATA
    $('#tombol-tambah').click(function () {
        $('#button-simpan').val("create-post");
        $('#id').val('');
        $('#form-tambah-edit').trigger("reset");
        $('#modal-judul').html("Add new data");
        $('#tambah-edit-modal').modal('show');
    });

    // TOMBOL TAMBAH
    if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                $('#tombol-simpan').html('Saving..');

                $.ajax({
                    data: $('#form-tambah-edit').serialize(), 
                    url: "{{ route('jabatan-akademik.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_jabatan_akademik').DataTable().ajax.reload(null, true);
                        Swal.fire({
                            title: 'Good job!',
                            text: 'Data saved successfully!',
                            type: 'success',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                            timer: 2000
                        })
                    },
                    error: function(response) {
                        $('#idPeriodeErrorMsg').text(response.responseJSON.errors.id_periode);
                        $('#idJabatanErrorMsg').text(response.responseJSON.errors.id_jabatan);
                        $('#idPegawaiErrorMsg').text(response.responseJSON.errors.id_pegawai);
                        $('#fakultasErrorMsg').text(response.responseJSON.errors.fakultas);
                        $('#prodiErrorMsg').text(response.responseJSON.errors.prodi);
                        $('#tombol-simpan').html('Save');
                        Swal.fire({
                            title: 'Error!',
                            text: 'Data failed to save!',
                            type: 'error',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                            timer: 2000
                        })
                    }
                });
            }
        })
    }

    // EDIT DATA
    $('body').on('click', '.edit-post', function () {
        var data_id = $(this).data('id');
        $.get('jabatan-akademik/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#id_periode').val(data.id_periode);
            $('#id_jabatan').val(data.id_jabatan);
            $('#id_pegawai').val(data.id_pegawai);
            $('#fakultas').val(data.fakultas);
            $('#prodi').val(data.prodi);
        })
    });

    // TOMBOL DELETE
    $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "It will be deleted permanently!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: "jabatan-akademik/" + dataId,
                        type: 'DELETE',
                        data: {id:dataId},
                        dataType: 'json'
                    }).done(function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your data has been deleted.',
                            type: 'success',
                            timer: 2000
                        })
                        $('#table_jabatan_akademik').DataTable().ajax.reload(null, true);
                    }).fail(function() {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Something went wrong with ajax!',
                            type: 'error',
                            timer: 2000
                        })
                    });
                });
            },
        });
    });

</script>

@endsection