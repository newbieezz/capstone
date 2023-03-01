<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    public static function sendSms($message, $mobile){
        $request = "";
        $param['authorization'] = ""; //provide the autorization
        $param['sender_id'] = ""; //provide the sender id
        $param['message'] = $message;
        $param['numbers'] = $mobile;//comes from the customer
        $param['language'] = "english";
        $param['route'] = "p";

        foreach($param as $key=>$val){
            $request.= $key."=".urlencode($val);
            $request.= "&";
        }
        $request = substr($request, 0, strlen($request)-1);

        $url ="https:/www.fast2sms.com/dev/bulk?".$request; //replcae the company url
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
    }
}
