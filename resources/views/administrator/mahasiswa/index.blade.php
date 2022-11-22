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
        <div class="row mt-3">
            <div class="col-sm-12 mb-3">
                <form class="row g-3" id="form-show" name="form-show">
                    @csrf
                    <div class="col-auto">
                        <label for="inputTahun" class="col-sm-12 col-form-label">Tahun Ajaran</label>
                    </div>
                    <div class="col-auto">
                      <select style="cursor:pointer;" class="form-control" id="tahun" name="tahun" required>
                            <option value="" readonly> - Pilih Tahun -</option>
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
                <div class="card" id="datatable-mahasiswa">
                    
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
                yearSelect = document.getElementById("tahun").value;
                $('#tombol-show').html('Processing..');
                $.ajax({
                    url: '{{ route("datatable-mahasiswa") }}',
                    data: {yearSelect:yearSelect},
                    type: "GET",
                    dataType: 'json',
                    success: function(response, data){
                        $("#datatable-mahasiswa").html(response.dataTable);
                        $('#tombol-show').html('Show datas');
                    },
                    error: function(response) {
                        console.log('Failed to get datas of '+yearSelect);
                        $('#tombol-show').html('Show datas');
                    }
                });
            }
        })
    }

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