<?php


// 应用公共文件
function curl_get($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}
function curl_post($url,$post_data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}
//获取access_token并保存到token.txt文件中
function build_access_token(){
    $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.config('appID').'&secret='.config('appsecret');
    $data = json_decode(curl_get($url));
    if($data->access_token){
        $token_file = fopen("token.txt","w") or die("Unable to open file!");//打开token.txt文件，没有会新建
        fwrite($token_file,$data->access_token);//重写tken.txt全部内容
        fclose($token_file);//关闭文件流
    }else{
        return $data->errmsg;
    }
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
    if(!file_exists("token.txt")){
        return set_interval();
    }
    $token_file = fopen("token.txt", "r") or die("Unable to open file!");
    $rs = fgets($token_file);
    fclose($token_file);
    if ($rs==''){
        set_interval();
        $token_file = fopen("token.txt", "r") or die("Unable to open file!");
        $rs = fgets($token_file);
        fclose($token_file);
    }
    return $rs;
}