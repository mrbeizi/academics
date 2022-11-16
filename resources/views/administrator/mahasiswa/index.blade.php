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
                                <th>Nama Mahasiswa</th>
                                <th>No HP</th>
                                <th>Prodi</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                        </table>
                    </div>                    
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
                                                <label for="nama_data" class="form-label">Nama Data</label>
                                                <input type="text" class="form-control" id="nama_data" name="nama_data" value="" placeholder="" />
                                                <span class="text-danger" id="namaDataErrorMsg"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="isi_data" class="form-label">Isi Data</label>
                                                <input type="text" class="form-control" id="isi_data" name="isi_data" value="" placeholder="" />
                                                <span class="text-danger" id="isiDataErrorMsg"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="no_hp" class="form-label">No HP</label>
                                                <input type="text" class="form-control" id="no_hp" name="no_hp" value="" placeholder="" />
                                                <span class="text-danger" id="noHPErrorMsg"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="nama_prodi" class="form-label">Nama Prodi</label>
                                                <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" value="" placeholder="" />
                                                <span class="text-danger" id="namaProdiErrorMsg"></span>
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

    // DATATABLE
    $(document).ready(function () {
        var table = $('#table_mahasiswa').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            ajax: "{{route('mahasiswa.index')}}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: "kode_registrasi",name: "kode_registrasi",
                    render: function ( data, type, row ) {
                        return row[0]['kode_registrasi'];
                    },
                },
                {data: "isi_data",name: "isi_data",
                    render: function ( data, type, row ) {
                        return row[0]['isi_data'];
                    },
                },
                {data: "no_hp",name: "no_hp",
                    render: function ( data, type, row ) {
                        return row[0]['no_hp'];
                    },
                },
                {data: "nama_prodi",name: "nama_prodi",
                    render: function ( data, type, row ) {
                        return row[0]['nama_prodi'];
                    },
                },
                {data: 'action',name: 'action'},
            ]
        });
    });

    // TOMBOL VIEW
    $(document).on('click', '.view_detail', function () {
        dataId = $(this).attr('id');
        $.ajax({
			url: "{{route('view-detail-mahasiswa')}}",
			method: "GET",
			data: {dataId: dataId},
			success: function(response, data){
                $('#view_detail').modal('show');
                $("#table").html(response.table)
			}
		})
    });

    // EDIT DATA
    $('body').on('click', '.edit-post', function () {
        var data_id = $(this).data('id');
        alert(data_id);
        $.get('mahasiswa/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#nama_data').val(data.nama_data);
            $('#isi_data').val(data.isi_data);
            $('#no_hp').val(data.no_hp);
            $('#nama_prodi').val(data.nama_prodi);
        })
    });

</script>

@endsection