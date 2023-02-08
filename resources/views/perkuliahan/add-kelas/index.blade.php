@extends('layouts.backend')
@section('title','Add Kelas')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('in-kelas.index')}}">@yield('title')</a>
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
                            <a href="{{route('gol-kelas.index')}}" class="btn btn-secondary me-1" role="button" aria-pressed="true"><i class="bx bx-xs bx-left-arrow-circle bx-tada-hover"></i> Back</a>
                            <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" data-bs-target="#addStudent" aria-expanded="false" aria-controls="addStudent"><i class="bx bx-xs bx-user-plus bx-tada-hover"></i> Student</button>
                        </div>
                        <div class="collapse indent mb-3" id="addStudent">
                            <form id="form-count" name="form-count" class="form-horizontal">
                                
                                <div class="p-3 border">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="card bg-warning text-white text-center p-3">
                                                @foreach($getInfo as $info)
                                                <figure class="mb-0">
                                                    <blockquote class="blockquote">
                                                    <p>Nama Golongan {{$info->nama_golongan}}.</p>
                                                </blockquote>
                                                <figcaption class="blockquote-footer mb-0 text-white">                                                    
                                                    Periode <cite title="{{$info->nama_periode}}">{{$info->nama_periode}}</cite>
                                                </figcaption>
                                                </figure>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-6">                
                                                    <div class="form-group">
                                                        <label><b>Year Level</b></label>
                                                        <select class="select2 filter form-control mt-2" name="angkatan" id="filter-angkatan" required>
                                                            <option value="" readonly>- Choose -</option>
                                                            <option value="2023">2023</option>
                                                            <span class="angkatanErrorMsg"></span>
                                                        </select>
                                                    </div>
                                                </div>
                
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><b>Prodi</b></label>
                                                        <select class="form-select mt-2" id="id_prodi" name="id_prodi" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="" readonly>- Choose -</option>
                                                            @foreach($getProdi as $prodi)
                                                            <option value="{{$prodi->id}}">{{$prodi->nama_id}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="idProdiErrorMsg"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label><b>Period</b></label>
                                                <select class="form-select mt-2" id="id_periode" name="id_periode" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="" readonly>- Choose -</option>
                                                    @foreach($getPeriode as $data)
                                                    <option value="{{$data->id}}">{{$data->nama_periode}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="idPeriodeErrorMsg"></span>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label><b>Copy</b></label>
                                                <select class="form-select mt-2" id="copy" name="copy" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="" readonly>- Choose -</option>
                                                    @foreach($getGolKelas as $data)
                                                    <option value="{{$data->id}}">{{$data->nama_golongan}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="idPeriodeErrorMsg"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mb-3 mt-2">
                                            <label for="btn" class="form-label"></label>
                                            <button type="submit" class="form-control btn btn-primary btn-block tombol-select" id="tombol-select" name="submit" disabled onclick="saveSelected()">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- AKHIR TOMBOL -->
                        <table class="table table-hover table-responsive" id="table_gol_mahasiswa">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
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
                                                    <label for="nama_golongan" class="form-label">Nama Golongan*</label>
                                                    <input type="text" class="form-control" id="nama_golongan" name="nama_golongan" value="" placeholder="John Doe" />
                                                    <span class="text-danger" id="namaGolErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                                    <span class="text-danger" id="keteranganErrorMsg"></span>
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
        var table = $('#table_gol_mahasiswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('list.mahasiswa',['id' => $id]) }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nim',name: 'nim'},
                {data: 'nama_mahasiswa',name: 'nama_mahasiswa'},
                {data: 'nama_status',name: 'nama_status'},
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
                    url: "{{ route('in-kelas.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_gol_mahasiswa').DataTable().ajax.reload(null, true);
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
                        $('#namaGolErrorMsg').text(response.responseJSON.errors.nama_golongan);
                        $('#keteranganErrorMsg').text(response.responseJSON.errors.keterangan);
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
        $.get('in-kelas/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#nama_golongan').val(data.nama_golongan);
            $('#keterangan').val(data.keterangan);
            $('#id_periode').val(data.id_periode);
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
                        url: '{{route("del.mahasiswa", ":id_mahasiswa")}}'.replace(":id_mahasiswa", dataId),
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
                        $('#table_gol_mahasiswa').DataTable().ajax.reload(null, true);
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

    function onlyNumeric(event) {
        var angka = (event.which) ? event.which : event.keyCode
        if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
        return true;
    }

</script>

@endsection