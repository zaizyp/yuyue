<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/18 0018
 * Time: 上午 9:19
 */

namespace app\weixin\controller;

use think\Controller;
use app\weixin\model\Order as WxOrder;

class Order extends Controller
{
    function computer_order(){
        $pc_order = new WxOrder(input('post.'));
        $pc_order->allowField(true)->save();
        $this->notify_test();
        return $this->fetch('index/success');
    }
    function notify_test(){
        $msg =       '{
            "touser":"oR3j8we7Y6lki2tWGoAv9OukIMQ8",
           "template_id":"FYrVIyZDWTVJrzR73lQgzVuar-5lMyollxy5C0EGtKQ",
           "data":{
                "first": {
                    "value":"您有新的订单通知！\n",
                       "color":"#173177"
                   },
                   "keyword1":{
                    "value":"核桃1斤",
                       "color":"#173177"
                   },
                   "keyword2": {
                    "value":"2014年7月21日 18:36",
                       "color":"#173177"
                   },
                   "keyword3": {
                    "value":"嘉辰时代公寓",
                       "color":"#173177"
                   },
                   "keyword4": {
                    "value":"周运平 18296732538",
                       "color":"#173177"
                   },
                   "keyword5": {
                    "value":"已付款",
                       "color":"#173177"
                   },
                   "remark":{
                    "value":"买家备注：感谢卖家\n\n模版接口测试成功",
                       "color":"#173177"
                   }
                }
        }';
        $access_token = read_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        curl_post($url,$msg);
    }
}