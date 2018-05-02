<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/2 0002
 * Time: 上午 9:30
 */

namespace app\weixin\controller;


class Mine extends Base
{
    function index(){
        $user = WxUser::get(['openid'=>session('openid')]);
        $this->assign('user',$user);

        return $this->fetch('index/mine');
    }
}