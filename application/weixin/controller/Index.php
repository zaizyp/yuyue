<?php
namespace app\weixin\controller;

use think\Request;
use app\weixin\model\WxUser;

class Index extends Base
{
    public function index()
    {

        return $this->fetch();

    }
    //验证token
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
    //测试
    public function test(){
        //$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxc45ea54eb2e78e97&secret=256cd76671c87ca1abdc70c4f0de152d';
        //$res = json_decode(curl_file_get_contents($url));
        //$res = file_get_contents($url);
        $res = read_token();
        $this->assign('test',$res);
        return $this->fetch();
    }

    //登录
    public function login(){
        if(!session('?openid')){
            //获取微信传过来的code
            $code = input('code');
            //获取用户信息
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.config('appID').'&secret='.config('appsecret').'&code='.$code.'&grant_type=authorization_code';
            $result = json_decode(curl_get($url),1);
            //判断用户是否第一次登录
            $wx_user = WxUser::get(['openid'=>$result['openid']]);
            if(!$wx_user){
                $durl = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$result['access_token'].'&openid='.$result['openid'].'&lang=zh_CN';
               $data = json_decode(curl_get($durl),1);
               $wxUser = new WxUser($data);
               $wxUser->login_times = 1;
               $wxUser->allowField(true)->save();
                $this->assign('data',$wxUser);
            }else{
                $wx_user->login_times++;
                $wx_user->save();
                $this->assign('data',$wx_user);
            }
            session('openid',$result['openid']);
        }
        return $this->fetch('index/index');
    }
    //下单界面
    public function add_order($order_type){
        switch ($order_type){
            case 'pc':
                $list = db('dormitory')->select();
                $this->assign('list',$list);
                return $this->fetch('index/add_pc');
                break;
            case 'water':return $this->fetch('index/add_water');
                break;
            case 'express':return $this->fetch('index/add_express');
                break;
            default:return $this->fetch('index/index');
                break;
        }
    }
}
