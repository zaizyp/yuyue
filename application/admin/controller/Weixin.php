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
        $result = json_decode(input('menu'),1);
        $data = '{"button":[{"type":"view","name":"'.$result['menu'].'","url":"'.$result['url'].'"}]}';
        $res = json_decode(curl_post($url,$data));
        $a = json_encode($res);
        return json($a);
 }


}