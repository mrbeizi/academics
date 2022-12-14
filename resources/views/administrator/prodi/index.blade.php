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
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="tombol-tambah" data-bs-toggle="tooltip" data-bs-placement="top" title="Add data"><i class="bx bx-sm bx-plus-circle bx-spin-hover"></i></a>
                            <button type="button" id="show-archived" data-bs-toggle="tooltip" data-bs-placement="top" title="Show archived" class="btn btn-outline-warning btn-xs float-end"><i class="bx bx-xs bx-archive"></i></button>
                        </div>
                        
                        <!-- AKHIR TOMBOL -->
                            <table class="table table-hover table-responsive" id="table_prodi">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Prodi</th>
                                  <th>Dikti Id</th>
                                  <th>Name</th>
                                  <th>Faculty</th>
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
                                            <div class="col-sm-6">

                                                <input type="hidden" name="id" id="id">

                                                <div class="mb-3">
                                                    <label for="kode_prodi" class="form-label">Prodi Code*</label>
                                                    <input type="text" class="form-control" id="kode_prodi" name="kode_prodi" value="" placeholder="e.g ST" />
                                                    <span class="text-danger" id="kodeProdiErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="kode_dikti" class="form-label">Dikti Code*</label>
                                                    <input type="text" class="form-control" id="kode_dikti" name="kode_dikti" value="" placeholder="e.g 54001" onkeypress="return onlyNumeric(event)" />
                                                    <span class="text-danger" id="kodeDiktiErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="kode_nim" class="form-label">NIM Code*</label>
                                                    <input type="text" class="form-control" id="kode_nim" name="kode_nim" value="" placeholder="e.g 123" onkeypress="return onlyNumeric(event)" />
                                                    <span class="text-danger" id="kodeNimErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="jenjang" class="form-label">Edu. Stage*</label>
                                                    <select class="form-select" id="jenjang" name="jenjang" aria-label="Default select example" style="cursor:pointer;">
                                                        <option value="" readonly>- Choose -</option>
                                                        <option value="D3">D3</option>
                                                        <option value="S1">S1</option>
                                                        <option value="S2">S2</option>
                                                        <option value="S3">S3</option>
                                                    </select>
                                                    <span class="text-danger" id="jenjangErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="id_fakultas" class="form-label">Faculty*</label>
                                                    <select class="form-select" id="id_fakultas" name="id_fakultas" aria-label="Default select example" style="cursor:pointer;">
                                                        <option value="">- Choose -</option>
                                                        @foreach($getFaculty as $faculty)
                                                        <option value="{{$faculty->id}}">{{$faculty->nama_id}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" id="idFakultasErrorMsg"></span>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-6">
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
                                                    <label for="nama_id" class="form-label">Name (ID)*</label>
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

                    <!-- SHOW ARCHIVED MODAL-->
                    <div class="modal fade" tabindex="-1" role="dialog" id="show-archived-modal" data-backdrop="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Archived Datas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover table-responsive" id="table_show_archived" width="100%">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Faculty</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                          </tr>
                                        </thead>
                                      </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR SHOW ARCHIVED MODAL-->
                    
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
                {data: 'nama_id',name: 'nama_id',
                    render: function ( data, type, row ) {
                        return row.nama_id + ' (' + row.jenjang + ')';
                    },
                },
                {data: 'nama_fakultas',name: 'nama_fakultas'},
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
                        $('#table_prodi').DataTable().ajax.reload(null, true);
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
                        $('#kodeNimErrorMsg').text(response.responseJSON.errors.kode_nim);
                        $('#jenjangErrorMsg').text(response.responseJSON.errors.jenjang);
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
            $('#kode_nim').val(data.kode_nim);
            $('#jenjang').val(data.jenjang);
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

    /* Archive */
    function archiveProdi(id,is_archived){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('archiveProdi') }}",
            id: $('.archive-prodi'+id+'').val(),
            data:{'is_archived':is_archived,'id':id},
        }).done(function(data, response) {
            $('#table_prodi').DataTable().ajax.reload(null, true);
            $('#table_show_archived').DataTable().ajax.reload(null, true);
            Swal.fire({
                title: 'Success!',
                text: 'Data archived successfully!',
                type: 'success',
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false,
                timer: 2000
            })
        })
    }

    // show archived
    $('#show-archived').click(function () {
        $('#show-archived-modal').modal('show');
    });

    $(document).ready(function () {
        var table = $('#table_show_archived').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('show.archived.prodi') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nama_fakultas',name: 'nama_fakultas'},
                {data: 'nama_id',name: 'nama_id'},
                {data: 'action',name: 'action'},
            ]
        });
    });

    /* Unarchive */
    function unarchiveProdi(id,is_archived){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('unarchiveProdi') }}",
            id: $('.unarchive-prodi'+id+'').val(),
            data:{'is_archived':is_archived,'id':id},
        }).done(function(data, response) {
            $('#table_show_archived').DataTable().ajax.reload(null, true);
            $('#table_prodi').DataTable().ajax.reload(null, true);
            Swal.fire({
                title: 'Success!',
                text: 'Data unarchived successfully!',
                type: 'success',
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false,
                timer: 2000
            })
        })
    }

    function onlyNumeric(event) {
        var angka = (event.which) ? event.which : event.keyCode
        if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
        return true;
    }

</script>

@endsection