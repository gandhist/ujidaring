<?php 

namespace App\Helpers;
use Request;
use App\LogActivity as LogAc;
use Illuminate\Support\Facades\Auth;


class LogActivity {

    public static function addToLog($sub){
        $log = [];
        $log['user_id'] = Auth::id();
        $log['method'] = Request::method();
        $log['subject'] = $sub;
        $log['url'] = Request::fullUrl();
        $log['ip'] = Request::ip();
        $log['user_agent'] = Request::header('user-agent');
        $log['created_by'] = Auth::id();
        LogAc::create($log);
    }

    public static function logActivityList(){
        return LogAc::latest()->get();
    }
}
