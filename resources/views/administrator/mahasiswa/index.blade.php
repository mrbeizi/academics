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
                        <!-- MULAI TOMBOL TAMBAH -->
                        <div class="mb-3">
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="tombol-tambah" data-bs-toggle="tooltip" data-bs-placement="top" title="Add data"><i class="bx bx-sm bx-plus-circle bx-spin-hover"></i></a>
                        </div>                        
                        <!-- AKHIR TOMBOL -->
                        
                        <table class="table table-hover table-responsive table-sm" id="table_mahasiswa">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Kode Reg</th>
                                <th>Nama Data</th>
                                <th>Isi Data</th>
                                <th>No HP</th>
                                <th>Prodi</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                        </table>
                    </div>                    
                </div>
                <br><br>

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
                                                <label for="nama" class="form-label">Name*</label>
                                                <input type="text" class="form-control" id="nama" name="nama" value="" placeholder="e.g Kampus Merdeka" />
                                                <span class="text-danger" id="namaIDErrorMsg"></span>
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

    var myTable = $('#table_mahasiswa').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        columns: [
            {data: null,sortable:false,
                render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, 
            {data: 'kode_registrasi',name: 'kode_registrasi'},
            {data: 'nama_data',name: 'nama_data'},
            {data: 'isi_data',name: 'isi_data'},
            {data: 'no_hp',name: 'no_hp'},
            {data: 'nama_prodi',name: 'nama_prodi'},
            {data: 'action',name: 'action'},
        ]
    });

    let url = '{{route("mahasiswa.index")}}';
        fetch(url)
        .then(res => res.json())
        .then((out) => {
            var logs = out;
            myTable.clear();
            $.each(logs, function (index, value) {
            myTable.row.add(value);
            });
            myTable.draw();
        }).catch(err => {
            throw err
        });

</script>

@endsection