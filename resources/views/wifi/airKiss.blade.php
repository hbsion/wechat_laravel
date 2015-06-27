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
</head>
<body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('configWXDeviceWiFi'), false, true,true) ?>);
    wx.ready(function(){
        wx.checkJsApi({
            jsApiList: ['configWXDeviceWiFi'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
            success: function(res) {
                wx.invoke('configWXDeviceWiFi', {}, function(res){
                    var resstr = res['err_msg'];
                    if(resstr == 'configWXDeviceWiFi:ok'){
                        alert('配网成功');
                        window.location.href='http://w.webbig.cn/device/addStep3?sn=<?php echo $data['sn']?>&ticket=<?php echo $data['ticket']?>';
                    }else if(resstr == 'configWXDeviceWiFi:cancel'){
                        alert('已经退出airkiss');
                        wx.closeWindow();
                    }else{
                        alert('配网失败，请重试');
                        wx.closeWindow();
                    }
                });
            },
            fail: function(res){
                alert('您的微信版本尚不支持此功能，请升级至最新版本');
                wx.closeWindow();
            }
        });

    })
</script>
</body>
</html>


