@extends('layouts.backend')
@section('title','Fakultas')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('fakultas.index')}}">@yield('title')</a>
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
                            <table class="table table-hover table-responsive" id="table_fakultas">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Period ID</th>
                                  <th>Name</th>
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
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                        <div class="row">
                                            <div class="col-sm-12">

                                                <input type="hidden" name="id" id="id">

                                                <div class="mb-3">
                                                    <label for="id_periode" class="form-label">Year Period</label>
                                                    <select class="form-select" id="id_periode" name="id_periode" aria-label="Default select example">
                                                      <option selected>- Choose -</option>
                                                      <option value="1">2022</option>
                                                      <option value="2">2023</option>
                                                      <option value="3">2024</option>
                                                    </select>
                                                    <span class="text-danger" id="idPeriodeErrorMsg"></span>
                                                </div>

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

                                            <div class="col-sm-offset-2 col-sm-12">
                                                <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="create">Save</button>
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
        var table = $('#table_fakultas').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('fakultas.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'id_periode',name: 'id_periode'},
                {data: 'nama_id',name: 'nama_id'},
                {data: 'is_archived',name: 'is_archived'},
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
                    url: "{{ route('fakultas.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        var oTable = $('#table_fakultas').dataTable();
                        oTable.fnDraw(false);
                        iziToast.success({
                            title: 'Data saved succesfully',
                            message: '{{ Session(' success ')}}',
                            position: 'bottomRight'
                        });
                    },
                    error: function(response) {
                        $('#idPeriodeErrorMsg').text(response.responseJSON.errors.id_periode);
                        $('#namaIDErrorMsg').text(response.responseJSON.errors.nama_id);
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

    
  </script>
@endsection