<?php namespace App\Http\Controllers;

use Overtrue\Wechat\Server;
use Overtrue\Wechat\Menu;
use Overtrue\Wechat\MenuItem;
use Log;

class WechatController extends Controller {

    /**
     * 处理微信的请求消息
     *
     * @param Overtrue\Wechat\Server $server
     *
     * @return string
     */
    public function check(Server $server)
    {
        return $server->serve();
    }

    public function serve(Server $server)
    {
        $server->on('message', function($message){
            return "欢迎关注 Skyware！";
        });

        $result = $server->serve();

        echo $result;
    }

    public function setMenu(Menu $menu)
    {
        $button = new MenuItem("设备管理");
        $menus = array(
            new MenuItem("AirKiss", 'view', 'http://w.webbig.cn/wifi/airkiss'),
            $button->buttons(array(
                new MenuItem('Jsapi', 'view', 'http://w.webbig.cn/wifi/jsApi'),
                new MenuItem('用户授权', 'view', 'http://w.webbig.cn/auth'),
                new MenuItem('设备列表', 'view', 'http://w.webbig.cn/device'),
                new MenuItem('添加设备', 'view', 'http://w.webbig.cn/deviceAdd'),
            )),
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
