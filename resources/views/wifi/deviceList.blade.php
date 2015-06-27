<html>
<head>
    <title>{{$title}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no"  />
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1" media="(device-height: 568px)" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name='apple-touch-fullscreen' content='yes'>
    <meta name="full-screen" content="yes">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="/assets/js/jquery.1.11.1min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
</head>
<body>
<section class="container-fluid">
    @if($arr)
    <div class="row">
        <p id="device_title">净化器</p>
        <ul class="device_list">
            <?php
            $color=array(
                    0=>'#00d1fe',
                    1=>'#edb801',
                    2=>'#a8ed01',
                    3=>'#ff4081',
            );
            $i=0;
            ?>
            @foreach($arr as $v)
            <li class="clearfix">
                <div class="li-bg" style="background:{{$color[$i % 4]}};"></div>
                <div class="device_info">
                    <h3><a href="device/show/{{$v['sn']}}">{{$v['name']}}</a></h3>
                    <p>品牌：{{$v['app_name']}}</p>
                    <p>型号：{{$v['product_name']}}</p>
                </div>
                <div style="margin-top: 40px;float: right;">
                    {{--<input type="button" class="btn btn-info" value="解绑" style="margin-left: 10px;" onclick="relieve(this)" id="{{$v['sn']}}" >--}}
                    <button class="btn btn-info" style="margin-left: 10px;" onclick="relieve(this)" type="button" id="{{$v['sn']}}">解绑</button>
                    <button class="btn btn-info" style="margin-left: 10px;" onclick="lock(this)" data-id="{{$v['sn']}}" value="{{$v['lock']}}" type="button">@if($v['lock']=='1')锁定@else解锁@endif</button>
                </div>
            </li>
            <?php $i++;?>
            @endforeach

        </ul>
    </div>
    @endif
    <div class="row">
        <p id="device_title">智能小茶壶</p>
        <ul class="device_list">
            <li class="clearfix">
                <div class="li-bg" style="background:#00d1fe;"></div>
                <div class="device_info">
                    <h3><a href="/demo/shuihu.html">智能小茶壶</a></h3>
                    <p>品牌：智能小茶壶</p>
                    <p>型号：智能小茶壶</p>
                </div>
                <div style="margin-top: 40px;float: right;">
                    <button class="btn" disabled="disabled" style="margin-left: 10px;" type="button">解绑</button>
                    <button class="btn" disabled="disabled" style="margin-left: 10px;" type="button">锁定</button>
                </div>
            </li>
        </ul>
    </div>
    <div class="row">
        <p id="device_title">智能空调</p>
        <ul class="device_list">
            <li class="clearfix">
                <div class="li-bg" style="background:#edb801;"></div>
                <div class="device_info">
                    <h3><a href="/demo/kongtiao.html">智能空调</a></h3>
                    <p>品牌：智能空调</p>
                    <p>型号：智能空调</p>
                </div>
                <div style="margin-top: 40px;float: right;">
                    <button class="btn" disabled="disabled" style="margin-left: 10px;" type="button">解绑</button>
                    <button class="btn" disabled="disabled" style="margin-left: 10px;" type="button">锁定</button>
                </div>
            </li>
        </ul>
    </div>
</section>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8" src="/js/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('openWXDeviceLib','getWXDeviceTicket'), false, true,true) ?>);
    function relieve(e){
        var device_id = e.id;
        wx.ready(function() {
            wx.checkJsApi({
                jsApiList: ['openWXDeviceLib'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
                success: function (res) {
                    wx.invoke('openWXDeviceLib', {}, function (res) {
                        if(res.err_msg == 'openWXDeviceLib:ok'){
                            wx.checkJsApi({
                                jsApiList: ['getWXDeviceTicket'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
                                success: function(res) {
                                    wx.invoke('getWXDeviceTicket', {'deviceId':device_id,'type':'2'}, function(res){
                                        if(res.err_msg == 'getWXDeviceTicket:ok'){
                                            $.ajax({
                                                url     : 'device/unBind',
                                                type    : 'post',
                                                dataType: "json",
                                                data    : {device_id:device_id,ticket:res.ticket},
                                                success:function(data){
                                                    if(data.message == '200' || data.message == '402'){
                                                        alert('解绑成功');window.location.reload();
                                                    }else{
                                                        alert('解绑失败，请重试');window.location.reload();
                                                    }
                                                }
                                            })
                                        }else{
                                            alert('获取Ticket失败，请重试');
                                            wx.closeWindow();
                                        }
                                    });
                                }
                            });
                        }else{
                            alert('初始化设备失败，请重试');
                            wx.closeWindow();
                        }
                    });
                },
                fail: function (res) {
                    alert('您的微信版本尚不支持此功能，请升级至最新版本');
                    wx.closeWindow();
                }
            });
        })
    }
    function lock(e){
        var device_id = $(e).attr('data-id');
        var lock = $(e).attr('value');
        if(lock==0){var data_lock = 1;}else{var data_lock = 0;}
        $.ajax({
            url     : 'device/deviceLock',
            type    : 'post',
            dataType: "json",
            data    : {device_id:device_id,lock:data_lock},
            success:function(data){
                if(data.message == '200'){
                    if(data_lock == 1){
                        $(e).html('锁定');
                        $(e).attr('value','1');
                    }else{
                        $(e).html('解锁');
                        $(e).attr('value','0');
                    }
                }else{
                    if(data_lock == 1){
                        alert('解锁成功失败，请重试');window.location.reload();
                    }else{
                        alert('锁定成功，请重试');window.location.reload();
                    }

                }
            }
        })
    }

</script>

</body>
</html>


