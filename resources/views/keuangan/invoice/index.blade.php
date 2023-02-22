@extends('layouts.backend')
@section('title','Invoice')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('invoice.index')}}">@yield('title')</a>
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
                <!-- Form Invoice -->
                <form id="form-import-data" name="form-import-data" class="form-horizontal mb-3">
                    <div class="border p-3 rounded">
                        <input type="hidden" name="id" id="id">    
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row justify-content-center">
                                    
                                    <div class="col-sm-2">
                                        <div class="form-inline">
                                            <label class="form-label" for="datepicker">Year Level*</label>
                                            <select class="form-select" id="year_level" name="year_level" aria-label="Default select example" style="cursor:pointer;">
                                                <option value="">- Choose -</option>
                                                @for($i=date('Y');$i>=date('Y')-5;$i-=1)
                                                <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                            <div class="form-text text-danger" id="yearLevelErrorMsg"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-inline">
                                            <label class="form-label" for="custom_name">Period*</label>
                                            <select class="form-select" id="custom_name" name="custom_name" aria-label="Default select example" style="cursor:pointer;">
                                                <option value="">- Choose -</option>
                                                @foreach($getPeriode as $period)
                                                    <option value="{{$period->id}}">{{$period->kode}} - {{$period->nama_periode}}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-text text-danger" id="customNameErrorMsg"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-inline">
                                            <label for="semester" class="form-label">Semester*</label>
                                            <input type="text" class="form-control" id="semester" name="semester" value="" placeholder="eg: Semester 2" />
                                            <div class="form-text text-danger" id="semesterErrorMsg"></div>
                                        </div>
                                    </div>
                                                                 
                                    <div class="col-sm-2">
                                        <div class="mb-3">
                                            <label for="btn" class="form-label"></label>
                                            <button type="submit" class="form-control btn btn-primary btn-block tombol-import" id="tombol-import" name="submit"><i class="bx bx-xs bx-import bx-tada-hover"></i> Import</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>                                        
                        </div>
                    </div>

                </form>
                <!-- End of Form Invoice -->

                <div class="card">
                    <div class="card-body">
                            <table class="table table-hover table-responsive" id="table_invoice">
                              <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Student Name</th>
                                    <th>Period</th>
                                    <th>Major</th>
                                    <th>Amount</th>
                                    <th>Action</th>
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
        var table = $('#table_invoice').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('invoice.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'nim',name: 'nim'},
                {data: 'nama_mahasiswa',name: 'nama_mahasiswa'},
                {data: 'nama_periode',name: 'nama_periode',render: function(type,data,row)
                    { 
                        return row.kode+' - '+row.nama_periode;
                    }
                },
                {data: 'nama_id',name: 'nama_id'},
                {data: 'biaya',name: 'biaya',render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')},
                {data: 'action',name: 'action'},
            ]
        });
    });

    // TOMBOL IMPORT
    if ($("#form-import-data").length > 0) {
        $("#form-import-data").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-import').val();
                $('#tombol-import').html('Importing..');

                $.ajax({
                    data: $('#form-import-data').serialize(), 
                    url: "{{ route('import-invoice') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-import-data').trigger("reset");
                        $('#tombol-import').html('Import');
                        $('#table_invoice').DataTable().ajax.reload(null, true);
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
                        switch (data.check) {
                            case "not_available":
                                Swal.fire({
                                title: 'Failed!',
                                text: 'No data imported to the table!',
                                type: 'error',
                                customClass: {
                                confirmButton: 'btn btn-danger'
                                },
                                buttonsStyling: false,
                                timer: 2000
                            })
                                break;
                            case "not_exist":
                                Swal.fire({
                                title: 'Failed!',
                                text: 'Data is already exist in table!',
                                type: 'error',
                                customClass: {
                                confirmButton: 'btn btn-danger'
                                },
                                buttonsStyling: false,
                                timer: 2000
                            })
                                break;
                        }
                    },
                    error: function(response) {
                        $('#yearLevelErrorMsg').text(response.responseJSON.errors.year_level);
                        $('#customNameErrorMsg').text(response.responseJSON.errors.custom_name);
                        $('#semesterErrorMsg').text(response.responseJSON.errors.semester);
                        $('#tombol-import').html('Import');
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
                        url: "invoice/" + dataId,
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
                        $('#table_invoice').DataTable().ajax.reload(null, true);
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