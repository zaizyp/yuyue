<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function curl_file_get_contents($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function build_access_token(){
    $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxc45ea54eb2e78e97&secret=256cd76671c87ca1abdc70c4f0de152d';
    $data = json_decode(curl_file_get_contents($url));
    if($data->access_token){
        $token_file = fopen("token.txt","w") or die("Unable to open file!");//打开token.txt文件，没有会新建
        fwrite($token_file,$data->access_token);//重写tken.txt全部内容
        fclose($token_file);//关闭文件流
    }else{
        echo $data->errmsg;
    }
    curl_close($ch);
}

//设置定时器，每两小时执行一次build_access_token()函数获取一次access_token
function set_interval(){
    ignore_user_abort();//关闭浏览器仍然执行
    set_time_limit(0);//让程序一直执行下去
    $interval = 5400;//每隔一定时间运行
    do{
        build_access_token();
        sleep($interval);//等待时间，进行下一次操作。
    }while(true);
}

//读取token
function read_token(){
    $token_file = fopen("token.txt", "r") or die("Unable to open file!");
    $rs = fgets($token_file);
    fclose($token_file);
    return $rs;
}