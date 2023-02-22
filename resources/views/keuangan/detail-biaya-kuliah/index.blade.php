@extends('layouts.backend')
@section('title','Detail Biaya')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('detail-biaya-kuliah.index')}}">@yield('title')</a>
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
                            <a href="{{route('g-biaya-kuliah.index')}}" class="btn btn-secondary me-1" role="button" aria-pressed="true"><i class="bx bx-xs bx-left-arrow-circle bx-tada-hover"></i> Back</a>
                        </div>
                        <!-- AKHIR TOMBOL -->

                        <div class="p-3 border bg-primary text-white rounded mb-3">
                            <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                <div class="row justify-content-center">
                                    <input type="hidden" name="id" id="id">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            @foreach($getGroupName as $item)
                                            <h3 style="text-align: center;">{{$item->group_name}}</h3>
                                            <input type="hidden" name="id_group_biaya_kuliah" id="id_group_biaya_kuliah" value="{{$item->id}}">
                                            @endforeach
                                        </div> 
                                    </div>
                                    <div class="col-sm-3 mb-1">
                                        <label for="id_lingkup_biaya" class="form-label">Department*</label>
                                            <select name="id_lingkup_biaya" class="form-select" aria-label="Default select example" style="cursor:pointer;">
                                                <option value="" readonly>- Choose -</option>                                  
                                                @foreach($getProdi as $prodi)
                                                    <option value="{{$prodi->id}}">{{$prodi->nama_id}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="idSetupBiayaErrorMsg"></span>
                                    </div>
                                    <div class="col-sm-3 mb-1">
                                        <label for="nilai" class="col-sm-12 form-label">Amount (IDR)*</label>
                                        <input type="text" class="form-control" id="nilai" name="nilai" placeholder="Type Amount" value="" required>
                                        <span class="text-danger" id="nilaiErrorMsg"></span>
                                    </div>  
    
                                    <div class="col-sm-3">                                
                                        <div class="mb-3">
                                            <label for="btn" class="form-label"></label>
                                            <button type="submit" class="form-control btn btn-warning btn-block tombol-simpan" id="tombol-simpan" name="submit">Save</button>
                                        </div>
                                    </div>
    
                                </div>
                            </form>
                        </div>

                            <table class="table table-hover table-responsive" id="table_detail">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Group</th>
                                  <th>Department</th>
                                  <th>Amount</th>
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
        var table = $('#table_detail').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('list-detail',['id' => $id]) }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'nama_group',name: 'nama_group'},
                {data: 'nama_prodi',name: 'nama_prodi'},
                {data: 'nilai',name: 'nilai',render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')},
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
                    url: "{{ route('detail-biaya-kuliah.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_detail').DataTable().ajax.reload(null, true);
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
                        $('#idSetupBiayaErrorMsg').text(response.responseJSON.errors.id_setup_biaya);
                        $('#discountErrorMsg').text(response.responseJSON.errors.discount);
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
                        url: '{{route("del-detail", ":id_detail_biaya")}}'.replace(":id_detail_biaya", dataId),
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
                        $('#table_detail').DataTable().ajax.reload(null, true);
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

    // INPUT FORMAT RUPIAH OTOMATIS 
    var rupiah = document.getElementById('nilai');
    rupiah.addEventListener('keyup',function(e){
    rupiah.value = formatRupiah(this.value,'Rp. ');
    })

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

</script>

@endsection