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
<body>
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <!--<ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{asset('/gotoCart')}}" role="button">
            <i class="fas fa-shopping-cart"></i>
          <span class="badge badge-danger navbar-badge" id="cartItems">@if(!empty($cartItems))
            {{ $cartItems }}
            @endif
          </span></a>
        </li>
      </ul>-->
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
                  @empty($cart)
                    <div class="row">
                      <p>Your cart is empty. Continue Shopping. <a class="btn btn-success" href="{{asset('/products')}}">Shopping</a></p>
                    </div>
                  @else
                    <div class="row"  style="margin-bottom:20px">
                      <div class="col-md-2">
                        <b>Image</b>
                      </div> 
                      <div class="col-md-2">
                        <b>Product Name</b>
                      </div> 
                      <div class="col-md-2">
                        <b>Price</b>
                      </div>
                      <div class="col-md-2">
                        <b>Quantity</b>
                      </div> 
                      <div class="col-md-2">
                        <b>SubTotal</b>
                      </div>
                    </div>                  
                    <?php $val = 0; ?>
                    @foreach($cart as $cartItem)
                      <div class="row" style="margin-bottom:20px">
                        <div class="col-md-2">
                          <img src="<?php echo asset("/public/assets/pizza_img/pizza{$cartItem->productId}.jpg") ?>" height="100" width="100">
                        </div> 
                        <div class="col-md-2">
                          <p>{{ $cartItem->productName }}</p>
                        </div> 
                        <div class="col-md-2">
                          <p>{{ $symbol }} <span id="cartPrice_{{ $cartItem->cartId }}">{{ $cartItem->actualPrice }}</span></p>
                        </div>
                        <div class="col-md-2">
                          <p style="display:inline-flex;">
                            <span class="incrementPlus" id="plusId_{{ $cartItem->cartId }}" data-cartIdVal="{{ $cartItem->cartId }}" style="margin-top:12px; color:#007bff;cursor:pointer"><i class="fa fa-plus-circle" aria-hidden="true"></i></span> 
                            <span class="quantityVal" data-quanVal="{{ $cartItem->quantity }}" id="quantityId_{{ $cartItem->cartId }}" size="3" style="border: 1px solid #007bff;padding: 5px;" class="form-control" >{{ $cartItem->quantity }}</span>
                            <span class="decrementMinus" id="minusId_{{ $cartItem->cartId }}" data-cartIdVal="{{ $cartItem->cartId }}" style="margin-top:12px; color:#007bff;cursor:pointer;<?php if($cartItem->quantity <= 0) echo 'display:none' ;?>"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                          </p>
                        </div> 
                        <div class="col-md-2">
                          <p>{{ $symbol }} <span class="cartTotal" id="carTotal_{{ $cartItem->cartId }}">{{ ($cartItem->actualPrice)*($cartItem->quantity) }}</span></p>
                          <?php $val = $val+(($cartItem->actualPrice)*($cartItem->quantity)); ?>
                        </div>                
                      </div>
                    @endforeach
                    <div class="row">
                      <div class="col-md-2">
                        -
                      </div>
                      <div class="col-md-2">
                        -
                      </div>
                      <div class="col-md-2">
                        -
                      </div>
                      <div class="col-md-2">
                        <p><b>Shipping Charge:</b></p>
                        <p><b>Total:</b></p>
                      </div>
                      <div class="col-md-2">
                        <p><b>{{ $symbol }} <span id="shippingPrice">{{ $shippingCharge }}</span></b></p>
                        {{ $symbol }} <span id="totalPrice"><b>{{ $val+$shippingCharge }}</b></span>
                      </div>
                    </div>
                  
                    <div class="row">
                      <div class="col-md-7"></div>
                      <div class="col-md-2">
                        <a href="{{asset('/placeOrder')}}" class="form-control btn btn-success">Place Order</a>
                      </div>
                    </div>
                  @endempty
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
  <script>
    $(document).ready(function(){
      $.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN': $("meta[name='token']").attr('value')
        }
      });
      $("#placeOrderButt").click(function(){
        $clientId = $(this).data('clientid');
        // alert($clientId);
        /*$.ajax({
          type:"POST",
          headers:{
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
          },
          url:'createOrder',
          data:{
            'clientId':$clientId,
            'totalPrice':$("#totalPrice").text()
          },
          success:function(data){
            alert(data);
          }
        });*/
      });

      $(".incrementPlus").click(function(){
        $cartId = $(this).attr('data-cartIdVal');
        $getVal = $("#quantityId_"+$cartId).attr('data-quanVal');
        $incVal = parseFloat($getVal)+1;
        $price = $("#cartPrice_"+$cartId).text();
        $shippingPrice = $("#shippingPrice").text();
        $.ajax({
          type:"POST",
          headers:{
            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
          },
          url:"plusToCart",
          data:{
            'cartId':$cartId
          },
          success:function(data){
            // alert(data);
            if(data == 'YES'){
              $t = 0;
              $("#quantityId_"+$cartId).text($incVal);
              $("#quantityId_"+$cartId).attr('data-quanVal',$incVal);
              $total = parseFloat(parseFloat($price)*$incVal).toFixed(2);
              $("#carTotal_"+$cartId).text('');
              $("#carTotal_"+$cartId).text($total);
              $(".cartTotal").each(function(){
                $t = $t + parseFloat($(this).text());
              });
              $("#totalPrice").text('');
              $("#totalPrice").text(parseFloat(parseFloat($t)+parseFloat($shippingPrice)).toFixed(2));
              if($incVal == 5 ){
                $("#plusId_"+$cartId).css('display', 'none');
              }else{
                $("#minusId_"+$cartId).css('display', 'block');
              }
            }
          }
        });
      });

      $(".decrementMinus").click(function(){
        $cartId = $(this).attr('data-cartIdVal');
        $getVal = $("#quantityId_"+$cartId).attr('data-quanVal');
        // alert($getVal);
        $incVal = parseFloat($getVal)-1;
        $price = $("#cartPrice_"+$cartId).text();
        $shippingPrice = $("#shippingPrice").text();
        $.ajax({
          type:"POST",
          headers:{
            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
          },
          url:"minusToCart",
          data:{
            'cartId':$cartId
          },
          success:function(data){
            // alert(data);
            if(data == 'YES'){
              $t = 0;
              $("#quantityId_"+$cartId).text($incVal);
              $("#quantityId_"+$cartId).attr('data-quanVal',$incVal);
              $total = parseFloat(parseFloat($price)*$incVal).toFixed(2);
              $("#carTotal_"+$cartId).html('');
              $("#carTotal_"+$cartId).text($total);
              $(".cartTotal").each(function(){
                $t = $t + parseFloat($(this).text());
              });
              $("#totalPrice").text('');
              $("#totalPrice").text(parseFloat(parseFloat($t)+parseFloat($shippingPrice)).toFixed(2));
              if($incVal <= 0){
                $("#minusId_"+$cartId).css('display', 'none');
              }else{
                $("#plusId_"+$cartId).css('display', 'block');
              }
            }
          }
        });
      });
    });
  </script>
</body>