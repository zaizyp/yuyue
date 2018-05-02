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
    //获取所有订单
    function get_all(){
        $orders = WxOrder::all(['openid'=>session('openid')]);
        $this->assign('orders',$orders);
    }
    //获取单个订单
    function get($id){
        $order = WxOrder::get($id);
        $this->assign('order',$order);
    }

    //电脑维修订单的处理
    function add_computer_order(){
        //将输入的数据存储在数据库中
        $pc_order = new WxOrder(input('post.'));
        $pc_order->order_type = 'pc';
        $pc_order->status = 3;
        $pc_order->openid = session('openid');
        $pc_order->allowField(true)->save();
        //获取该订单所属范围的维修人员，并下发模版消息通知
        $waiters = db('waiter')->where('service_scope',$pc_order->dormitory)->column('openid');
        foreach ($waiters as $waiter){
            notify("电脑维修订单",$pc_order,$waiter);
        }
        //$this->notify_test();
        return $this->fetch('index/success');
    }
}