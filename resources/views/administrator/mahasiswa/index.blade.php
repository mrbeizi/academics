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
            <div class="col-sm-12 mb-3">
                <form class="row g-3" id="form-show" name="form-show">
                    @csrf
                    <div class="col-auto">
                        <label for="inputTahun" class="col-sm-12 col-form-label">Tahun Ajaran</label>
                    </div>
                    <div class="col-auto">
                      <select style="cursor:pointer;" class="form-control" id="tahun" name="tahun" required>
                            <option value="" readonly> - Pilih Tahun -</option>
                            <option value="all">All</option>
                                @foreach($jsonTahunAjaran as $key => $data)
                                <option value="{{$data['tahun']}}">{{$data['tahun']}}</option>
                                @endforeach
                            <span class="tahunErrorMsg"></span>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" id="tombol-show" name="submit" type="submit">Show datas</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-responsive table-sm" id="table_mahasiswa">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Kode Reg</th>
                                <th>Nama Mahasiswa</th>
                                <th>Prodi</th>
                                <th>No HP</th>
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

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // SEARCH
    if ($("#form-show").length > 0) {
        $("#form-show").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-show').val();
                tahunSelect = document.getElementById("tahun").value;
                $('#tombol-show').html('Processing..');
                $.ajax({
                    url: '{{ route("get.mahasiswa") }}',
                    data: {'tahun':tahunSelect},
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {
                        $('#show-archived-modal').modal('show');
                        console.log('Success to get datas of '+tahunSelect);                        
                        $('#form-show').trigger("reset");
                        $('#tombol-show').html('Show datas');
                    },
                    error: function(response) {
                        console.log('Failed to get datas of '+tahunSelect);
                        $('#tombol-show').html('Show datas');
                    }
                });
            }
        })
    }

    // DATATABLE
    $(document).ready(function () {
        var table = $('#table_mahasiswa').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            ajax: "{{route('get.mahasiswa')}}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: "kode_registrasi",name: "kode_registrasi",
                    render: function ( data, type, row ) {
                        return row['kode_registrasi'];
                    },
                },
                {data: "isi_data",name: "isi_data",
                    render: function ( data, type, row ) {
                        return row['isi_data'];
                    },
                },
                {data: "no_hp",name: "no_hp",
                    render: function ( data, type, row ) {
                        return row['no_hp'];
                    },
                },
                {data: "nama_prodi",name: "nama_prodi",
                    render: function ( data, type, row ) {
                        return row['nama_prodi'];
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