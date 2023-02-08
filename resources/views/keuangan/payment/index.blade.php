@extends('layouts.backend')
@section('title','Payment')

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
                <div class="mb-2" id="myGroup">
                    <p class="demo-inline-spacing">
                        <button class="btn btn-success me-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="bx bx-xs bx-printer bx-tada-hover"></i> Print </button>
                        <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="import-Payment"><button type="button" class="btn btn-primary mr-5"><i class="bx bx-xs bx-import bx-tada-hover"></i> Import</button></a>
                        <button type="button" id="count-fine" data-bs-toggle="collapse" data-bs-target="#collapseCountFine" aria-expanded="false" aria-controls="collapseCountFine" class="btn btn-info me-1 float-end"><i class="bx bx-xs bx-dollar-circle bx-tada-hover"></i> Count Fine</button>
                    </p>
                    <div class="accordion-group">
                        <div class="collapse indent" id="collapseExample" data-bs-parent="#myGroup">
                            <form action="{{route('print-payment')}}" method="GET" target="_blank">
                                @csrf
                                <div class="d-flex p-3 border justify-content-center">
                                    <div class="col-sm-3">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="datepicker" class="form-label">Year Level*</label>
                                                <input  type="text" class="form-control date" id="datepicker" data-date="2012" data-date-format="yyyy" name="tanggal_masuk" required />     
                                            </div>
                                            <span class="text-danger" id="angkatanErrorMsg"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="start_date" class="form-label">Start Date*</label>
                                                <input type="date" class="form-control" id="start_date" name="start_date" value="" placeholder="mm/dd/yyyy" required />
                                                <span class="text-danger" id="startDateErrorMsg"></span>
                                            </div>
                                        </div>                                
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="end_date" class="form-label">End Date*</label>
                                                <input type="date" class="form-control" id="end_date" name="end_date" value="" placeholder="mm/dd/yyyy" required />
                                                <span class="text-danger" id="endDateErrorMsg"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">                                
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label for="btn" class="form-label"></label>
                                                <button type="submit" class="form-control btn btn-primary btn-block" id="tombol-cetak" value="print">Print</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="collapse indent" id="collapseCountFine" data-bs-parent="#myGroup">
                            <form id="form-count" name="form-count" class="form-horizontal">
                                <div class="d-flex p-3 border">
                                    <div class="col-sm-3">
                                        <div class="col-sm-8">
                                            <div class="mb-3">
                                                <label for="tanggal_awal" class="form-label">Start Date*</label>
                                                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="" placeholder="mm/dd/yyyy" required />
                                                <span class="text-danger" id="tanggalAwalErrorMsg"></span>
                                            </div>
                                        </div>                                
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="col-sm-8">
                                            <div class="mb-3">
                                                <label for="tanggal_akhir" class="form-label">End Date*</label>
                                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="" placeholder="mm/dd/yyyy" required />
                                                <span class="text-danger" id="tanggalAkhirErrorMsg"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">                                
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label for="btn" class="form-label"></label>
                                                <button type="submit" class="form-control btn btn-primary btn-block tombol-count" id="tombol-count" name="submit">Count</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                     

                    
                    <!-- Import Excel -->
                    <div class="modal fade" id="importPayment" aria-hidden="true">
                        <div class="modal-dialog">
                            
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">   
                                    <form id="form-import-payment" name="form-import-payment" enctype="multipart/form-data"> 
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Pilih file excel</label>
                                                <div class="form-group mt-3 mb-3">
                                                    <input id="file" type="file" name="file" data-preview-file-type="any" class="file" required data-upload-url="#">
                                                </div>
                                                <span class="text-danger" id="fileErrorMsg"></span>
                                            </div> 
                                        </div>       
                                    
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <hr class="mt-2">
                                            <div class="float-sm-end">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary btn-block" id="tombol-import" value="import">Import</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-8 mt-3 mb-3" id="count-page"></div> 
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-responsive" id="table_payment">
                            <tfoot style="display: table-header-group;">
                                <tr>
                                    <th width="8%;">#</th>
                                    <th>NIM</th>
                                    <th>Student Name</th>
                                    <th>Major</th>
                                    <th>State</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>NIM</th>
                                <th>Student Name</th>
                                <th>Major</th>
                                <th>State</th>
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
                                                    <label for="nama_pembayaran" class="form-label">Payment Name*</label>
                                                    <input type="text" class="form-control" id="nama_pembayaran" name="nama_pembayaran" value="" placeholder="eg: Uang Lab" />
                                                    <span class="text-danger" id="namaPembayaranErrorMsg"></span>
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
        var table = $('#table_payment').DataTable({
            initComplete: function () {
                // Apply the search
                this.api()
                    .columns()
                    .every(function () {
                        var that = this;
    
                        $('input', this.footer()).on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        });
                    });
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('payment.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nim',name: 'nim'},
                {data: 'nama_mahasiswa',name: 'nama_mahasiswa'},
                {data: 'nama_prodi',name: 'nama_prodi'},
                {data: 'nama_status',name: 'nama_status', 
                    render: function(type,data,row){ 
                        return (row.ism == 1) ? row.nama_status+' <div class="spinner-grow spinner-grow-sm text-success" role="nama_status">' : (row.ism == 3) ? row.nama_status+' <div class="spinner-grow spinner-grow-sm text-warning" role="nama_status">' : row.nama_status;  
                    }
                },
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
                        $('#namaPembayaranErrorMsg').text(response.responseJSON.errors.nama_pembayaran);
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

    // Import Payment
    //TOMBOL TAMBAH DATA
    $('#import-Payment').click(function () {
        $('#button-import').val("import-data");
        $('#id').val('');
        $('#form-import-payment').trigger("reset");
        $('#exampleModalLabel').html("Import Payment");
        $('#importPayment').modal('show');
    });
    
    if ($("#form-import-payment").length > 0) {
        $("#form-import-payment").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-import').val();
                var formData = new FormData($("#form-import-payment")[0]);
                $('#tombol-import').html('Importing..');

                $.ajax({
                    data: formData,
                    contentType: false,
                    processData: false, 
                    url: "{{ route('import-payment') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-import-payment').trigger("reset");
                        $('#importPayment').modal('hide');
                        $('#tombol-import').html('Import');
                        $('#table_payment').DataTable().ajax.reload(null, true);
                        Swal.fire({
                            title: 'Good job!',
                            text: 'Data imported successfully!',
                            type: 'success',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                            timer: 2000
                        })
                    },
                    error: function(response) {
                        $('#fileErrorMsg').text(response.responseJSON.errors.file);
                        $('#tombol-import').html('Import');
                        Swal.fire({
                            title: 'Error!',
                            text: ' Data failed to import!',
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

    // Button Count Fine
    if ($("#form-count").length > 0) {
        $("#form-count").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-count').val();
                tanggal_awal = document.getElementById("tanggal_awal").value;
                tanggal_akhir = document.getElementById("tanggal_akhir").value;
                $('#tombol-count').html('Count..');
                $.ajax({
                    url: '{{ route("count-fine") }}',
                    data: {tanggal_awal:tanggal_awal,tanggal_akhir:tanggal_akhir},
                    type: "GET",
                    dataType: 'json',
                    success: function(response, data){
                        $("#count-page").html(response.content);
                        $('#tombol-count').html('Count');
                    },
                    error: function(response) {
                        $('#tombol-count').html('Count');
                    }
                });
            }
        })
    }

    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose: true
    });

    $('#table_payment tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Cari ' + title + '" />');
    });

    
  </script>
@endsection