<?php
namespace app\weixin\controller;

use think\Request;

class Index extends Base
{
    public function index()
    {

        return $this->fetch();

    }
    public function verify_token(){
        if(input('nonce')&&input('timestamp')&&input('signature')){
            $nonce     = input('nonce');
            $token     = 'zyp123456';
            $timestamp = input('timestamp');
            $echostr   = input('echostr');
            $signature = input('signature');
            //形成数组，然后按字典序排序
            $array = array();
            $array = array($nonce, $timestamp, $token);
            sort($array);
            //拼接成字符串,sha1加密 ，然后与signature进行校验
            $str = sha1( implode( $array ) );
            if( $str == $signature ){
                //第一次接入weixin api接口的时候
                echo  $echostr;
                exit;
            }
        }else{
            echo "<p>验证失败</p>";
        }

    }
    public function test(){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxc45ea54eb2e78e97&secret=256cd76671c87ca1abdc70c4f0de152d';
        //$res = json_decode(curl_file_get_contents($url));
        $res = file_get_contents($url);
        $this->assign('test',$res);
        return $this->fetch();
    }

}
