<?php

namespace App\Traits;
use DB;

trait BasicTrait
{
    public function getAllUsers(){
        $res = DB::select("select userid, concat(firstname, ' ', lastname) as fullname from users where usertype != 'Admin' ");
        return $res;
    }

    public function getAllActiveUsers(){
        $res = DB::select("select userid, concat(firstname, ' ', lastname) as fullname from users where usertype != 'Admin' and isactive=1 ");
        return $res;
    }

    public function getRoleBaseUsers($role, $userId){
        if($role == 'Manager'){
            $res = DB::select("select userid, concat(firstname, ' ', lastname) as fullname from users where usertype='user' or userid = $userId ");
        }
        else if($role == 'User'){
            $res = DB::select("select userid, concat(firstname, ' ', lastname) as fullname from users where userid = $userId");
        }
        return $res;
    }

    public function getUserDetails($userIdVal){
        $res = DB::select("select * from users where userid=".$userIdVal);
        return $res;
    }

    public function getAllCompanies(){
        $res = DB::select("select * from company");
        return $res;
    }

    public function getUserByProc(){
        $companyUsersList = DB::select("exec sp_getuserslist '','','','','' ");
        return $companyUsersList;
    }

    public function getCompanyByProc(){
        $companyList = DB::select("exec sp_getcompany '','','' ");
        return $companyList;
    }

