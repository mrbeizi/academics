@extends('layouts.backend')
@section('title','Rincian Payment')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('payment.index')}}">@yield('title')</a>
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
                            <a href="{{route('payment.index')}}" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Back to Payment"><i class="bx bx-sm bx-left-arrow-circle bx-tada-hover"></i></a>
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="tombol-tambah" data-bs-toggle="tooltip" data-bs-placement="top" title="Add data"><i class="bx bx-sm bx-plus-circle"></i></a>
                        </div>
                        
                        <!-- AKHIR TOMBOL -->
                            <table class="table table-hover table-responsive" id="table_payment">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>NIM</th>
                                  <th>Student Name</th>
                                  <th>SMT</th>
                                  <th>Total Payments</th>
                                  <th>Notes</th>
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
                                                    <label for="nim_mahasiswa" class="form-label">Student Name*</label>
                                                    <select class="form-select" id="nim_mahasiswa" name="nim_mahasiswa" aria-label="Default select example" style="cursor:pointer;">
                                                        <option value="">- Choose -</option>
                                                        @foreach($getMahasiswa as $mahasiswa)
                                                        <option value="{{$mahasiswa->nim}}">{{$mahasiswa->nama_mahasiswa}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" id="nimMahasiswaErrorMsg"></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="jumlah_bayar" class="col-sm-12 control-label">Jumlah Bayar (IDR)*</label>
                                                    <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar" placeholder="Input amount (IDR)" value="" required>
                                                    <span class="text-danger" id="jumlahBayarErrorMsg"></span>
                                                </div>                                                
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="id_payment_list" class="form-label">Nama Pembayaran*</label>
                                                            <select class="form-select" id="id_payment_list" name="id_payment_list" aria-label="Default select example" style="cursor:pointer;">
                                                                <option value="">- Choose -</option>
                                                                @foreach($getPaymentList as $paymentlist)
                                                                <option value="{{$paymentlist->id}}">{{$paymentlist->nama_pembayaran}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger" id="idPaymentListErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="semester" class="form-label">Semester*</label>
                                                            <select class="form-select" id="semester" name="semester" aria-label="Default select example" style="cursor:pointer;">
                                                                <option value="">- Choose -</option>
                                                                @foreach($getSemester as $semester)
                                                                <option value="{{$semester->id}}">{{$semester->nama_semester}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger" id="semesterErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="tgl_pembayaran" class="form-label">Tanggal Pembayaran*</label>
                                                    <input type="date" class="form-control" id="tgl_pembayaran" name="tgl_pembayaran" value="" placeholder="mm/dd/yyyy" />
                                                    <span class="text-danger" id="tglPembayaranErrorMsg"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan*</label>
                                                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="" placeholder="eg: SPP Sem IV" />
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
        dataid = '{{ $id }}';
        var table = $('#table_payment').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route("list-rincian-payment", ":id")}}'.replace(":id", dataid),
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nim',name: 'nim'},
                {data: 'nama_mahasiswa',name: 'nama_mahasiswa'},
                {data: 'semester',name: 'semester'},
                {data: 'jumlah_bayar',name: 'jumlah_bayar',render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')},
                {data: 'keterangan',name: 'keterangan'},
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
                    url: "{{ route('payment.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        var oTable = $('#table_payment').dataTable();
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
                        $('#nimMahasiswaErrorMsg').text(response.responseJSON.errors.nim_mahasiswa);
                        $('#idPaymentListErrorMsg').text(response.responseJSON.errors.id_payment_list);
                        $('#jumlahBayarErrorMsg').text(response.responseJSON.errors.jumlah_bayar);
                        $('#SemesterErrorMsg').text(response.responseJSON.errors.semester);
                        $('#tglPembayaranErrorMsg').text(response.responseJSON.errors.tgl_pembayaran);
                        $('#keteranganErrorMsg').text(response.responseJSON.errors.keterangan);
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
        $.get('payment/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#nim_mahasiswa').val(data.nim_mahasiswa);
            $('#id_payment_list').val(data.id_payment_list);
            $('#jumlah_bayar').val(data.jumlah_bayar);
            $('#semester').val(data.semester);
            $('#tgl_pembayaran').val(data.tgl_pembayaran);
            $('#keterangan').val(data.keterangan);
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
                        url: "payment/" + dataId,
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
                        $('#table_payment').DataTable().ajax.reload(null, true);
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
    var rupiah = document.getElementById('jumlah_bayar');
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