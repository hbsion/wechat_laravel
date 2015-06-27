<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Overtrue\Wechat\Js;
use Illuminate\Support\Facades\Session;

class WifiController extends Controller {

    public function airKiss(Js $js,Request $request){
        $title = '连接Wifi';
        $data = $request->all();
        Session::put('sn', $data['sn']);
        Session::put('ticket', $data['ticket']);
        return view('wifi/airKiss',array('js'=>$js,'title'=>$title,'data'=>$data));
    }

    public function jsApi(Js $js){
        $title = 'jstest';
        return view('wifi/js',array('js'=>$js,'title'=>$title));
    }


}
