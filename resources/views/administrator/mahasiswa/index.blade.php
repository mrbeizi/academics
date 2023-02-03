@extends('layouts.backend')
@section('title','Mahasiswa')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('mahasiswa.index')}}">@yield('title')</a>
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
                        <table class="table table-hover table-responsive" id="table_mahasiswa">
                            <tfoot style="display: table-header-group;">
                                <tr>
                                    <th width="10%;">#</th>
                                    <th>No Form</th>
                                    <th>NIM</th>
                                    <th>Name</th>
                                    <th>Faculty</th>
                                    <th>Gender</th>
                                    <th>Religion</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No Form</th>
                                <th>NIM</th>
                                <th>Name</th>
                                <th>Faculty</th>
                                <th>Gender</th>
                                <th>Religion</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>

                    <!-- SHOW ARCHIVED MODAL-->
                    <div class="modal fade" tabindex="-1" role="dialog" id="show-archived-modal" data-backdrop="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Archived Datas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover table-responsive" id="table_show_archived" width="100%">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Faculty</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                          </tr>
                                        </thead>
                                      </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR SHOW ARCHIVED MODAL-->
                    
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
        var table = $('#table_mahasiswa').DataTable({
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
            ajax: "{{ route('mahasiswa.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'no_form',name: 'no_form'},
                {data: 'nim',name: 'nim'},
                {data: 'nama_mahasiswa',name: 'nama_mahasiswa'},
                {data: 'nama_prodi',name: 'nama_prodi'},
                {data: 'jenis_kelamin',name: 'jenis_kelamin',
                    render:function(data,type,row){
                        return (row.jenis_kelamin == 1) ? 'Laki-laki' : 'Perempuan';
                    }
                },
                {data: 'agama',name: 'agama'},
                {data: 'action',name: 'action'},
            ]
        });
    });

    $('#table_mahasiswa tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Cari ' + title + '" />');
    });

</script>

@endsection