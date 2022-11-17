@extends('layouts.backend')
@section('title','Matakuliah')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('matakuliah.index')}}">@yield('title')</a>
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
                            <div>
                                <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="tombol-tambah" data-bs-toggle="tooltip" data-bs-placement="top" title="Add data"><i class="bx bx-sm bx-plus-circle bx-spin-hover"></i></a>
                                <button type="button" id="show-archived" data-bs-toggle="tooltip" data-bs-placement="top" title="Show archived" class="btn btn-outline-warning btn-xs float-end"><i class="bx bx-xs bx-archive"></i></button>
                            </div>
                        </div>
                        
                        <!-- AKHIR TOMBOL -->
                            <table class="table table-hover table-responsive" id="table_matakuliah">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Subject ID</th>
                                  <th>Name ID</th>
                                  <th>TW</th>
                                  <th>PW</th>
                                  <th>Period</th>
                                  <th>Status</th>
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
                                                    <label for="kode" class="form-label">Subject ID*</label>
                                                    <input type="text" class="form-control" id="kode" name="kode" value="" placeholder="Kode Matakuliah" />
                                                    <span class="text-danger" id="kodeErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="nama_id" class="form-label">Name (ID)*</label>
                                                    <input type="text" class="form-control" id="nama_id" name="nama_id" value="" placeholder="Nama ID" />
                                                    <span class="text-danger" id="namaIDErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="nama_en" class="form-label">Name (EN)</label>
                                                    <input type="text" class="form-control" id="nama_en" name="nama_en" value="" placeholder="Nama EN" />
                                                </div>

                                                <div class="mb-3">
                                                    <label for="nama_ch" class="form-label">Name (CH)</label>
                                                    <input type="text" class="form-control" id="nama_ch" name="nama_ch" value="" placeholder="Nama CH" />
                                                </div>                                              
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="sks_teori" class="form-label">Theory Weight*</label>
                                                            <input type="number" class="form-control" id="sks_teori" name="sks_teori" value="" placeholder="0" />
                                                            <span class="text-danger" id="sksTeoriErrorMsg"></span>
                                                        </div>                                                                                                
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="sks_praktek" class="form-label">Prac. Weight*</label>
                                                            <input type="number" class="form-control" id="sks_praktek" name="sks_praktek" value="" placeholder="0" />
                                                            <span class="text-danger" id="sksPraktekErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label for="golongan_matakuliah" class="form-label">Subjects Group*</label>
                                                        <select class="form-select" id="golongan_matakuliah" name="golongan_matakuliah" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            @foreach($getGolMatakuliah as $data)
                                                            <option value="{{$data->id}}">{{$data->nama_golongan}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="golMatakuliahErrorMsg"></span>
                                                    </div>                                                
    
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

                    <!-- MULAI MODAL VIEW DETAIL-->
                    <div class="modal fade" tabindex="-1" role="dialog" id="view_detail" data-backdrop="false">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="table" class="col-sm-12 table-responsive"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR MODAL VIEW DETAIL-->
                    
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
                                            <th>Subject ID</th>
                                            <th>Name ID</th>
                                            <th>Period</th>
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
        var table = $('#table_matakuliah').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('matakuliah.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'kode',name: 'kode'},
                {data: 'nama_id',name: 'nama_id'},
                {data: 'sks_teori',name: 'sks_teori'},
                {data: 'sks_praktek',name: 'sks_praktek'},
                {data: 'nama_periode',name: 'nama_periode'},
                {data: 'status',name: 'status'},
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
                    url: "{{ route('matakuliah.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_matakuliah').DataTable().ajax.reload(null, true);
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
                        $('#kodeErrorMsg').text(response.responseJSON.errors.kode);
                        $('#namaIDErrorMsg').text(response.responseJSON.errors.nama_id);
                        $('#sksTeoriErrorMsg').text(response.responseJSON.errors.sks_teori);
                        $('#sksPraktekErrorMsg').text(response.responseJSON.errors.sks_praktek);
                        $('#golMatakuliahErrorMsg').text(response.responseJSON.errors.golongan_matakuliah);
                        $('#idPeriodeErrorMsg').text(response.responseJSON.errors.id_periode);
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
        $.get('matakuliah/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#nama_id').val(data.nama_id);
            $('#nama_en').val(data.nama_en);
            $('#nama_ch').val(data.nama_ch);
            $('#sks_teori').val(data.sks_teori);
            $('#sks_praktek').val(data.sks_praktek);
            $('#golongan_matakuliah').val(data.golongan_matakuliah);
            $('#id_periode').val(data.id_periode);
        })
    });

    /* UNTUK TOGGLE STATUS */
    function MatakuliahStatus(id,is_active){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('change-matakuliah-status') }}",
            id: $('.matakuliah-status'+id+'').val(),
            data:{'is_active':is_active,'id':id},
        }).done(function(data, response) {
            Swal.fire({
                title: 'Success!',
                text: 'State changed successfully!',
                type: 'success',
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false,
                timer: 2000
            })
        })
    }

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
                        url: "matakuliah/" + dataId,
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
                        $('#table_matakuliah').DataTable().ajax.reload(null, true);
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

    // TOMBOL VIEW
    $(document).on('click', '.view_detail', function () {
        dataId = $(this).attr('id');
        $.ajax({
			url: "{{route('view-detail-matakuliah')}}",
			method: "GET",
			data: {dataId: dataId},
			success: function(response, data){
                $('#view_detail').modal('show');
                $("#table").html(response.table)
			}
		})
    });

    /* Archive */
    function archiveMatakuliah(id,is_archived){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('archiveMatakuliah') }}",
            id: $('.archive-matakuliah'+id+'').val(),
            data:{'is_archived':is_archived,'id':id},
        }).done(function(data, response) {
            $('#table_matakuliah').DataTable().ajax.reload(null, true);
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
            ajax: "{{ route('show.archived.matakuliah') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'kode',name: 'kode'},
                {data: 'nama_id',name: 'nama_id'},
                {data: 'nama_periode',name: 'nama_periode'},
                {data: 'action',name: 'action'},
            ]
        });
    });

    /* Unarchive */
    function unarchiveMatakuliah(id,is_archived){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('unarchiveMatakuliah') }}",
            id: $('.unarchive-matakuliah'+id+'').val(),
            data:{'is_archived':is_archived,'id':id},
        }).done(function(data, response) {
            $('#table_show_archived').DataTable().ajax.reload(null, true);
            $('#table_matakuliah').DataTable().ajax.reload(null, true);
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

</script>

@endsection