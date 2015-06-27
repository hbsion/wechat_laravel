<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Overtrue\Wechat\Js;
use Overtrue\Wechat\Server;
use Overtrue\Wechat\Device;
use Illuminate\Support\Facades\Session;
use Curl;
use Log;
use Config;
use App;


class DeviceController extends Controller {

    public function __construct(){
        $this->appId = Config::get('wechat.app_id');
        $this->appSecret = Config::get('wechat.secret');
    }

    public function index(Js $js,Server $server)
    {
        $openid = Session::get('logged_user');
        $title = '设备列表';
        $bind = new Device($this->appId,$this->appSecret);
        $arr = $bind->deviceList($openid);
        $array = array();
        foreach($arr['device_list'] as $v){
            $sn = $v['device_id'];
            $url = Config::get('api.getDevice').'sn/'.$sn;
            $response = Curl::get($url);
            $arr = json_decode($response);
            $array[] = array(
                'sn'=>$sn,
                'name'=>$arr->result->device_name,
                'app_name'=>$arr->result->app_name,
                'product_name'=>$arr->result->product_name,
                'lock'=>$arr->result->device_lock,
            );
        }
        return view('wifi/deviceList',array('js'=>$js,'arr'=>$array,'title'=>$title));
    }

    public function show(Js $js,$id){
        $title = '设备详情';
        $url = Config::get('api.getDevice').'sn/'.$id;
        $response = Curl::get($url);
        $arr = json_decode($response);
        return view('wifi/devicedetailsList',array('js'=>$js,'device'=>$arr,'title'=>$title));
    }

    public function addStep1(Js $js){
        $title = '添加设备';
        return view('wifi/scanList',array('js'=>$js,'title'=>$title));
    }

    public function checkSn(Request $request){
        $data = $request->all();
        $sn = $data['sn'];
        $url = Config::get('api.getDevice').'sn/'.$sn;
        $response = Curl::get($url);
        return $response;
    }

    public function addStep2(Request $request){
        $title = '添加设备';
        $data = $request->all();
        return view('wifi/connectList',array('title'=>$title,'data'=>$data));
    }

    public function addStep3(Request $request){
        $title = '添加设备';
        $data = $request->all();
        return view('wifi/bindingList',array('title'=>$title,'data'=>$data));
    }

    function updateDevice($sn,$device_name = null,$device_lock = null){
        $url = Config::get('api.updateDevice').$sn;
        $array['device_state'] = 1;
        if($device_name != null){
            $array['device_name'] = $device_name;
        }
        if($device_lock != null){
            $array['device_lock'] = $device_lock;
        }

        $response = Curl::post($url,array(),$array);

        if(json_decode($response)->message != 200){
            return $response; //update error
        }
    }

    public function bind(Request $request){
        $data        = $request->all();
        $openid      = Session::get('logged_user');

        //更新设备状态
        $this->updateDevice($data['sn'],$data['device_name'],$data['device_lock']);

        //在微信端绑定设备
        $bind = new Device($this->appId,$this->appSecret);
        $arrwx = $bind->bind($data['sn'],$openid, $data['ticket']);
        if($arrwx['base_resp']['errmsg'] != 'ok'){
            return json_encode(array('message' => '501')); //wx_error
        }

        //服务器端绑定
        $url = Config::get('api.bind');
        $array = array('open_id'=>$openid,'sn'=>$data['sn']);
        $response = Curl::post($url,array(), $array);
        return $response;

    }

    public function unbind(Request $request){
        $data = $request->all();
        $openid = Session::get('logged_user');

        //微信端解除设备绑定
        $bind = new Device($this->appId,$this->appSecret);
        $arrwx = $bind->unBind($data['device_id'],$openid, $data['ticket']);
        if($arrwx['base_resp']['errmsg'] != 'ok'){
            return json_encode(array('message' => '501')); //wx_error
        }

        //服务器端解除绑定关系
        $url = Config::get('api.unBind');
        $array = array('open_id'=>$openid,'sn'=>$data['device_id']);
        $response = Curl::post($url,array(), $array);
        return $response;
    }

    public function deviceLock(Request $request){
        $data = $request->all();
        $this->updateDevice($data['device_id'],null,$data['lock']);
        return json_encode(array('message' => '200'));
    }
}
