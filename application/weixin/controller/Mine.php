<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/2 0002
 * Time: 上午 9:30
 */

namespace app\weixin\controller;

use app\weixin\model\WxUser;
use app\weixin\model\Order;

class Mine extends Base
{
    function index(){
        $user = WxUser::get(['openid'=>session('openid')]);
        $orders = Order::where(['openid'=>session('openid')])->column('status');
        $num = array("paidan"=>0,"queren"=>0,"pingjia"=>0,"a"=>0);
        if($orders){
            foreach ($orders as $order){
                switch ($order){
                    case 0:$num['paidan']++;break;
                    case 2:$num['queren']++;break;
                    case 3:$num['pingjia']++;break;
                    default:$num['a']++;
                }
            }
        }
        $this->assign('num',$num);
        $this->assign('user',$user);
        return $this->fetch('index/mine');
    }
}