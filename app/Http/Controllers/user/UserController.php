<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use DB;
use Auth;
use Session;
use Validator;

class UserController extends Controller
{
    public function login(){
        if(!empty(session('user')['userId'])){
            return redirect()->route('Products');
        }else{
            return view('login');
        }
    }

    public function loginUser(Request $req){
        //$user = LoginModel::checkLogin($req);
        if(!empty($req->all())) {            
            $user = UserModel::checkLogin($req->email);
            if(!empty($user[0])){
                // print_r($user);die();
                Session::put('user', ['userId'=>$user[0]->id, 'userName'=>$user[0]->clientName, 'userEmail'=>$user[0]->email, 'userEmail'=>$user[0]->mobile, 'userStatus'=>$user[0]->status]);
                Session::put('currency',1);
                
                return redirect()->route('Products');
            }else{
                return redirect()->back()->with('message', 'Invalid Credentials');
            }
        }
    }    
}
