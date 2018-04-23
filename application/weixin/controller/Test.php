<?php
/**
 * Created by PhpStorm.
 * User: My_PC
 * Date: 2018/3/31
 * Time: 23:19
 */

namespace app\weixin\controller;


class Test extends Base
{
    function test_web(){
        return $this->fetch('test/index');
    }
    function ajax_test(){
        if(input('name')=='admin'&&input('password')=='123456'){
            //return json(['result'=>'success']);
            return '请求成功';
        }else{
            return '请求错误！';
        }
    }
}