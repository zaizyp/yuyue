<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__file__'  => ['hello.php','user.php'],
    // 定义test模块的自动生成
    'admin'=>[
        '__dir__'   =>  ['controller','model'],
        'controller'=>  ['Index','User','UserType'],
        'model'     =>   ['User','UserType'],
        'view'      =>  ['index/index','index/user'],
    ],
    'weixin'=>[
        '__dir__'   =>  ['controller','model'],
        'controller'=>  ['Index','User','UserType'],
        'model'     =>   ['User','UserType'],
        'view'      =>  ['index/index','index/user'],
    ],
];
