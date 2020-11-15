<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\BasicTrait;
use App\Models\UserModel;
use DB;
use Auth;
use Session;
use Cache;

class AdminController extends Controller{
    
    use BasicTrait;

    public function calculateCurrency($price){
        $sessionCurrency = session('currency');
       // $sessionCurrency=3;
        $actualPrice =0;
        if($sessionCurrency==2){
            $actualPrice= $price/70; //dollors
        }else if($sessionCurrency==3){
            $actualPrice= $price/80; //euro
        }else{
            $actualPrice= $price;
        }
        return number_format(((float)$actualPrice),2,".",".");
        // return $actualPrice;
    }
    public function calculateCurrencyWithType($currency,$price){
        $sessionCurrency = $currency;
       // $sessionCurrency=3;
        $actualPrice =0;
        if($sessionCurrency==2){
            $actualPrice= $price/70; //dollors
        }else if($sessionCurrency==3){
            $actualPrice= $price/80; //euro
        }else{
            $actualPrice= $price;
        }
        return number_format($actualPrice,2,".",".");
    }
    public function changeCurrency(Request $req){
        if(!empty($req)){
            Session::put('currency',$req->currencyVal);
            echo "YES";
        }else{
            echo "NO";
        }
    }

    public function currencySym($currency){
        $symbol = '₹';
        if(!empty($currency)){
            
            if($currency == '2'){
                $symbol = '$';
            } 
            if($currency == '3'){
                $symbol = '€';
            }
        }
        return $symbol;
    }

    public function allproducts(){
        if(!empty(session('user')['userId'])){
            $clientId = session('user')['userId'];
            $currency = session('currency');
            $products = DB::table('products')->get();
            $productsData = [];
            if(!empty($products)){
                foreach($products as $product){
                    // $product->actualPrice = '1000';
                    // echo '<pre>';
                    // print_r($product);
                    // echo '</pre>';
                    $product->actualPrice = $this->calculateCurrency($product->price);
                    $product->symbol = $this->currencySym($currency);
                    $productsData[] = $product;
                }
            }
            $cartItems = UserModel::getItems($clientId);
            return view('admin.dashboard', array('products'=>$productsData, 'cartItems'=>$cartItems));
        }else{
            return redirect()->route('Login');
        }
    }

    public function addToCart(Request $req){
        $clientId = session('user')['userId'];
        if(!empty($req)){
            $status = 0;
            $checkCart = UserModel::checkCart($clientId, $req->prodId);
            if(!empty($checkCart)){
                $resCart = UserModel::updateCart($checkCart, '1');
                if(!empty($resCart)){
                    $status = 1;
                }
            }else{
                $res = UserModel::add($clientId, $req->prodId, $req->price);
                if(!empty($res)){
                    $status = 1;
                }
            }            
            if($status == '1'){
                $cartItems = UserModel::getItems($clientId); 
                echo $cartItems;
            }else{
                echo "no";
            }
        }
    }

    public function gotoCart(){
        $clientId = session('user')['userId'];
        $currency = session('currency');
        $cart = UserModel::getCart($clientId);
        $cartData = [];
        if(!empty($cart)){
            foreach($cart as $cartItem){
                $cartItem->actualPrice = $this->calculateCurrency($cartItem->price);
                
                $cartData[] = $cartItem;
            }
        }
        $shippingCharge = $this->calculateCurrency(50);
        $symbol = $this->currencySym($currency);
        return view('admin.cart', array('cart'=>$cartData,'shippingCharge'=>$shippingCharge,'symbol'=>$symbol ));
    }

    public function placeOrder(){
        $clientId = session('user')['userId'];
        $cart = UserModel::getCart($clientId);
        return view('admin.placeorder', array('cart'=>$cart));
    }

    public function createOrder(Request $req){
        $clientId = session('user')['userId'];
        $currency = session('currency');
        if(!empty($req)){
            $orderPrice = UserModel::getOrderPrice($clientId);
            if(!empty($orderPrice)){
                $orderPrice = $this->calculateCurrency($orderPrice->orderPrice);
            }else{
                $orderPrice = 0;
            }
            $totalPrice = $orderPrice + $this->calculateCurrency(50);
            $data = array('clientId'=>$clientId, 'orderPrice'=>$orderPrice,'currentCurrencyId'=>$currency, 'deliveryFee'=>$this->calculateCurrency(50),
             'totalPrice'=>$totalPrice, 'address'=>$req->address, 'city'=>$req->city, 'state'=>$req->state, 
             'country'=>$req->country, 'mobile'=>$req->mobile, 'pincode'=>$req->pincode, 'orderStatus'=>'1', 'createdDateTime'=>date('Y-m-d H:i:s'));
            
             $orderId = UserModel::createOrder($clientId, $data);
            if(!empty($orderId)){
                $updatecartStatus = UserModel::updateCartStatus($clientId, $orderId);
                if(!empty($updatecartStatus)){
                    return redirect()->route('PlaceOrder')->with('succ', 'Order created successfully.');
                }else{
                    return redirect()->back()->with('err', 'Oops!. Something went wrong');
                }                
            }else{
                return redirect()->back()->with('err', 'Oops!. Something went wrong');
            }
        }else{
            return redirect()->back()->with('err', 'Oops!. Something went wrong');
        }
    }

    public function orders(){
        $clientId = session('user')['userId'];
        $orders = UserModel::getOrders($clientId);
        $ordersData = [];
        if(!empty($orders)){
            foreach($orders as $order){
                $order->symbol = $this->currencySym($order->currentCurrencyId);
                
                $ordersData[] = $order;
            }
        }
        return view('admin.order', array('orders'=>$ordersData));
    }

    public function plusToCart(Request $req){
        if(!empty($req)){
            $cart = UserModel::updateCart($req->cartId, '1');
            if(!empty($cart)){
                echo "YES";
            }else{
                echo "NO";
            }
        }
    }

    public function minusToCart(Request $req){
        if(!empty($req)){
            $cart = UserModel::updateCart($req->cartId, '0');
            if(!empty($cart)){
                echo "YES";
            }else{
                echo "NO";
            }
        }
    }

    public function getOrderProducts(Request $req){
        if(!empty($req)){
            $getProd = UserModel::getOrderProducts($req->orderId);
            $prodArr = [];
            $str = '';
            if(!empty($getProd)){   
                foreach($getProd as $prod){
                    $symbol = $this->currencySym($prod->currentCurrencyId);
                    $price = $this->calculateCurrencyWithType($prod->currentCurrencyId,$prod->price);
                    $str .= "<tr><td>$prod->productName</td><td>$prod->quantity</td><td>$symbol $price</td>";
                    /*$prodObj = [];
                    $prodObj['name'] = $prod->productName;
                    $prodObj['qty'] = $prod->quantity;
                    $prodObj['price'] = $prod->price;
                    $prodArr[] = $prodObj;*/
                }
            }
            echo $str;
        }
    }

    public function logout(){
        Auth::logout();
        Session::flush();
        cache::flush();
        return redirect()->route('Login');
    }
}
