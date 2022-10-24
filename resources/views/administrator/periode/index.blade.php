@extends('layouts.backend')
@section('title','Periode')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('periode.index')}}">@yield('title')</a>
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
                            <table class="table table-hover table-responsive" id="table_periode">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Code</th>
                                  <th>Period Name</th>
                                  <th>Open</th>
                                  <th>Close</th>
                                  <th>State</th>
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
                                                    <label for="kode" class="form-label">Period ID</label>
                                                    <input type="text" class="form-control" id="kode" name="kode" value="" placeholder="UV001" />
                                                    <span class="text-danger" id="kodeErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="nama_periode" class="form-label">Period Name</label>
                                                    <input type="text" class="form-control" id="nama_periode" name="nama_periode" value="" placeholder="e.g Ganjil" />
                                                    <span class="text-danger" id="namaPeriodeErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="input_nilai" class="form-label">Value</label>
                                                    <input type="number" class="form-control" id="input_nilai" name="input_nilai" value="" placeholder="0" />
                                                    <span class="text-danger" id="inputNilaiErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="temp_open" class="form-label">Temp. Open</label>
                                                    <input type="number" class="form-control" id="temp_open" name="temp_open" value="" placeholder="0" />
                                                    <span class="text-danger" id="tempOpenErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="finish" class="form-label">Finish</label>
                                                    <input type="number" class="form-control" id="finish" name="finish" value="" placeholder="0" />
                                                    <span class="text-danger" id="finishErrorMsg"></span>
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
        var table = $('#table_periode').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('periode.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'kode',name: 'kode'},
                {data: 'nama_periode',name: 'nama_periode'},
                {data: 'temp_open',name: 'temp_open'},
                {data: 'finish',name: 'finish'},
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
                    url: "{{ route('periode.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        var oTable = $('#table_periode').dataTable();
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
                        $('#kodeErrorMsg').text(response.responseJSON.errors.kode);
                        $('#namaPeriodeErrorMsg').text(response.responseJSON.errors.nama_periode);
                        $('#inputNilaiErrorMsg').text(response.responseJSON.errors.input_nilai);
                        $('#tempOpenErrorMsg').text(response.responseJSON.errors.temp_open);
                        $('#finishErrorMsg').text(response.responseJSON.errors.finish);
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
        $.get('periode/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#nama_periode').val(data.nama_periode);
            $('#input_nilai').val(data.input_nilai);
            $('#temp_open').val(data.temp_open);
            $('#finish').val(data.finish);
        })
    });

    /* UNTUK TOGGLE STATUS */
    function PeriodeStatus(id,is_active){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('change-period-status') }}",
            id: $('.period-status'+id+'').val(),
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
                        url: "periode/" + dataId,
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
                        $('#table_periode').DataTable().ajax.reload(null, true);
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