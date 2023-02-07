@extends('layouts.backend')
@section('title','Count Fine')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('hitung-denda.index')}}">@yield('title')</a>
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
                        <form id="form-count" name="form-count" class="form-horizontal">
                            <div class="d-flex p-3">
                                <div class="col-sm-3">
                                    <div class="col-sm-8">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Start Date*</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" value="" placeholder="mm/dd/yyyy" required />
                                            <span class="text-danger" id="startDateErrorMsg"></span>
                                        </div>
                                    </div>                                
                                </div>
                                <div class="col-sm-3">
                                    <div class="col-sm-8">
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">End Date*</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" value="" placeholder="mm/dd/yyyy" required />
                                            <span class="text-danger" id="endDateErrorMsg"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">                                
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="btn" class="form-label"></label>
                                            <button type="submit" class="form-control btn btn-primary btn-block tombol-count" id="tombol-count" name="submit">Count</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-8 p-3" id="count-page"></div>                            
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

    if ($("#form-count").length > 0) {
        $("#form-count").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-count').val();
                start_date = document.getElementById("start_date").value;
                end_date = document.getElementById("end_date").value;
                $('#tombol-count').html('Count..');
                $.ajax({
                    url: '{{ route("count-fine") }}',
                    data: {start_date:start_date,end_date:end_date},
                    type: "GET",
                    dataType: 'json',
                    success: function(response, data){
                        $("#count-page").html(response.content);
                        $('#tombol-count').html('Count');
                    },
                    error: function(response) {
                        $('#tombol-count').html('Count');
                    }
                });
            }
        })
    }
    
  </script>
@endsection