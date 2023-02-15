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
                <!-- MULAI TOMBOL TAMBAH -->
                <div class="mb-3">
                    <button class="btn btn-success me-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="bx bx-xs bx-plus-circle bx-tada-hover"></i> Add Data </button>
                    <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="import-Payment"><button type="button" class="btn btn-primary mr-5"><i class="bx bx-xs bx-import bx-tada-hover"></i> Import</button></a>
                </div>

                <div class="collapse indent mb-3" id="collapseExample">
                    <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                        <div class="border p-3 rounded">
                            <input type="hidden" name="id" id="id">    
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-inline">
                                                <label class="control-label" for="nim">NIM or Registration Number</label>
                                                <select class="form-select" id="nim" name="nim" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="">- Choose -</option>
                                                    @foreach($getMahasiswa as $mahasiswa)
                                                        <option value="{{$mahasiswa->nim}}">{{$mahasiswa->nama_prodi}} - {{$mahasiswa->nama_mahasiswa}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="nimErrorMsg"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-inline">
                                                <label class="control-label" for="id_periode">Period</label>
                                                <select class="form-select" id="id_periode" name="id_periode" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="">- Choose -</option>
                                                    @foreach($getPeriode as $period)
                                                        <option value="{{$period->id}}">{{$period->nama_periode}}</option>
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
                                                    @foreach($getPaymentList as $data)
                                                        @if($data->id_lingkup_biaya != 0)
                                                            <option value="{{$data->nilai}}">{{$data->nama_id}} > {{$data->nama_biaya}} > Rp{{number_format($data->nilai,0,',','.')}}</option>
                                                        @else
                                                            <option value="{{$data->nilai}}">Universitas > {{$data->nama_biaya}} > Rp{{number_format($data->nilai,0,',','.')}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
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
                        $('#tambah-edit-modal').modal('hide');
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
    
  </script>
@endsection