@extends('layouts.backend')
@section('title','Data Formulir')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('data-formulir.index')}}">@yield('title')</a>
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
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="tombol-tambah" data-bs-toggle="tooltip" data-bs-placement="top" title="Add data"><i class="bx bx-sm bx-plus-circle"></i></a>
                            <button type="button" id="show-archived" data-bs-toggle="tooltip" data-bs-placement="top" title="Show archived" class="btn btn-outline-warning btn-xs float-end"><i class="bx bx-xs bx-archive"></i></button>
                        </div>
                        
                        <!-- AKHIR TOMBOL -->
                            <table class="table table-hover table-responsive" id="table_data_formulir">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Period ID</th>
                                  <th>Name ID</th>
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

                                                <div class="mb-3">
                                                    <label for="id_periode" class="form-label">Year Period*</label>
                                                    <select class="form-select" id="id_periode" name="id_periode" aria-label="Default select example">
                                                      <option value="">- Choose -</option>
                                                      @foreach($getPeriode as $data)
                                                      <option value="{{$data->id}}">{{$data->nama_periode}}</option>
                                                      @endforeach
                                                    </select>
                                                    <span class="text-danger" id="idPeriodeErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="nama_data" class="form-label">Name Data</label>
                                                    <input type="text" class="form-control" id="nama_data" name="nama_data" value="" placeholder="Data Name" />
                                                    <span class="text-danger" id="namaDataErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="no_urut" class="form-label">No Urut</label>
                                                    <input type="number" class="form-control" id="no_urut" name="no_urut" value="" />
                                                    <span class="text-danger" id="noUrutErrorMsg"></span>
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
                                            <th>Name</th>
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
        var table = $('#table_data_formulir').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('data-formulir.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nama_periode',name: 'nama_periode'},
                {data: 'nama_data',name: 'nama_data'},
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
                    url: "{{ route('data-formulir.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_data_formulir').DataTable().ajax.reload(null, true);
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
                        $('#namaDataErrorMsg').text(response.responseJSON.errors.nama_data);
                        $('#noUrutErrorMsg').text(response.responseJSON.errors.no_urut);
                        $('#tombol-simpan').html('Save');
                        Swal.fire({
                            title: 'Error!',
                            text: ' Data failed to save!',
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
        $.get('data-formulir/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#id_periode').val(data.id_periode);
            $('#nama_data').val(data.nama_data);
            $('#no_urut').val(data.no_urut);
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
                        url: "data-formulir/" + dataId,
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
                        $('#table_data_formulir').DataTable().ajax.reload(null, true);
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
    function archiveDataFormulir(id,is_archived){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('archiveDataFormulir') }}",
            id: $('.archive-data-formulir'+id+'').val(),
            data:{'is_archived':is_archived,'id':id},
        }).done(function(data, response) {
            $('#table_data_formulir').DataTable().ajax.reload(null, true);
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
            ajax: "{{ route('show.archived.dataformulir') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nama_data',name: 'nama_data'},
                {data: 'nama_periode',name: 'nama_periode'},
                {data: 'action',name: 'action'},
            ]
        });
    });

    /* Unarchive */
    function unarchiveDataFormulir(id,is_archived){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('unarchiveDataFormulir') }}",
            id: $('.unarchive-data-formulir'+id+'').val(),
            data:{'is_archived':is_archived,'id':id},
        }).done(function(data, response) {
            $('#table_show_archived').DataTable().ajax.reload(null, true);
            $('#table_data_formulir').DataTable().ajax.reload(null, true);
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