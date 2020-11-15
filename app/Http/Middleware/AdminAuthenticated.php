<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $res = session('user')['role'];
        if($res == 'Admin'){
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}