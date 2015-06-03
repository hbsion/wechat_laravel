<?php

Route::get('/auth','AuthController@index');
Route::get('/wechat', 'WechatController@check');
Route::post('/wechat', 'WechatController@serve');
Route::get('/wechat/getmenu', 'WechatController@getMenu');
Route::get('/wechat/setmenu', 'WechatController@setMenu');
Route::get('/wifi/airkiss','WifiController@airKiss');
Route::get('/wifi/jsApi','WifiController@jsApi');


Route::group(['middleware'=>'auth.wechat'], function()
{
    Route::get('/device','DeviceController@index');
    Route::get('/deviceAdd','DeviceController@scan');
});