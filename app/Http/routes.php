<?php

// Wechat Service
// 自动回复服务
Route::post('/wechat', 'WechatController@serve');

// 设置菜单
Route::get('/wechat/setmenu', 'WechatController@setMenu');

// AirKiss
Route::get('/wifi/airkiss','WifiController@airKiss');

// 设备管理控制相关
Route::group(['middleware'=>'auth.wechat','prefix'=>'device'], function()
{
    // 设备列表
    Route::get('/','DeviceController@index');
    // 添加设备 Flow 第一步页面
    Route::get('addStep1','DeviceController@addStep1');
    // 验证Sn是否存在 Ajax调用 方法
    Route::get('checkSn','DeviceController@checkSn');
    // 添加设备 Flow 第二步页面
    Route::get('addStep2','DeviceController@addStep2');
    // 添加设备 Flow 第三步页面
    Route::get('addStep3','DeviceController@addStep3');
    // 绑定设备方法 Ajax 调用 方法
    Route::post('bind','DeviceController@bind');
    // 解除绑定方法 Ajax 调用 方法
    Route::post('unBind','DeviceController@unbind');
    // 锁定解锁方法 Ajax 调用 方法
    Route::post('deviceLock','DeviceController@deviceLock');
    // 设备控制页面
    Route::get('show/{id}','DeviceController@Show');
});
Route::get('/addStep1','DeviceController@addStep1');
Route::get('/show/{id}','DeviceController@Show');
// JsApi 测试使用
Route::get('/wifi/jsApi','WifiController@jsApi');

// 获取菜单，测试使用
Route::get('/wechat/getmenu', 'WechatController@getMenu');

// 测试使用
Route::get('/test',function(){

    return Config::get('api.test');

});