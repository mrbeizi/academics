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
                <img src="{{asset('assets/img/avatars/1.png')}}" class="card-img-top rounded-circle mx-auto d-block mt-4" alt="user-image" style="width: 15rem;">
                <div class="card-body">
                  <h5 class="card-title mb-0">{{Auth::user()->name}}</h5>
                  <p class="card-text">{{Auth::user()->email}}</p>
                </div>
              </div>
        </div>
        <div class="col-sm-9">
            <div class="nav-align-top">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Home</button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">Profile</button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false">Messages</button>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                    <p>
                      Icing pastry pudding oat cake. Lemon drops cotton candy caramels cake caramels sesame snaps powder. Bear
                      claw
                      candy topping.
                    </p>
                    <p class="mb-0">
                      Tootsie roll fruitcake cookie. Dessert topping pie. Jujubes wafer carrot cake jelly. Bonbon jelly-o
                      jelly-o ice
                      cream jelly beans candy canes cake bonbon. Cookie jelly beans marshmallow jujubes sweet.
                    </p>
                  </div>
                  <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                    <p>
                      Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice cream. Gummies
                      halvah
                      tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream cheesecake fruitcake.
                    </p>
                    <p class="mb-0">
                      Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah cotton candy
                      liquorice caramels.
                    </p>
                  </div>
                  <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
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

</script>

@endsection