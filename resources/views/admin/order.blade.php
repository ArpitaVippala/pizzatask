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
</head>
<body class="hold-transition sidebar-mini">
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
            <i class="fas fa-shopping-cart"></i><span class="badge badge-danger navbar-badge" id="cartItems">@if(!empty($cartItems))
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
                  <h3 class="card-title">All Orders</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                        <th>Order ID</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Address</th>
                        <th>Price</th>
                        <th>Shipping Fee</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($orders))
                                @foreach($orders as $order)
                                <tr>
                                <td>{{ $order->orderId }}</td>
                                <td>{{ $order->clientName }}</td>
                                <td>{{ $order->createdDateTime }}</td>
                                <td><span style="color:#007bff; cursor:pointer;" class="orderProd" data-toggle="modal" data-target="#prodModal" data-orderId="{{ $order->orderId }}"><i class="fa fa-eye" aria-hidden="true"></i></span></td>
                                <td>{{ $order->address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->country }}, {{ $order->pincode }}</td>
                                <td>{{ $order->symbol }}{{ $order->orderPrice }}</td>
                                <td>{{ $order->symbol }}{{ $order->deliveryFee }}</td>
                                <td>{{ $order->symbol }}{{ $order->totalPrice }}</td>
                                <td>@if($order->orderStatus == '1')
                                    Inprocess
                                    @elseif($order->orderStatus == '2')
                                    <span style="color:red">Cancelled</span>
                                    @endif
                                </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
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
  <div class="modal" id="prodModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Products List</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table id="prodTable" class="table">
                <thead>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
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
<script>
$(document).ready(function(){
  $(".orderProd").click(function(){
    $orderId = $(this).attr('data-orderId');
    $.ajax({
      type:"POST", 
      url:"getOrderProducts",
      headers:{
        'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
      },
      data:{
        'orderId': $orderId
      },
      success:function(data){
        if(data != ''){
          $("#prodTable tbody").html(data);
        }
      }
    });

  });
});
</script>
</body>
