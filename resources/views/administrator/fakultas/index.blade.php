@extends('layouts.backend')
@section('title','Dashboard')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <section id="basic-datatable">
      <div class="row">
      <div class="col-12">
          <div class="card">
          <div class="card-body card-dashboard">
              <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table table-bordered" id="table_fakultas">
                  <thead>
                  <tr>
                      <th>#</th>
                      <th>ID Periode</th>
                      <th>Nama Fakultas</th>
                      <th>Arsip</th>
                      <th>Aksi</th>
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
    $(function () {
        $.noConflict();
        var table = $('#table_fakultas').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('fakultas.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'id_periode',name: 'id_periode'},
                {data: 'nama_id',name: 'nama_id'},
                {data: 'is_archived',name: 'is_archived'},
                {data: 'action',name: 'action'},
            ]
        });
    });

    
  </script>
@endsection