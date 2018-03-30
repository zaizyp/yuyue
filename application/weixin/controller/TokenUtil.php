<?php
class TokenUtil {
    //获取access_token并保存到token.txt文件中
    public static function build_access_token(){
        $ch = curl_init(); //初始化一个CURL对象
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxc45ea54eb2e78e97&secret=256cd76671c87ca1abdc70c4f0de152d");//设置你所需要抓取的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置curl参数，要求结果是否输出到屏幕上，为true的时候是不返回到网页中,假设上面的0换成1的话，那么接下来的$data就需要echo一下。
        $data = json_decode(curl_exec($ch));
        if($data->access_token){
            $token_file = fopen("token.txt","w") or die("Unable to open file!");//打开token.txt文件，没有会新建
            fwrite($token_file,$data->access_token);//重写tken.txt全部内容
            fclose($token_file);//关闭文件流
        }else{
            echo $data->errmsg;
        }
        curl_close($ch);
    }

    //设置定时器，每两小时执行一次build_access_token()函数获取一次access_token
    public static function set_interval(){
        ignore_user_abort();//关闭浏览器仍然执行
        set_time_limit(0);//让程序一直执行下去
        $interval = 7200;//每隔一定时间运行
        do{
            build_access_token();
            sleep($interval);//等待时间，进行下一次操作。
        }while(true);
    }

    //读取token
    public static function read_token(){
        $token_file = fopen("token.txt", "r") or die("Unable to open file!");
        $rs = fgets($token_file);
        fclose($token_file);
        return $rs;
    }
}