    public function getAllEmpTimesData(){
        $userId = session('user')['userId'];
        $res = DB::select("select t.*, CONCAT(u.firstname, ' ', u.lastname) as fullname, 
            (case when DATEDIFF(MINUTE, intime, outtime)< 0 then 0 else DATEDIFF(MINUTE, intime, outtime) end) as intimediff, 
            (case when DATEDIFF(MINUTE, break1outtime, returnfrombreak1time)<0 then 0 else DATEDIFF(MINUTE, break1outtime, returnfrombreak1time) end) as break1diff, 
            (case when DATEDIFF(MINUTE, break2outtime, returnfrombreak2time)<0 then 0 else DATEDIFF(MINUTE, break2outtime, returnfrombreak2time) end) as break2diff, 
            (case when DATEDIFF(MINUTE, break3outtime, returnfrombreak3time)<0 then 0 else DATEDIFF(MINUTE, break3outtime, returnfrombreak3time) end) as break3diff,
            (case when DATEDIFF(MINUTE, break4outtime, returnfrombreak4time)<0 then 0 else DATEDIFF(MINUTE, break4outtime, returnfrombreak4time) end) as break4diff,
            (case when DATEDIFF(MINUTE, lunchouttime, returnfromlunchtime)<0 then 0 else DATEDIFF(MINUTE, lunchouttime, returnfromlunchtime) end) as lunchdiff from timeentrydetails t join users u on u.userid = t.userid where t.userid = ".$userId);
        return $res;
    }

    public function getAllEmpTimesCriteria($input){
        $var = $userType = '';
        if(!empty($input)){
            $userId = $input['userIdVal'];
            if($input['userIdVal'] != 'All'){
                $userType = " and t.userid = ".$userId;
            }
            $var = "where month(entrydate)= ".$input['month']." and year(entrydate) = ".$input['year']. $userType;
        }
        $res = DB::select("select t.*, CONCAT(u.firstname, ' ', u.lastname) as fullname,
            (case when DATEDIFF(MINUTE, intime, outtime)< 0 then 0 else DATEDIFF(MINUTE, intime, outtime) end) as intimediff, 
            (case when DATEDIFF(MINUTE, break1outtime, returnfrombreak1time)<0 then 0 else DATEDIFF(MINUTE, break1outtime, returnfrombreak1time) end) as break1diff, 
            (case when DATEDIFF(MINUTE, break2outtime, returnfrombreak2time)<0 then 0 else DATEDIFF(MINUTE, break2outtime, returnfrombreak2time) end) as break2diff, 
            (case when DATEDIFF(MINUTE, break3outtime, returnfrombreak3time)<0 then 0 else DATEDIFF(MINUTE, break3outtime, returnfrombreak3time) end) as break3diff,
            (case when DATEDIFF(MINUTE, break4outtime, returnfrombreak4time)<0 then 0 else DATEDIFF(MINUTE, break4outtime, returnfrombreak4time) end) as break4diff,
            (case when DATEDIFF(MINUTE, lunchouttime, returnfromlunchtime)<0 then 0 else DATEDIFF(MINUTE, lunchouttime, returnfromlunchtime) end) as lunchdiff 
             from timeentrydetails t join users u on u.userid = t.userid ".$var." order by t.entrydate desc");
        return $res;
    }

    public function getCurrentStatusofAll(){
        $today = session('user')['today'];
        $res = DB::select("select CONCAT(u.firstname, ' ', u.lastname) as fullname, t.* from users u left join timeentrydetails t on u.userid = t.userid and t.entrydate = '".$today."' where u.usertype != 'Admin' and isactive = 1");
        return $res;
    }

    public function checkUserAvailableThisMonth($userId, $month, $year){
        $res = DB::select("select u.userid from users u join timeentrydetails t on u.userid = t.userid where month(t.entrydate) = ".$month." and year(entrydate) = ".$year." and u.userid = ".$userId);
        if(!empty($res)){
            return true;
        }else{
            return false;
        }
    }

    public function getUpdatedTimings($todayTimeview){
        if(!empty($todayTimeview)){
            if(!empty($todayTimeview[0]->intime)){
                $inTimesplit = explode(':', $todayTimeview[0]->intime);
                $todayTimeview[0]->inTimeHrsVal = trim(preg_replace('/\s+/','',$inTimesplit[0]));
                $todayTimeview[0]->inTimeMinVal = trim(preg_replace('/\s+/','',$inTimesplit[1]));
            }
            if(!empty($todayTimeview[0]->outtime)){
                $outTimesplit = explode(':', $todayTimeview[0]->outtime);
                $todayTimeview[0]->outTimeHrsVal = trim(preg_replace('/\s+/','',$outTimesplit[0]));
                $todayTimeview[0]->outTimeMinVal = trim(preg_replace('/\s+/','',$outTimesplit[1]));
            }
            if(!empty($todayTimeview[0]->break1outtime)){
                $break1outTimesplit = explode(':', $todayTimeview[0]->break1outtime);
                $todayTimeview[0]->break1outTimeHrsVal = trim(preg_replace('/\s+/','',$break1outTimesplit[0]));
                $todayTimeview[0]->break1outTimeMinVal = trim(preg_replace('/\s+/','',$break1outTimesplit[1]));
            }
            if(!empty($todayTimeview[0]->returnfrombreak1time)){
                $returnfrombreak1Timesplit = explode(':', $todayTimeview[0]->returnfrombreak1time);
                $todayTimeview[0]->returnfrombreak1TimeHrsVal = trim(preg_replace('/\s+/','',$returnfrombreak1Timesplit[0]));
                $todayTimeview[0]->returnfrombreak1TimeMinVal = trim(preg_replace('/\s+/','',$returnfrombreak1Timesplit[1]));
            }
            if(!empty($todayTimeview[0]->break2outtime)){
                $break2outTimesplit = explode(':', $todayTimeview[0]->break2outtime);
                $todayTimeview[0]->break2outTimeHrsVal = trim(preg_replace('/\s+/','',$break2outTimesplit[0]));
                $todayTimeview[0]->break2outTimeMinVal = trim(preg_replace('/\s+/','',$break2outTimesplit[1]));
            }
            if(!empty($todayTimeview[0]->returnfrombreak2time)){
                $returnfrombreak2Timesplit = explode(':', $todayTimeview[0]->returnfrombreak2time);
                $todayTimeview[0]->returnfrombreak2TimeHrsVal = trim(preg_replace('/\s+/','',$returnfrombreak2Timesplit[0]));
                $todayTimeview[0]->returnfrombreak2TimeMinVal = trim(preg_replace('/\s+/','',$returnfrombreak2Timesplit[1]));
            }
            if(!empty($todayTimeview[0]->break3outtime)){
                $break3outTimesplit = explode(':', $todayTimeview[0]->break3outtime);
                $todayTimeview[0]->break3outTimeHrsVal = trim(preg_replace('/\s+/','',$break3outTimesplit[0]));
                $todayTimeview[0]->break3outTimeMinVal = trim(preg_replace('/\s+/','',$break3outTimesplit[1]));
            }
            if(!empty($todayTimeview[0]->returnfrombreak3time)){
                $returnfrombreak3Timesplit = explode(':', $todayTimeview[0]->returnfrombreak3time);
                $todayTimeview[0]->returnfrombreak3TimeHrsVal = trim(preg_replace('/\s+/','',$returnfrombreak3Timesplit[0]));
                $todayTimeview[0]->returnfrombreak3TimeMinVal = trim(preg_replace('/\s+/','',$returnfrombreak3Timesplit[1]));
            }
            if(!empty($todayTimeview[0]->break4outtime)){
                $break4outTimesplit = explode(':', $todayTimeview[0]->break4outtime);
                $todayTimeview[0]->break4outTimeHrsVal = trim(preg_replace('/\s+/','',$break4outTimesplit[0]));
                $todayTimeview[0]->break4outTimeMinVal = trim(preg_replace('/\s+/','',$break4outTimesplit[1]));
            }
            if(!empty($todayTimeview[0]->returnfrombreak4time)){
                $returnfrombreak4Timesplit = explode(':', $todayTimeview[0]->returnfrombreak4time);
                $todayTimeview[0]->returnfrombreak4TimeHrsVal = trim(preg_replace('/\s+/','',$returnfrombreak4Timesplit[0]));
                $todayTimeview[0]->returnfrombreak4TimeMinVal = trim(preg_replace('/\s+/','',$returnfrombreak4Timesplit[1]));
            }
            if(!empty($todayTimeview[0]->lunchouttime)){
                $lunchoutTimesplit = explode(':', $todayTimeview[0]->lunchouttime);
                $todayTimeview[0]->lunchoutTimeHrsVal = trim(preg_replace('/\s+/','',$lunchoutTimesplit[0]));
                $todayTimeview[0]->lunchoutTimeMinVal = trim(preg_replace('/\s+/','',$lunchoutTimesplit[1]));
            }
            if(!empty($todayTimeview[0]->returnfromlunchtime)){
                $returnfromlunchTimesplit = explode(':', $todayTimeview[0]->returnfromlunchtime);
                $todayTimeview[0]->returnfromlunchTimeHrsVal = trim(preg_replace('/\s+/','',$returnfromlunchTimesplit[0]));
                $todayTimeview[0]->returnfromlunchTimeMinVal = trim(preg_replace('/\s+/','',$returnfromlunchTimesplit[1]));
            }
        }
        return $todayTimeview;
    }

    public function getManagerTimings($input){
        $inTime = (!empty($input['inTime_Hrs_Val'] && $input['inTime_Min_Val'])?($input['inTime_Hrs_Val'].':'.$input['inTime_Min_Val']):'');
        $input['inTime_Val'] = $inTime;

        $break1OutTime = (!empty($input['break1OutTime_Hrs_Val'] && $input['break1OutTime_Min_Val'])?($input['break1OutTime_Hrs_Val'].':'.$input['break1OutTime_Min_Val']):'');
        $input['break1OutTime_Val'] = $break1OutTime;

        $returnfromBreak1Time = (!empty($input['returnfromBreak1time_Hrs_Val'] && $input['returnfromBreak1time_Min_Val'])?($input['returnfromBreak1time_Hrs_Val'].':'.$input['returnfromBreak1time_Min_Val']):'');
        $input['returnfromBreak1time_Val'] = $returnfromBreak1Time;

        $break2OutTime = (!empty($input['break2OutTime_Hrs_Val'] && $input['break2OutTime_Min_Val'])?($input['break2OutTime_Hrs_Val'].':'.$input['break2OutTime_Min_Val']):'');
        $input['break2OutTime_Val'] = $break2OutTime;

        $returnfromBreak2Time = (!empty($input['returnFromBreak2_Hrs_Val'] && $input['returnFromBreak2_Min_Val'])?($input['returnFromBreak2_Hrs_Val'].':'.$input['returnFromBreak2_Min_Val']):'');
        $input['returnfromBreak2time_Val'] = $returnfromBreak2Time;

        $break3OutTime = (!empty($input['break3OutTime_Hrs_Val'] && $input['break3OutTime_Min_Val'])?($input['break3OutTime_Hrs_Val'].':'.$input['break3OutTime_Min_Val']):'');
        $input['break3OutTime_Val'] = $break3OutTime;

        $returnfrombreak3Time = (!empty($input['returnfrombreak3time_Hrs_Val'] && $input['returnfrombreak3time_Min_Val'])?($input['returnfrombreak3time_Hrs_Val'].':'.$input['returnfrombreak3time_Min_Val']):'');
        $input['returnfrombreak3time_Val'] = $returnfrombreak3Time;

        $break4OutTime = (!empty($input['break4OutTime_Hrs_Val'] && $input['break4OutTime_Min_Val'])?($input['break4OutTime_Hrs_Val'].':'.$input['break4OutTime_Min_Val']):'');
        $input['break4OutTime_Val'] = $break4OutTime;

        $returnfrombreak4Time = (!empty($input['returnfrombreak4time_Hrs_Val'] && $input['returnfrombreak4time_Min_Val'])?($input['returnfrombreak4time_Hrs_Val'].':'.$input['returnfrombreak4time_Min_Val']):'');
        $input['returnfrombreak4time_Val'] = $returnfrombreak4Time;

        $lunchOutTime = (!empty($input['lunchOutTime_Hrs_Val'] && $input['lunchOutTime_Min_Val'])?($input['lunchOutTime_Hrs_Val'].':'.$input['lunchOutTime_Min_Val']):'');
        $input['lunchOutTime_Val'] = $lunchOutTime;

        $returnFromLunchTime = (!empty($input['returnFromLunch_Hrs_Val'] && $input['returnFromLunch_Min_Val'])?($input['returnFromLunch_Hrs_Val'].':'.$input['returnFromLunch_Min_Val']):'');
        $input['returnFromLunch_Val'] = $returnFromLunchTime;

        $OutTime = (!empty($input['outtime_Hrs_Val'] && $input['outtime_Min_Val'])?($input['outtime_Hrs_Val'].':'.$input['outtime_Min_Val']):'');
        $input['outtime_Val'] = $OutTime;
        return $input;
    }
}
