@extends('layouts.backend')
@section('title','Biaya Kuliah')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('biaya-kuliah.index')}}">@yield('title')</a>
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
                    <!-- MULAI TOMBOL TAMBAH -->
                    <div class="mb-3">
                        <button class="btn btn-success me-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="bx bx-xs bx-plus-circle bx-tada-hover"></i> Manual Insert</button>
                        <button type="button" id="count-fine" data-bs-toggle="collapse" data-bs-target="#collapseImportData" aria-expanded="false" aria-controls="collapseImportData" class="btn btn-primary me-1"><i class="bx bx-xs bx-import bx-tada-hover"></i> Import Data</button>
                        <div class="form-text">*Import data first</div>
                    </div>

                    <div class="accordion-group">
                        <div class="collapse indent mb-3" id="collapseExample" data-bs-parent="#myGroup">
                            <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                <div class="border p-3 rounded">
                                    <input type="hidden" name="id" id="id">    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-inline">
                                                        <label class="control-label" for="nim">Student Name or Department</label>
                                                        <select class="form-select" id="nim" name="nim" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            @foreach($getMahasiswa as $mahasiswa)
                                                                <option value="{{$mahasiswa->nim}}">{{$mahasiswa->nama_mahasiswa}} - {{$mahasiswa->nama_prodi}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="nimErrorMsg"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-inline">
                                                        <label class="control-label" for="id_periode">Time or Period</label>
                                                        <select class="form-select" id="id_periode" name="id_periode" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            @foreach($getPeriode as $period)
                                                                <option value="{{$period->id}}">{{$period->kode}} - {{$period->nama_periode}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="idPeriodeErrorMsg"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-inline">
                                                        <label class="control-label" for="biaya">Amount</label>
                                                        <select class="form-select" id="biaya" name="biaya" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            @php $biayakuliah = 0; @endphp 
                                                            @foreach($getPaymentList as $data)
                                                            {{-- Count total if have discounts --}}
                                                                @if($data->is_percentage == 1)
                                                                    {{ $biayakuliah = $data->nilai - ($data->discount * $data->nilai/100) }}
                                                                @else
                                                                    {{ $biayakuliah = $data->nilai - $data->discount }}
                                                                @endif
                                                            {{-- To show cost of each faculty, including university --}}
                                                                @if($data->id_lingkup_biaya != 0)
                                                                    <option value="{{$biayakuliah}}">{{$data->nama_id}} > {{$data->nama_biaya}} > Rp{{number_format($biayakuliah,0,',','.')}}</option>
                                                                @else
                                                                    <option value="{{$biayakuliah}}">Universitas > {{$data->nama_biaya}} > Rp{{number_format($biayakuliah,0,',','.')}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <div class="form-text">*Cost after discount</div>
                                                        <span class="text-danger" id="biayaErrorMsg"></span>
                                                    </div>
                                                </div>                              
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <label for="btn" class="form-label"></label>
                                                        <button type="submit" class="form-control btn btn-success btn-block tombol-simpan" id="tombol-simpan" name="submit">Save</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
    
                            </form>
                        </div>

                        <div class="collapse indent mb-3" id="collapseImportData" data-bs-parent="#myGroup">
                            <form id="form-import-data" name="form-import-data" class="form-horizontal">
                                <div class="border p-3 rounded">
                                    <input type="hidden" name="id" id="id">    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row justify-content-center">
                                                
                                                <div class="col-sm-3">
                                                    <div class="form-inline">
                                                        <label class="form-label" for="datepicker">Year Level</label>
                                                        <select class="form-select" id="year_level" name="year_level" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            @for($i=date('Y');$i>=date('Y')-5;$i-=1)
                                                            <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                        <span class="text-danger" id="yearLevelErrorMsg"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-inline">
                                                        <label class="form-label" for="custom_name">Time or Period</label>
                                                        <select class="form-select" id="custom_name" name="custom_name" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="">- Choose -</option>
                                                            @foreach($getPeriode as $period)
                                                                <option value="{{$period->id}}">{{$period->kode}} - {{$period->nama_periode}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="customNameErrorMsg"></span>
                                                    </div>
                                                </div>
                                                                             
                                                <div class="col-sm-3">
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
                        </div>
                    </div>
                </div>
                
                <!-- AKHIR TOMBOL -->
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-responsive" id="table_biaya_kuliah">
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
        var table = $('#table_biaya_kuliah').DataTable({
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
            searching: false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('biaya-kuliah.index') }}",
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

    // TOMBOL TAMBAH
    if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                $('#tombol-simpan').html('Saving..');

                $.ajax({
                    data: $('#form-tambah-edit').serialize(), 
                    url: "{{ route('biaya-kuliah.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tombol-simpan').html('Save');
                        $('#table_biaya_kuliah').DataTable().ajax.reload(null, true);
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
                        $('#nimErrorMsg').text(response.responseJSON.errors.nim);
                        $('#idPeriodeErrorMsg').text(response.responseJSON.errors.id_periode);
                        $('#biayaErrorMsg').text(response.responseJSON.errors.biaya);
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

    var $myGroup = $('#myGroup');
        $myGroup.on('show.bs.collapse','.collapse', function() {
            $myGroup.find('.collapse.in').collapse('hide');
    });

    // TOMBOL IMPORT
    if ($("#form-import-data").length > 0) {
        $("#form-import-data").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-import').val();
                $('#tombol-import').html('Importing..');

                $.ajax({
                    data: $('#form-import-data').serialize(), 
                    url: "{{ route('import-biaya-kuliah') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-import-data').trigger("reset");
                        $('#tombol-import').html('Import');
                        $('#table_biaya_kuliah').DataTable().ajax.reload(null, true);
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
                        url: "biaya-kuliah/" + dataId,
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
                        $('#table_biaya_kuliah').DataTable().ajax.reload(null, true);
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