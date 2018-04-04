<?php
/**
 * Created by PhpStorm.
 * User: My_PC
 * Date: 2018/4/3
 * Time: 19:36
 */

namespace app\admin\controller;


class Weixin extends Base
{
    public function set_menu(){
        $access_token = read_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
        $data =  array('BUTTON'=>array(
            'type'=>'view',
            'name'=>$this->request->param('menu'),
            'url'=>$this->request->param('url')
        ));
        $result = curl_post($url,json_encode($data));
        return json($result);
 }


}