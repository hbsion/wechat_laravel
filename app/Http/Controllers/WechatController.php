<?php namespace App\Http\Controllers;

use Overtrue\Wechat\Server;
use Overtrue\Wechat\Message;
use Overtrue\Wechat\Menu;
use Overtrue\Wechat\Media;
use Overtrue\Wechat\MenuItem;
use Log;
use Config;
use Curl;

class WechatController extends Controller {

    public $message = '';
    public function __construct(){
        $redis = new \redis;
        $redis->pconnect('127.0.0.1', '6379', '0.0');
        $this->redis = $redis;
        $this->access_token = $redis->get('access_token');
        if(!$this->access_token ){
            $appId = Config::get('wechat.app_id');
            $appSecret = Config::get('wechat.secret');
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appId.'&secret='.$appSecret.'';
            $res = Curl::get($url);
            $arr = json_decode($res);
            $access_token = $arr->access_token;
            $time_out = $arr->expires_in;
            $this->redis->set('access_token',$access_token);
            $this->redis->expire('access_token',$time_out);
            $this->access_token = $access_token;
        }

    }

    public function serve(Server $server)
    {

        // 监听所有类型
        $server->on('event','click', function($event) {

            $appId = Config::get('wechat.app_id');
            $appSecret = Config::get('wechat.secret');
            $access_token = $this->access_token;
            $message = '';

            $media = new media($appId,$appSecret);
            $arr = $media->lists('news', '0', '20');
            if($event['EventKey'] == 'a') {
                $media_id = '3gp3sK9--7rGxLoN_n78eYEDWwXJEB52EGa5QqvvAe8';
            }else if($event['EventKey'] == 'b'){
                $media_id = 'dk6HHcmPn8H907So8ayA5UAd3K6i48AwZdMFE_5aV3I';
            }
            foreach($arr['item'] as $v){
                if ($v['media_id'] == $media_id){
                    foreach($v['content']['news_item'] as $val){
                        $title = $val['title'];
                        $digest = $val['digest'];
                        $url = $val['url'];
                        $imgid = $val['thumb_media_id'];
                        $imgurl = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$access_token;
                        $array = array(
                            'type'=>'image',
                            'offset'=>'0',
                            'count'=>'20'
                        );
                        $array = json_encode($array);
                        $response = Curl::post($imgurl,array(),$array);
                        $arr = json_decode($response);
                        foreach($arr->item as $k){
                            if($k->media_id == $imgid){
                                $imgurl = $k->url;
                            }
                        }
                        $message[]= Message::make('news_item')->title($title)->description($digest)->url($url)->picUrl($imgurl);
                    }
                }
            }
            $this->message = $message;

            if($event['EventKey'] == 'a'){
                return Message::make('news')->items(function(){
                    $mes =array();
                    foreach($this->message as $v){
                        array_push($mes,$v);
                    }
                    return $mes;
                });
            }else if ($event['EventKey'] == 'b'){
                return Message::make('news')->items(function(){
                    $mes =array();
                    foreach($this->message as $v){
                        array_push($mes,$v);
                    }
                    return $mes;
                });
            }

        });
        $server->on('message', function($message){
            return "欢迎关注 Skyware！";
        });
        $result = $server->serve();
        echo $result;
    }

    public function setMenu(Menu $menu)
    {
        $button = new MenuItem("我的家电");
        $menus = array(
            $button->buttons(array(
//                new MenuItem('设备配网', 'view', 'http://w.webbig.cn/wifi/airkiss'),
//                new MenuItem('美的空调', 'view', 'http://www.loveforevermore.com/wxkt/zhukong.html'),
                new MenuItem('设备列表', 'view', 'http://w.webbig.cn/device'),
                new MenuItem('添加设备', 'view', 'http://w.webbig.cn/device/addStep1'),
            )),
            new MenuItem("产品服务", 'click', 'a'),
            new MenuItem("合作案例", 'click', 'b'),

        );


        try {
            $menu->set($menus);// 请求微信服务器
            echo '设置成功！';
        } catch (\Exception $e) {
            echo '设置失败：' . $e->getMessage();
        }

        return '菜单设置成功!';
    }

    public function getMenu(Menu $menu)
    {
        $result = $menu->get();
        var_dump($result) ;
    }


}
