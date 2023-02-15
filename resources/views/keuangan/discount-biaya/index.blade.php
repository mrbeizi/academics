@extends('layouts.backend')
@section('title','Discount Biaya')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('discount-biaya.index')}}">@yield('title')</a>
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
                            <a href="{{route('custom-biaya.index')}}" class="btn btn-secondary me-1" role="button" aria-pressed="true"><i class="bx bx-xs bx-left-arrow-circle bx-tada-hover"></i> Back</a>
                            <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" data-bs-target="#addDiscount" aria-expanded="false" aria-controls="addDiscount"><i class="bx bx-xs bx-plus-circle bx-tada-hover"></i> Discount</button>
                        </div>
                        <!-- AKHIR TOMBOL -->

                        <div class="collapse indent mb-3" id="addDiscount">
                            <div class="p-3 border bg-primary text-white rounded">
                                <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                    <div class="row">
                                        <input type="hidden" name="id" id="id">
                                        @foreach($getCustomName as $item)
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <h3>{{$item->nama_custom_biaya}}</h3>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        @endforeach
                                        <div class="col-sm-3 mb-1">
                                            <label for="id_setup_biaya" class="form-label">Payment Group*</label>
                                                <select name="id_setup_biaya" class="form-select" aria-label="Default select example" style="cursor:pointer;" required>
                                                    <option value="" readonly>- Choose -</option>                                  
                                                    @foreach($getPaymentList as $data)                                 
                                                    <option value="{{$data->id_biaya}}">[{{$data->kode}}] {{$data->nama_id}} > {{$data->nama_biaya}} > Rp{{number_format($data->nilai,0,',','.')}}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <label for="discount" class="form-label">Discount*</label>
                                                <input type="number" min="0" class="form-control" id="discount" name="discount" placeholder="Insert Value" value=""  required>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <label for="is_percentage" class="form-label mb-1"></label>
                                            <div class="form-group">
                                                <div class="col-sm-12 form-check form-check-warning">
                                                    <input type="checkbox" class="form-check-input" value="1" id="is_percentage" name="is_percentage"/> 
                                                    <input type="hidden" value="1" id="hdnpercentage" checked="checked"/>
                                                    <label for="percentage">Is percentage</label>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-3">                                
                                            <div class="col-sm-4">
                                                <div class="mb-3">
                                                    <label for="btn" class="form-label"></label>
                                                    <button type="submit" class="form-control btn btn-warning btn-block tombol-simpan" id="tombol-simpan" name="submit">Save</button>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                </form>
                            </div>
                        </div>

                            <table class="table table-hover table-responsive" id="table_discount_biaya">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Period</th>
                                  <th>Group</th>
                                  <th>Disc.</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</div>

<div>
    <input type="hidden" value="{{ $id }}">
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
        var table = $('#table_discount_biaya').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('list-discount',['id' => $id]) }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'nama_periode',name: 'nama_periode'},
                {data: 'nama_prodi',name: 'nama_prodi'},
                {data: 'discount',name: 'discount'},
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
                        $('#table_discount_biaya').DataTable().ajax.reload(null, true);
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
                        location.reload();
                    },
                    error: function(response) {
                        $('#idKurikulumErrorMsg').text(response.responseJSON.errors.id_kurikulum);
                        $('#kodeMatakuliahErrorMsg').text(response.responseJSON.errors.kode_matakuliah);
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
        $.get('mk-kurikulum/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#id_kurikulum').val(data.id_kurikulum);
            $('#kode_matakuliah').val(data.kode_matakuliah);
            $('#semester').val(data.semester);
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
                        url: '{{route("del.mkkurikulum", ":id_mkkurikulum")}}'.replace(":id_mkkurikulum", dataId),
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
                        $('#table_discount_biaya').DataTable().ajax.reload(null, true);
                        location.reload();
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

    $('#is_percentage').on('change', function(){
        $('#hdnpercentage').val(this.checked ? 1 : 0);
    });

</script>

@endsection