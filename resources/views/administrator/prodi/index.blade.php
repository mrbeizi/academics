@extends('layouts.backend')
@section('title','Prodi')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('prodi.index')}}">@yield('title')</a>
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
                            <table class="table table-hover table-responsive" id="table_prodi">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Faculty ID</th>
                                  <th>Dikti ID</th>
                                  <th>Name</th>
                                  <th>Faculty</th>
                                  <th>Period</th>
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
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                        <div class="row">
                                            <div class="col-sm-6">

                                                <input type="hidden" name="id" id="id">

                                                <div class="mb-3">
                                                    <label for="kode_prodi" class="form-label">Prodi ID</label>
                                                    <input type="text" class="form-control" id="kode_prodi" name="kode_prodi" value="" placeholder="e.g 54001" />
                                                    <span class="text-danger" id="kodeProdiErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="kode_dikti" class="form-label">Dikti ID</label>
                                                    <input type="text" class="form-control" id="kode_dikti" name="kode_dikti" value="" placeholder="e.g 54001" />
                                                    <span class="text-danger" id="kodeDiktiErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="id_fakultas" class="form-label">Faculty</label>
                                                    <select class="form-select" id="id_fakultas" name="id_fakultas" aria-label="Default select example">
                                                        <option selected>- Choose -</option>
                                                        @foreach($getFaculty as $faculty)
                                                        <option value="{{$faculty->id}}">{{$faculty->nama_id}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" id="idFakultasErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="id_periode" class="form-label">Year Period</label>
                                                    <select class="form-select" id="id_periode" name="id_periode" aria-label="Default select example">
                                                        <option selected>- Choose -</option>
                                                        @foreach($getPeriode as $data)
                                                        <option value="{{$data->id}}">{{$data->tahun}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" id="idPeriodeErrorMsg"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="nama_id" class="form-label">Name (ID)</label>
                                                    <input type="text" class="form-control" id="nama_id" name="nama_id" value="" placeholder="John Doe" />
                                                    <span class="text-danger" id="namaIDErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="nama_en" class="form-label">Name (EN)</label>
                                                    <input type="text" class="form-control" id="nama_en" name="nama_en" value="" placeholder="John Doe" />
                                                </div>

                                                <div class="mb-3">
                                                    <label for="nama_ch" class="form-label">Name (CH)</label>
                                                    <input type="text" class="form-control" id="nama_ch" name="nama_ch" value="" placeholder="John Doe" />
                                                </div>
                                            </div>
                                            <hr class="mt-2">
                                            <div class="col-sm-offset-2 col-sm-12">
                                                <button type="submit" class="btn btn-primary btn-block float-sm-end" id="tombol-simpan" value="create">Save</button>
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
        var table = $('#table_prodi').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('prodi.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'kode_prodi',name: 'kode_prodi'},
                {data: 'kode_dikti',name: 'kode_dikti'},
                {data: 'nama_id',name: 'nama_id'},
                {data: 'nama_fakultas',name: 'nama_fakultas'},
                {data: 'tahun',name: 'tahun'},
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
                    url: "{{ route('prodi.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        var oTable = $('#table_prodi').dataTable();
                        oTable.fnDraw(false);
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
                        $('#kodeProdiErrorMsg').text(response.responseJSON.errors.kode_prodi);
                        $('#kodeDiktiErrorMsg').text(response.responseJSON.errors.kode_dikti);
                        $('#idFakultasErrorMsg').text(response.responseJSON.errors.id_fakultas);
                        $('#idPeriodeErrorMsg').text(response.responseJSON.errors.id_periode);
                        $('#namaIDErrorMsg').text(response.responseJSON.errors.nama_id);
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
        $.get('prodi/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#kode_prodi').val(data.kode_prodi);
            $('#kode_dikti').val(data.kode_dikti);
            $('#id_fakultas').val(data.id_fakultas);
            $('#id_periode').val(data.id_periode);
            $('#nama_id').val(data.nama_id);
            $('#nama_en').val(data.nama_en);
            $('#nama_ch').val(data.nama_ch);
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
                        url: "prodi/" + dataId,
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
                        $('#table_prodi').DataTable().ajax.reload(null, true);
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