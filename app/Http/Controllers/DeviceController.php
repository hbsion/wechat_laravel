<?php namespace App\Http\Controllers;

use Overtrue\Wechat\Js;
use Overtrue\Wechat\User;
use Overtrue\Wechat\Server;
use Overtrue\Wechat\Message;
use Illuminate\Support\Facades\Session;

use Log;

class DeviceController extends Controller {

    public function index(Server $server)
    {
        $server->on('event', function($event){
           return 1;
        });

        $result = $server->serve();

        echo $result;

    }
    public function scan(Js $js){
        $title = '扫描二维码';
            Session::flush();

        return view('wifi/scanList',array('js'=>$js,'title'=>$title));
    }
}
