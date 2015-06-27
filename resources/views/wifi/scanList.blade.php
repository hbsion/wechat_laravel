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
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/index.css">
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div style="width: 90%;font-size: 120%;color: #656565;text-align: center;margin-left: 5%;margin-right: 5%; margin-top: 5%;">
    <span style="margin-right: 10px;font-weight: bold">1 激活设备</span> >
    <span style="margin-right: 10px;margin-left: 10px;">2 设置Wifi</span> >
    <span style="margin-left: 10px;">3 绑定设备</span>
</div>
<hr style="border:none;height: 1px;background-color: #d4d4d4;">
<form method="get" action="#" style="font-size: 20px;color:#000000;" >
    <div class="input-group" style="position:relative;width: 90%;margin-left: 5%;margin-right: 5%;font-size: 100%;">
        <input type="tel"  id="device_id" class="form-control" name="scanqrcode"
               style="height:50px;padding-left: 80px;border-radius:8px;" required>
        <span style="position: absolute;left:10px;top:30%;font-size: 16px;color: #333; z-index: 40;">机身编码:</span>
        <span style="position: absolute;left:86%;top:15%;z-index: 50;" onclick="scan()">
            <i class="fa fa-qrcode fa-2x"></i>
        </span>
    </div>
    <div style="margin-top:-10px;"><span style="margin-left: 5%;font-size: 15px;color:#656565;">若未能扫描二维码，请手动输入。</span></div>
    <br>
    <input type="hidden" id="ticket" name="ticket">
<button type="button" id="binding" class="btn btn-md btn-block" disabled="disabled"
        style="width: 90%;margin-left: 5%;margin-right: 5%;opacity:1;color:#ffffff;background-color: #81c784;height: 40px;font-size: 90%;">激 活 设 备</button>
</form>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8" src="/js/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('scanQRCode','openWXDeviceLib','getWXDeviceTicket'), false, true,true) ?>);

    wx.ready(function() {
        wx.checkJsApi({
            jsApiList: ['openWXDeviceLib'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
            success: function (res) {
                wx.invoke('openWXDeviceLib', {}, function (res) {
                    if(res.err_msg == 'openWXDeviceLib:ok'){
                        wx.checkJsApi({
                            jsApiList: ['getWXDeviceTicket'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
                            success: function(res) {
                                wx.invoke('getWXDeviceTicket', {'deviceId':'dev1','type':'1'}, function(res){
                                    if(res.err_msg == 'getWXDeviceTicket:ok'){
                                        $("#ticket").val(res.ticket);
                                        $("#binding").removeAttr("disabled");
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
    function scan(){
        wx.ready(function() {
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var resstr = res['errMsg'];
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果

                    if(resstr == 'scanQRCode:ok'){
                        $("#device_id").val(result);
                        alert('扫码成功');
                    }else if(resstr == 'scanQRCode:cancel'){
                        $("#device_id").val(result);
                        alert('取消扫码');
                    }else{
                        alert('扫码成功失败，请重试');
                        wx.closeWindow();
                    }
                }
            });
        })
    }

    $("#binding").click(function(){
        var device_id = $("#device_id").val();
        var ticket = $("#ticket").val();
        $.ajax({
            url     : 'checkSn',
            type    : 'get',
            dataType: 'json',
            data    : {sn:device_id},
            success:function(data){
                if(data.message == '200' && data.result.device_state == '0'){
                    //先跳转到确定页面
                    window.location.href='addStep2?sn='+device_id+'&ticket='+ticket;
                }else if(data.message == '404'){
                    alert('sn不存在');
                    $("#device_id").val('');
                }else if(data.message == '200' && data.result.device_state == '1'){
                    //直接绑定，跳过airkiss
                    window.location.href='addStep3?sn='+device_id+'&ticket='+ticket;
                }else if(data.message == '400'){
                    alert('请输入sn');
                }else{
                    alert('激活失败，请重试');
                }
            }
        })
    })

</script>
</body>
</html>


