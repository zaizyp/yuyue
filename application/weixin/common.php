<?php
function notify($tittle,$order,$touser){
    $msg =       '{
            "touser":"'.$touser.'",
           "template_id":"FYrVIyZDWTVJrzR73lQgzVuar-5lMyollxy5C0EGtKQ",
           "data":{
                "first": {
                    "value":"您有新的订单通知！\n",
                       "color":"#173177"
                   },
                   "keyword1":{
                    "value":"'.$tittle.'",
                       "color":"#173177"
                   },
                   "keyword2": {
                    "value":"'.$order->create_time.'",
                       "color":"#173177"
                   },
                   "keyword3": {
                    "value":"'.$order->dormitory." ".$order->address.'",
                       "color":"#173177"
                   },
                   "keyword4": {
                    "value":"'.$order->name.' '.$order->phone.'",
                       "color":"#173177"
                   },
                   "keyword5": {
                    "value":"'.$order->status.'",
                       "color":"#173177"
                   },
                   "remark":{
                    "value":"买家备注：'.$order->message.'",
                       "color":"#173177"
                   }
                }
        }';
    $access_token = read_token();
    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
    curl_post($url,$msg);
}