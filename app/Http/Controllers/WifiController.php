<?php namespace App\Http\Controllers;

use Overtrue\Wechat\Js;

class WifiController extends Controller {

    public function airKiss(Js $js){
        $title = '连接Wifi';
        return view('wifi/airKiss',array('js'=>$js,'title'=>$title));
    }


    public function jsApi(Js $js){
        $title = 'jstest';
        return view('wifi/js',array('js'=>$js,'title'=>$title));
    }


}
