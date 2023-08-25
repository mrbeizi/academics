@extends('layouts.backend')
@section('title','Buka Kelas (Satu)')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('buka-kelas.index')}}">@yield('title')</a>
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
                        <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-12">

                                    <input type="hidden" name="id" id="id">

                                    <div class="row justify-content-center">
                                        <div class="col-sm-4">
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
                                                <label for="id_status_kelas" class="form-label">Status Kelas*</label>
                                                <select class="form-select" id="id_status_kelas" name="id_status_kelas" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="">- Choose -</option>
                                                    @foreach($getStatusKelas as $status)
                                                    <option value="{{$status->id}}">{{$status->nama_status}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="idStatusKelasErrorMsg"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_prodi" class="form-label">Prodi*</label>
                                                <select class="form-select" id="id_prodi" name="id_prodi" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="">- Choose -</option>
                                                    @foreach($getProdi as $prodi)
                                                    <option value="{{$prodi->id}}">{{$prodi->nama_id}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="idProdiErrorMsg"></span>
                                            </div>
                                                                                        
                                        </div>
                                        <div class="col-sm-4">                                            
                                            <div class="mb-3">
                                                <label for="id_matakuliah" class="form-label">Matakuliah*</label>
                                                <select class="form-select" id="id_matakuliah" name="id_matakuliah" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="">- Choose -</option>
                                                    @foreach($getMatakuliah as $matakuliah)
                                                    @php $totalSKS = $matakuliah->sks_teori + $matakuliah->sks_praktek; @endphp
                                                    <option value="{{$matakuliah->id}}">{{$matakuliah->kode}} > {{$matakuliah->nama_id}} > {{$totalSKS}} SKS</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="idMatakuliahErrorMsg"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="semester" class="form-label">Semester*</label>
                                                <input type="text" class="form-control" id="semester" name="semester" value="" placeholder="Input Semester" />
                                                <span class="text-danger" id="semesterErrorMsg"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="col-sm-offset-2 col-sm-12">
                                                <hr class="mt-2">
                                                <div class="float-sm-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="create">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>

                        </form>
                    </div>
                    
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

    // TOMBOL TAMBAH
    if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                $('#tombol-simpan').html('Saving..');

                $.ajax({
                    data: $('#form-tambah-edit').serialize(), 
                    url: "{{ route('buka-kelas.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_buka_kelas').DataTable().ajax.reload(null, true);
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
                        $('#idStatusKelasErrorMsg').text(response.responseJSON.errors.id_status_kelas);
                        $('#idProdiErrorMsg').text(response.responseJSON.errors.id_prodi);
                        $('#idMatakuliahErrorMsg').text(response.responseJSON.errors.id_matakuliah);
                        $('#semesterErrorMsg').text(response.responseJSON.errors.semester);
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
        $.get('buka-kelas/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#id_periode').val(data.id_periode);
            $('#id_prodi').val(data.id_prodi);
            $('#id_status_kelas').val(data.id_status_kelas);
            $('#id_matakuliah').val(data.id_matakuliah);
            $('#semester').val(data.semester);
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
                        url: "buka-kelas/" + dataId,
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
                        $('#table_buka_kelas').DataTable().ajax.reload(null, true);
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