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
            <h3>Payment History</h3>
            <div class="col-12">
                <div class="mb-2" id="myGroup">                 
                    <!-- MULAI TOMBOL TAMBAH -->
                    <div class="mb-3">
                        <button type="button" id="search-data" data-bs-toggle="collapse" data-bs-target="#collapseSearchData" aria-expanded="false" aria-controls="collapseSearchData" class="btn btn-outline-primary me-1"><i class="bx bx-xs bx-search bx-tada-hover"></i> Search Payment</button>
                    </div>

                    <div class="accordion-group">
                        <div class="collapse indent mb-3" id="collapseSearchData" data-bs-parent="#myGroup">
                            <form id="form-search-data" name="form-search-data" class="form-horizontal">
                                <div class="border p-3 rounded">
                                    <input type="hidden" name="nim_mahasiswa" id="nim_mahasiswa" value="{{$id}}">   
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row justify-content-center">
                                                
                                                <div class="col-sm-3">
                                                    <div class="form-inline">
                                                        <label class="control-label" for="custom_name">Time or Period</label>
                                                        <select class="form-select" id="custom_name" name="custom_name" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            <option value="all">All payments</option>
                                                            @foreach($searchPeriode as $search)
                                                                <option value="{{$search->id}}">{{$search->kode}} - {{$search->nama_periode}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="customNameErrorMsg"></span>
                                                    </div>
                                                </div>
                                                                             
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <label for="btn" class="form-label"></label>
                                                        <button type="submit" class="form-control btn btn-primary btn-block tombol-search" id="tombol-search" name="submit"><i class="bx bx-xs bx-search bx-tada-hover"></i> Search</button>
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
                <div class="col-sm-12 mt-3 mb-3" id="result-page"></div>
                <div class="card">
                    <div class="card-body">
                        <!-- MULAI TOMBOL TAMBAH -->
                        <div class="mb-3">
                            <a href="{{route('payment.index')}}" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Back to Payment"><i class="bx bx-sm bx-left-arrow-circle bx-tada-hover"></i></a>
                            @if($studentState->id_status_mahasiswa <= 3)
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="tombol-tambah" data-bs-toggle="tooltip" data-bs-placement="top" title="Add data"><i class="bx bx-sm bx-plus-circle"></i></a>
                            @endif
                            <button type="button" id="print-payment-history" data-bs-toggle="tooltip" data-bs-placement="top" title="Payments History" class="btn btn-outline-danger btn-xs float-end"><i class="bx bx-xs bx-download"></i> Export PDF</button>
                        </div>
                        
                        <!-- AKHIR TOMBOL -->
                            <table class="table table-hover table-responsive" id="table_payment">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>NIM</th>
                                  <th>Student Name</th>
                                  <th>Period</th>
                                  <th>Amounts</th>
                                  <th>Disc.</th>
                                  <th>Date</th>
                                  <th>Notes</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tfoot class="bg-secondary bg-gradient">
                                <tr>
                                    <th colspan="4" style="color: black;">Grand Total</th>
                                    <th style="color: rgb(0, 0, 0); font-size: 14px;">{{currency_IDR($grandTotal)}}</th>
                                    <th colspan="4"></th>
                                </tr>
                            </tfoot>
                            {{-- @foreach($getBiaya as $r) --}}
                            <div class="d-flex justify-content-between mt-3 mb-1">
                                <span>Total Biaya Kuliah</span>
                                <span class="text-muted">{{currency_IDR($sumBiaya)}}</span>
                            </div>
                            <div class="progress mb-3">
                                
                                @if($grandTotal != 0)
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: {{ceil(100/($sumBiaya/$grandTotal))}}%;" aria-valuenow="{{$grandTotal}}" aria-valuemin="0" aria-valuemax="{{$sumBiaya}}">{{ceil(100/($sumBiaya/$grandTotal))}}%</div>
                                @else
                                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="{{$grandTotal}}" aria-valuemin="0" aria-valuemax="{{$sumBiaya}}">0%</div>
                                @endif
                            </div>
                            {{-- @endforeach --}}
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
                                            <div class="col-sm-12 mb-3">
                                                <div class="border p-3">
                                                    @foreach($getBiaya as $item)
                                                        @if($item->ism == 3)
                                                            <span class="badge bg-label-warning me-1 mb-2">STATUS {{$item->nama_status}}</span>
                                                        @else
                                                            <span class="badge bg-label-success me-1 mb-2">STATUS {{$item->nama_status}}</span>
                                                        @endif
                                                        <h3>{{currency_IDR($item->biaya)}}</h3>
                                                        <label>{{currency_IDR($item->biaya / 5)}} per month</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">

                                                <input type="hidden" name="id" id="id">
                                                <input type="hidden" name="nim_mahasiswa" id="nim_mahasiswa" value="{{$id}}">

                                                <div class="mb-3">
                                                    <label for="jumlah_bayar" class="col-sm-12 control-label">Jumlah Bayar (IDR)*</label>
                                                    <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar" placeholder="Type Amount" value="" required>
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
                                                            <label for="id_periode" class="form-label">Periode*</label>
                                                            <select class="form-select" id="id_periode" name="id_periode" aria-label="Default select example" style="cursor:pointer;">
                                                                <option value="">- Choose -</option>
                                                                @foreach($getPeriode as $periode)
                                                                <option value="{{$periode->id}}">{{$periode->kode .' > '.$periode->nama_periode}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger" id="idPeriodeErrorMsg"></span>
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

                    <!-- Modal untuk Tambah Potongan -->
                    <div class="modal fade" id="tambah-pot" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-judul-pot"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="tambah-catatan" name="tambah-catatan" method="POST" class="form-horizontal mt-3">
                                      @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <input id="id" name="id" type="hidden">
                                                        <input id="id_data_payment" name="id_data_payment" type="hidden">
                                                        <div class="mb-3">
                                                            <label for="jumlah_potongan" class="col-sm-12 control-label">Jumlah Potongan (IDR)*</label>
                                                            <input type="number" class="form-control" id="jumlah_potongan" name="jumlah_potongan" placeholder="Input amount (IDR)" value="" required>
                                                            <span class="text-danger" id="jumlahPotonganErrorMsg"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <input class="form-check-input" type="checkbox" value="1" id="percentage" name="percentage" />
                                                            <input type="hidden" value="1" id="hdnpercentage" checked="checked"/>
                                                            <span class="custom-option-header">
                                                                <span class="fw-semibold" for="percentage"> Persen*</span>
                                                            </span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keterangan" class="form-label">Keterangan*</label>
                                                            <input type="text" class="form-control" id="keterangan" name="keterangan" value="" placeholder="eg: SPP Sem IV" />
                                                            <span class="text-danger" id="keteranganErrorMsg"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
              
                                            <div class="col-sm-offset-2 col-sm-12">
                                                <hr class="mt-2">
                                                <div class="float-sm-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan-pot" value="create">Save</button>
                                                </div>
                                            </div>
                                        </div>
              
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Modal untuk Tambah Potongan -->
                    
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
                {data: 'nama_periode',name: 'nama_periode',
                    render: function(type,data,row){ 
                        return row.kode + ' - ' + row.nama_periode; 
                    }
                },
                {data: 'jumlah_bayar',name: 'jumlah_bayar',render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')},
                {data: 'jumlah_potongan',name: 'jumlah_potongan',render: function(type, row,row)
                    { 
                        return (row.is_percentage == 1) ? '-'+row.jumlah_potongan+'%' : '-'+row.jumlah_potongan+' ';
                    }
                },
                {data: 'tgl_pembayaran',name: 'tgl_pembayaran',render: function ( data, type, row ) {return moment(row.tgl_pembayaran).format("LL")},},
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
                        location.reload();
                    },
                    error: function(response) {
                        $('#nimMahasiswaErrorMsg').text(response.responseJSON.errors.nim_mahasiswa);
                        $('#idPaymentListErrorMsg').text(response.responseJSON.errors.id_payment_list);
                        $('#jumlahBayarErrorMsg').text(response.responseJSON.errors.jumlah_bayar);
                        $('#idPeriodeErrorMsg').text(response.responseJSON.errors.id_periode);
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
            $('#id_periode').val(data.id_periode);
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

    // CLIK Tambah Potongan
    $('body').on('click', '.add-potongan', function (data) {
        var data_id = $(this).data('id');
        $('#modal-judul-pot').html("Add Data");
        $('#tombol-simpan-pot').val("add-potongan");
        $('#tambah-pot').modal('show');
        $('#input').val(data_id);      
        $('#id_data_payment').val(data_id);
    });

    $('#percentage').on('change', function(){
        $('#hdnpercentage').val(this.checked ? 1 : 0);
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

    // Mengirim data tambah potongan
    if ($("#tambah-catatan").length > 0) {
        $("#tambah-catatan").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan-pot').val();
                $('#tombol-simpan-pot').html('Sending..');

                $.ajax({
                    data: $('#tambah-catatan').serialize(),
                    url: "{{ route('add-potongan') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#tambah-catatan').trigger("reset");
                        $('#tambah-pot').modal('hide');
                        $('#tombol-simpan-pot').html('Save');
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
                        $('#idDataPaymentErrorMsg').text(response.responseJSON.errors.id_data_payment);
                        $('#jumlahPotonganErrorMsg').text(response.responseJSON.errors.jumlah_potongan);
                        $('#keteranganErrorMsg').text(response.responseJSON.errors.keterangan);
                        $('#tombol-simpan-pot').html('Save');
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

    var $myGroup = $('#myGroup');
        $myGroup.on('show.bs.collapse','.collapse', function() {
            $myGroup.find('.collapse.in').collapse('hide');
    });

    // Button Search History
    if ($("#form-search-data").length > 0) {
        $("#form-search-data").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-search').val();
                $('#tombol-search').html('Searching..');

                $.ajax({
                    data: $('#form-search-data').serialize(), 
                    url: "{{ route('search-payment-history') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (response,data) {
                        $("#result-page").html(response.content);
                        $('#tombol-search').html('Search');
                    },
                    error: function(response) {
                        $('#tombol-search').html('Search');
                    }
                });
            }
        })
    }
    
  </script>
@endsection