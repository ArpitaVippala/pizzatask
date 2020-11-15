<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserModel extends Model
{
    // protected $table = 'login';
    
    public static function checkLogin($email){
        // echo $email;
        $res = DB::table('clients')
            ->select('*')
            ->where('email', $email)->get();
            return $res;
        if(!empty($res)){
            return $res;
        }else{
            return '';
        }
    }

    public static function add($clientId, $prodId, $price){
        $res = DB::table('cart')
                ->insertGetId(array('clientId'=>$clientId, 'productId'=>$prodId,'quantity'=>1, 'price'=>$price, 'createdDatetime'=>date('Y-m-d H:i:s')));
        return $res;
    }

    public static function getItems($clientId){
        $clientItems = DB::table('cart')->where(array('clientId'=>$clientId, 'status'=>0))->sum('quantity');
        return $clientItems;
    }

    public static function getCart($clientId){
        $cart = DB::table('cart')->select('cart.cartId', 'cart.quantity', 'cart.price', 'cart.status', 'clients.clientName', 'products.productId', 'products.productName')
                ->join('clients', 'clients.id', '=', 'cart.clientId')
                ->join('products', 'products.productId', '=', 'cart.productId')
                ->where(array('cart.clientId'=>$clientId, 'cart.status'=>0))
                ->get();
        return $cart;
    }

    public static function checkCart($clientId, $prodId){
        $items = DB::table('cart')->where(array('productId'=>$prodId, 'clientId'=>$clientId, 'status'=>0))->value('cartId');
        return $items;
    }

    public static function updateCart($cartId, $type){
        if($type == '1'){
            $cartUpdate = DB::table('cart')->where('cartId', $cartId)->increment('quantity');
        }else{
            $cartUpdate = DB::table('cart')->where('cartId', $cartId)->decrement('quantity');
        }
        return $cartUpdate;
    }

    public static function createOrder($clientId, $data){
        $orderId = DB::table('orders')
                    ->insertGetId($data);
        return $orderId;
    }

    public static function getOrderPrice($clientId){
        $price = DB::table('cart')
                    ->select(DB::raw('sum(quantity*price) as orderPrice'))->where(array('clientId'=>$clientId, 'status'=>0))->first();
        return $price;
    }

    public static function updateCartStatus($clientId, $orderId){
        $cartUpdate = DB::table('cart')->where(array('clientId'=>$clientId, 'status'=>0))->update(array('status'=>1, 'orderId'=>$orderId));
        return $cartUpdate;
    }

    public static function getOrders($clientId){
        $orders = DB::table('orders as o')->select('c.clientName', 'o.*')
                    ->join('clients as c', 'c.id', '=', 'o.clientId')
                    ->where('clientId', $clientId)
                    ->get();
        return $orders;
    }

    public static function getOrderProducts($orderId){
        $prod = DB::table('cart as c')
                    ->select('p.productName', 'p.price', 'c.quantity','o.currentCurrencyId')
                    ->join('orders as o', 'c.orderId', '=', 'o.orderId')
                    ->join('products as p', 'c.productId', '=', 'p.productId')
                    ->where('c.orderId', $orderId)
                    ->get();
        return $prod;
    }
}
