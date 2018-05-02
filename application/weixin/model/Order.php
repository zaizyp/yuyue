<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23 0023
 * Time: 下午 7:33
 */

namespace app\weixin\model;

use think\Model;
class Order extends Model
{
    protected $autoWriteTimestamp = true;

    public function getStatusAttr($value)
    {
        $status = [-1=>'删除',0=>'待派单',1=>'已完成',2=>'待确认',3=>'待评价'];
        return $status[$value];
    }
}