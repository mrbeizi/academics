@extends('layouts.backend')
@section('title','Pegawai')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('pegawai.index')}}">@yield('title')</a>
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
                            <table class="table table-hover table-responsive" id="table_pegawai">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>NIP</th>
                                  <th>Name</th>
                                  <th>Gender</th>
                                  <th>Born</th>
                                  <th>Religion</th>
                                  <th>Date Reg.</th>
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
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="nama_in" class="form-label">Nama (ID)*</label>
                                                            <input type="text" class="form-control" id="nama_in" name="nama_in" value="" placeholder="e.g David" />
                                                            <span class="text-danger" id="namaINErrorMsg"></span>
                                                        </div> 
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="nama_ch" class="form-label">Nama (CH)</label>
                                                            <input type="text" class="form-control" id="nama_ch" name="nama_ch" value="" placeholder="e.g 大卫" />
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="nip" class="form-label">NIP*</label>
                                                            <input type="text" class="form-control" id="nip" name="nip" value="" placeholder="" />
                                                            <span class="text-danger" id="nipErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="jenis_kelamin" class="form-label">Gender*</label>
                                                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" aria-label="Default select example" style="cursor:pointer;">
                                                                <option value="">- Choose -</option>
                                                                <option value="1">Male</option>
                                                                <option value="0">Female</option>
                                                                <option value="2">Other</option>
                                                            </select>
                                                            <span class="text-danger" id="jenisKelaminErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                </div>     
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="tempat_lahir" class="form-label">Born Place</label>
                                                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="" placeholder="e.g Jakarta" />
                                                            <span class="text-danger" id="tampatLahirErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="tempat_lahir" class="form-label">Born Date*</label>
                                                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="" placeholder="2000/01/01" />
                                                            <span class="text-danger" id="tanggalLahirErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label for="agama" class="form-label">Religion*</label>
                                                            <select class="form-select" id="agama" name="agama" aria-label="Default select example" style="cursor:pointer;">
                                                                <option value="">- Choose -</option>
                                                                <option value="Buddha">Buddha</option>
                                                                <option value="Buddha Maitreya">Buddha Maitreya</option>
                                                                <option value="Kristen">Kristen</option>
                                                                <option value="Katholik">Katholik</option>
                                                                <option value="Islam">Islam</option>
                                                                <option value="Khonghucu">Khonghucu</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                            <span class="text-danger" id="agamaErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="id_status_pegawai" class="form-label">State*</label>
                                                            <select class="form-select" id="id_status_pegawai" name="id_status_pegawai" aria-label="Default select example" style="cursor:pointer;">
                                                                <option value="">- Choose -</option>
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                                <option value="2">Blocked</option>
                                                            </select>
                                                            <span class="text-danger" id="statusPegawaiErrorMsg"></span>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="tanggal_masuk" class="form-label">Date Registered*</label>
                                                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="" placeholder="2000/01/01" />
                                                            <span class="text-danger" id="tanggalMasukErrorMsg"></span>
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
        var table = $('#table_pegawai').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pegawai.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nip',name: 'nip'},
                {data: 'nama_in',name: 'nama_in'},
                {data: 'jenis_kelamin',name: 'jenis_kelamin',render: function(type,data,row){ return (row.jenis_kelamin == 1) ? 'Male' : 'Female'}},
                {data: 'tanggal_lahir',name: 'tanggal_lahir',
                    render: function ( data, type, row ) {
                        return row.tempat_lahir + ', ' + moment(row.tanggal_lahir).format("L");
                    }
                },
                {data: 'agama',name: 'agama'},
                {data: 'tanggal_masuk',name: 'tanggal_masuk',render: function ( data, type, row ) {return moment(row.tanggal_masuk).format("L")},},
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
                    url: "{{ route('pegawai.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_pegawai').DataTable().ajax.reload(null, true);
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
                        $('#namaINErrorMsg').text(response.responseJSON.errors.nama_in);
                        $('#nipErrorMsg').text(response.responseJSON.errors.nip);
                        $('#jenisKelaminErrorMsg').text(response.responseJSON.errors.jenis_kelamin);
                        $('#tempatLahirErrorMsg').text(response.responseJSON.errors.tempat_lahir);
                        $('#tanggalLahirErrorMsg').text(response.responseJSON.errors.tanggal_lahir);
                        $('#agamaErrorMsg').text(response.responseJSON.errors.agama);
                        $('#statusPegawaiErrorMsg').text(response.responseJSON.errors.id_status_pegawai);
                        $('#tanggalMasukErrorMsg').text(response.responseJSON.errors.tanggal_masuk);
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
        $.get('pegawai/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#nip').val(data.nip);
            $('#nama_in').val(data.nama_in);
            $('#jenis_kelamin').val(data.jenis_kelamin);
            $('#tempat_lahir').val(data.tempat_lahir);
            $('#tanggal_lahir').val(data.tanggal_lahir);
            $('#agama').val(data.agama);
            $('#id_status_pegawai').val(data.id_status_pegawai);
            $('#tanggal_masuk').val(data.tanggal_masuk);
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
                        url: "pegawai/" + dataId,
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
                        $('#table_pegawai').DataTable().ajax.reload(null, true);
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