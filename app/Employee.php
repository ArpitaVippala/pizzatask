<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Employee extends Model
{
	protected $table = 'employee';
	
    public function getdata(){
    	$res = DB::table('employee')->orderby('emp_id', 'asc')->get();
    	return $res;
    }
}
