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
        $token_file = fopen("token.json","w") or die("Unable to open file!");//打开token.txt文件，没有会新建
        $token_data = array();
        $token_data['access_token'] = $data->access_token;
        $token_data['expires_in'] = time()+7000;
        fwrite($token_file,json_encode($token_data));//重写tken.txt全部内容
        fclose($token_file);//关闭文件流
        return $data->access_token;
    }else{
        return $data->errmsg;
    }
}

//读取token
function read_token(){
    if(!file_exists("token.json")){
        return build_access_token();
    }
    $result = json_decode(file_get_contents('token.json'),1);
    if (time() > $result['expires_in']){
        return build_access_token();
    }else{
        return $result['access_token'];
    }
}