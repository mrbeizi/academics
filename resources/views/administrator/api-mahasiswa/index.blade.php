@extends('layouts.backend')
@section('title','Mahasiswa API')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('api-mahasiswa.index')}}">@yield('title')</a>
      </li>
      <li class="breadcrumb-item active">Data</li>
    </ol>
</nav>
</div>
@endsection

@section('content')

<div class="container flex-grow-1">
    <section id="basic-datatable">
        <div class="row mb-3">
            <div class="dropdown show">
                <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bx bx-xs bx-search-alt bx-tada-hover"></i>
                  Cari berdasarkan
                </a>
              
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="{{route('calon-mahasiswa.index')}}"><i class="bx bx-xs bx-right-arrow-circle bx-tada-hover"></i> Tahun Ajaran</a>
                  <a class="dropdown-item" href="{{route('api-mahasiswa-prodi.index')}}"><i class="bx bx-xs bx-right-arrow-circle bx-tada-hover"></i> Prodi</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-responsive" id="table_api_mahasiswa">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Reg</th>
                                <th>Name</th>
                                <th>No SPMB</th>
                                <th>Prodi</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    
                    <!-- MULAI MODAL VIEW DETAIL-->
                    <div class="modal fade" tabindex="-1" role="dialog" id="view_detail" data-backdrop="false">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        var table = $('#table_api_mahasiswa').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: "{{ route('api-mahasiswa.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'kode_registrasi',name: 'kode_registrasi',
                    render: function ( data, type, row ) {
                        return row[0]['kode_registrasi'];
                    }
                },
                {data: 'nama_lengkap',name: 'nama_lengkap',
                    render: function ( data, type, row ) {
                        return row[0]['nama_lengkap'];
                    }
                },
                {data: 'no_spmb',name: 'no_spmb',
                    render: function ( data, type, row ) {
                        return row[0]['no_spmb'];
                    }
                },
                {data: 'prodi_fix',name: 'prodi_fix',
                    render: function ( data, type, row ) {
                        return row[0]['prodi_fix'];
                    }
                },
                {data: 'action',name: 'action'},
            ]
        });
    });

     // TOMBOL VIEW
     $(document).on('click', '.view_detail', function () {
        dataId = $(this).attr('id');
        $.ajax({
			url: "{{route('view-detail-form')}}",
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