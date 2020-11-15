<?php

namespace App\Traits;
use DB;

trait CommonTrait
{
	public function adminsaveTimings($data, $userId, $today){
        $input = (object)$data;
        // $break2Time = $input->returnFromBreak2Hrstime_Val.':'.$input->returnFromBreak2Mintime_Val;
        $res = DB::update("exec sp_update_timeviewforday $userId,'$today', '$input->inTime_Val','$input->outtime_Val','$input->break1OutTime_Val','$input->returnfromBreak1time_Val','$input->break2OutTime_Val','$input->returnfromBreak2time_Val','$input->break3OutTime_Val','$input->returnfrombreak3time_Val','$input->break4OutTime_Val','$input->returnfrombreak4time_Val','$input->lunchOutTime_Val','$input->returnFromLunch_Val'");
    }

    public function saveTimings($data, $userId, $today){
        $input = (object)$data;
        // $break2Time = $input->returnFromBreak2Hrstime_Val.':'.$input->returnFromBreak2Mintime_Val;
        $res = DB::update("exec sp_update_timeviewforday $userId,'$today', '$input->inTime_Val','$input->outtime_Val','$input->break1OutTime_Val','$input->returnfromBreak1time_Val','$input->break2OutTime_Val','$input->returnFromBreak2time_Val','$input->break3OutTime_Val','$input->returnfrombreak3time_Val','$input->break4OutTime_Val','$input->returnfrombreak4time_Val','$input->lunchOutTime_Val','$input->returnFromLunch_Val'");
    }
}