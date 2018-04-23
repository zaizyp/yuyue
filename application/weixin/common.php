<?php
function notify($msg){
    $access_token = read_token();
    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
    curl_post($url,$msg);
}