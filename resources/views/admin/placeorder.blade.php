<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PIZZAS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/public/assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/public/assets/css/adminlte.min.css')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}" >
  <style>
  .error{
      color:red;
      font-weight: normal !important;
  }
  </style>
</head>
<body>
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{asset('/gotoCart')}}" role="button">
            <i class="fas fa-shopping-cart"></i>
          <span class="badge badge-danger navbar-badge" id="cartItems">@if(!empty($cartItems))
            {{ $cartItems }}
            @endif
          </span></a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    @include('includes.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">New Order</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(session()->has('succ'))
                    <div class="alert alert-success" role="alert">
                        {!! session()->get('succ') !!}
                    </div>
                    @endif
                    @if(session()->has('err'))
                    <div class="alert alert-danger" role="alert">
                        {!! session()->get('err') !!}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-7">
                            <form method="POST" action="{{asset('/createOrder')}}" id="orderForm">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label for="fullName" class="col-sm-2 col-form-label">Full Name</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="fullName" name="fullName">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="email" name="email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="mobile" name="mobile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="city" class="col-sm-2 col-form-label">City</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="city" name="city">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="state" class="col-sm-2 col-form-label">State</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="state" name="state">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pincode" class="col-sm-2 col-form-label">Pincode</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="pincode" name="pincode">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="country" class="col-sm-2 col-form-label">Country</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="country" name="country">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pincode" class="col-sm-2 col-form-label">Payment</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="payMode" id="payMode" >
                                            <option value="1">Cash</option>
                                            <option value="2">Credit</option>
                                            <option value="3">Debit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                @empty($cart)
                                    @foreach($cart as $cartItem)
                                        <div class="row" style="margin-bottom:20px; margin-left:30px">
                                            <div class="col-md-4">
                                            <p>{{ $cartItem->productName }} ({{ $cartItem->quantity }})</p>
                                            </div> 
                                            <div class="col-md-4">
                                            <p>{{ $cartItem->price }}</p>
                                            </div>
                                            <div class="col-md-4">
                                            <p>{{ ($cartItem->price)*($cartItem->quantity) }}</p>
                                            </div>                
                                        </div>
                                    @endforeach 
                                @endempty
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0-pre
      </div>
      <strong>Copyright &copy; 2014-2020 <a href="#">PIZZAS</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="{{asset('/public/assets/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- bs-custom-file-input -->
  <script src="{{asset('/public/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('/public/assets/js/adminlte.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('/public/assets/js/demo.js')}}"></script>
  <script src="{{asset('/public/assets/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
  <script>
  $(document).ready(function(){
    $("#orderForm").validate({
        rules:{
            fullName:{
                required:true,   
            },
            email:{
                required:true,
                email:true
            },
            mobile:{
                required:true,
                number:true
            },
            address:{
                required:true,
            },
            city:{
                required:true,
            },
            state:{
                required:true
            },
            pincode:{
                required:true,
                number:true
            },
            country:{
                required:true
            }
        },
        messages:{
            fullName:{
                required:"Please enter your full name",   
            },
            email:{
                required:"Please enter your email address",
                email:"Please enter valid email address",
            },
            mobile:{
                required:"Please enter your mobile number",
                number:"Please enter numbers only",
            },
            address:{
                required:"Please enter your address",
            },
            city:{
                required:"Please enter your city",
            },
            state:{
                required:"Please enter your state",
            },
            pincode:{
                required:"Please enter your pincode",
                number:"Please enter numbers only"
            },
            country:{
                required:"Please enter your country"
            }
        },
        submitHandler:function(data){
            $("#orderForm")[0].submit();
        }
    });
  });
  </script>