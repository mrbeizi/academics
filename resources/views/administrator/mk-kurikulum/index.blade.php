@extends('layouts.backend')
@section('title','MK Kurikulum')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('mk-kurikulum.index')}}">@yield('title')</a>
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
                            <table class="table table-hover table-responsive" id="table_mk_kurikulum">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Name</th>
                                  <th>Subject ID</th>
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
                                                    <label for="id_kurikulum" class="form-label">Kurikulum</label>
                                                    <select class="form-select" id="id_kurikulum" name="id_kurikulum" aria-label="Default select example">
                                                        <option selected>- Choose -</option>
                                                        @foreach($getKurikulum as $kurikulum)
                                                        <option value="{{$kurikulum->id}}">{{$kurikulum->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" id="idKurikulumErrorMsg"></span>
                                                </div>                                                

                                                <div class="mb-3">
                                                    <label for="kode_matakuliah" class="form-label">Subjects</label>
                                                    <select class="form-select" id="kode_matakuliah" name="kode_matakuliah" aria-label="Default select example">
                                                        <option selected>- Choose -</option>
                                                        @foreach($getMatakuliah as $data)
                                                        <option value="{{$data->kode}}">{{$data->nama_id}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" id="kodeMatakuliahErrorMsg"></span>
                                                </div>
                                                                                    
                                                <hr class="mt-2">
                                            </div>
                                            
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

                    <!-- MULAI MODAL VIEW DETAIL-->
                    <div class="modal fade" tabindex="-1" role="dialog" id="view_detail" data-backdrop="false">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="table" class="col-sm-12 table-responsive"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR MODAL VIEW DETAIL-->
                    
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
        var table = $('#table_mk_kurikulum').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('mk-kurikulum.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nama',name: 'nama'},
                {data: 'kode_matakuliah',name: 'kode_matakuliah'},
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
                    url: "{{ route('mk-kurikulum.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        var oTable = $('#table_mk_kurikulum').dataTable();
                        oTable.fnDraw(false);
                        iziToast.success({
                            title: 'Data saved succesfully',
                            message: '{{ Session(' success ')}}',
                            position: 'bottomRight'
                        });
                    },
                    error: function(response) {
                        $('#idKurikulumErrorMsg').text(response.responseJSON.errors.id_kurikulum);
                        $('#kodeMatakuliahErrorMsg').text(response.responseJSON.errors.kode_matakuliah);
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
        $.get('mk-kurikulum/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#id_kurikulum').val(data.id_kurikulum);
            $('#kode_matakuliah').val(data.kode_matakuliah);
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
            iziToast.success({ 
                title: 'Status has been changed',
                message: '{{ Session('delete ')}}',
                position: 'bottomRight'
            });
        })
    }

    // TOMBOL DELETE
    $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        $('#konfirmasi-modal').modal('show');
    });

    $('#tombol-hapus').click(function () {
        $.ajax({

            url: "matakuliah/" + dataId,
            type: 'delete',
            beforeSend: function () {
                $('#tombol-hapus').text('Remove Data');
            },
            success: function (data) {
                setTimeout(function () {
                    $('#konfirmasi-modal').modal('hide');
                    var oTable = $('#table_mk_kurikulum').dataTable();
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

</script>

@endsection