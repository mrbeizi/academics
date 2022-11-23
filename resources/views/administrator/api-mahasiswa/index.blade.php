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
                                <th>Prodi</th>
                                <th>Gender</th>
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
                {data: 'isi_data',name: 'isi_data',
                    render: function ( data, type, row ) {
                        return row[0]['isi_data'];
                    }
                },
                {data: 'nama_prodi',name: 'nama_prodi',
                    render: function ( data, type, row ) {
                        return row[0]['nama_prodi'];
                    }
                },
                {data: 'jenis_kelamin',name: 'jenis_kelamin',
                    render: function ( data, type, row ) {
                        return row[3]['isi_data'];
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