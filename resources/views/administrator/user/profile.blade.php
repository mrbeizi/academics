@extends('layouts.backend')
@section('title','Profile')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('profile')}}">@yield('title')</a>
      </li>
      <li class="breadcrumb-item active">Data</li>
    </ol>
</nav>
</div>
@endsection

@section('content')
<hr class="mt-2">
<div class="container flex-grow-1">
    <div class="row">
        <div class="col-sm-3">
            <div class="card text-center">
                <img src="{{asset('assets/img/avatars/1.png')}}" class="card-img-top rounded-circle mx-auto d-block mt-4 img-fluid img-thumbnail" alt="user-image" style="width: 10rem;">
                <div class="card-body">
                  <h5 class="card-title mb-0">{{Auth::user()->name}}</h5>
                  <p class="card-text">{{Auth::user()->email}}</p>
                </div>
              </div>
        </div>
        <div class="col-sm-9">
            <div class="nav-align-top">
                <ul class="nav nav-tabs" role="tablist" id="tabMenu">
                  <li class="nav-item">
                    <a class="nav-link active" role="tab" data-toggle="tab" href="#home" aria-selected="true">Info</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" role="tab" data-toggle="tab" href="#changePassword" aria-selected="false">Change Password</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" role="tab" data-toggle="tab" href="#messages" aria-selected="false">Messages</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <p>
                      Hallo I'm <b>{{Auth::user()->name}}</b>,
                    </p>
                    <p class="mb-0">
                      Here are my fave tootsie roll fruitcake cookie. Dessert topping pie. Jujubes wafer carrot cake jelly. Bonbon jelly-o
                      jelly-o ice
                      cream jelly beans candy canes cake bonbon. Cookie jelly beans marshmallow jujubes sweet.
                    </p>
                  </div>
                  <div class="tab-pane fade" id="changePassword" role="tabpanel">
                    <form method="POST" action="{{ route('change-password') }}">
                      @csrf 
                      <div class="form-group row mb-3">
                          <label for="password" class="col-sm-3 col-form-label text-md-right">Current Password</label>
                          <div class="col-md-4">
                              <input id="password" type="password" class="form-control {{$errors->has('current_password') ? 'has-error' : ''}}" name="current_password" autocomplete="current-password" value="{{ old('current_password') }}">
                              @error('current_password')
                                <div class="alert-danger mt-2">{{$errors->first('current_password') }} </div>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row mb-3">
                          <label for="password" class="col-sm-3 col-form-label text-md-right">New Password</label>

                          <div class="col-md-4">
                              <input id="new_password" minlength="6" type="password" class="form-control {{$errors->has('new_password') ? 'has-error' : ''}}" name="new_password" autocomplete="current-password" value="{{ old('new_password') }}">
                              @error('new_password')
                                <div class="alert-danger mt-2">{{$errors->first('new_password') }} </div>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row mb-3">
                          <label for="password" class="col-sm-3 col-form-label text-md-right">New Confirm Password</label>
  
                          <div class="col-md-4">
                              <input id="new_confirm_password" type="password" class="form-control {{$errors->has('new_confirm_password') ? 'has-error' : ''}}" name="new_confirm_password" autocomplete="current-password" value="{{ old('new_confirm_password') }}">
                              @error('new_confirm_password')
                                <div class="alert-danger mt-2">{{$errors->first('new_confirm_password') }} </div>
                              @enderror
                          </div>
                      </div>
 
                      <div class="form-group row mb-0">
                          <div class="col-md-8 offset-sm-3">
                              <button type="submit" class="btn btn-primary">
                                  Update
                              </button>
                          </div>
                      </div>
                  </form>
                  </div>
                  <div class="tab-pane fade" id="messages" role="tabpanel">
                    <p>
                      Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies cupcake gummi
                      bears
                      cake chocolate.
                    </p>
                    <p class="mb-0">
                      Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet roll icing
                      sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly jelly-o tart brownie
                      jelly.
                    </p>
                  </div>
                </div>
            </div>
        </div>
    </div>
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

    $(document).ready(function(){
      $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
          localStorage.setItem('activeTab', $(e.target).attr('href'));
      });
      var activeTab = localStorage.getItem('activeTab');
      if(activeTab){
          $('#tabMenu a[href="' + activeTab + '"]').tab('show');
      }
    });

</script>

@endsection