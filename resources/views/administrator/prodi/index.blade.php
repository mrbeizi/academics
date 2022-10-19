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
                                                    <label for="nama_in" class="form-label">Name (ID)</label>
                                                    <input type="text" class="form-control" id="nama_in" name="nama_in" value="" placeholder="John Doe" />
                                                    <span class="text-danger" id="namaINErrorMsg"></span>
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

                    <!-- MULAI MODAL KONFIRMASI DELETE-->
                    <div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi-modal" data-backdrop="false">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: red";>WARNING!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>If you remove this data, it would be permanently gone and can't be restored, are you sure to remove?</p>
                                </div>
                                <div class="modal-footer bg-whitesmoke br">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" name="tombol-hapus" id="tombol-hapus">Yes, remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR MODAL KONFIRMASI DELETE-->
                    
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
                {data: 'nama_in',name: 'nama_in'},
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
                        iziToast.success({
                            title: 'Data saved succesfully',
                            message: '{{ Session(' success ')}}',
                            position: 'bottomRight'
                        });
                    },
                    error: function(response) {
                        $('#tahunIDErrorMsg').text(response.responseJSON.errors.tahun);
                        $('#tombol-simpan').html('Save');
                        iziToast.error({
                            title: 'Data failed to save',
                            message: '{{ Session('error')}}',
                            position: 'bottomRight'
                        });
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
            $('#nama_in').val(data.nama_in);
            $('#nama_en').val(data.nama_en);
            $('#nama_ch').val(data.nama_ch);
        })
    });

    // TOMBOL DELETE
    $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        $('#konfirmasi-modal').modal('show');
    });

    $('#tombol-hapus').click(function () {
        $.ajax({

            url: "prodi/" + dataId,
            type: 'delete',
            beforeSend: function () {
                $('#tombol-hapus').text('Remove Data');
            },
            success: function (data) {
                setTimeout(function () {
                    $('#konfirmasi-modal').modal('hide');
                    var oTable = $('#table_prodi').dataTable();
                    oTable.fnDraw(false);
                });
                iziToast.warning({
                    title: 'Removed Successfully!',
                    message: '{{ Session(' delete ')}}',
                    position: 'bottomRight'
                });
            },
            error: function(response) {
                iziToast.error({
                    title: 'Oops! Data failed to removed!',
                    message: '{{ Session('error')}}',
                    position: 'bottomRight'
                });
            }
        })
    });

</script>

@endsection