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
    <span style="margin-right: 10px;">1 激活设备</span> >
    <span style="margin-right: 10px;margin-left: 10px;">2 设置Wifi</span> >
    <span style="margin-left: 10px;font-weight: bold;">3 绑定设备</span>
</div>
<hr style="border:none;height: 1px;background-color: #d4d4d4;">
<form method="post" action="bind" style="font-size: 20px;color:#000000;" >
    <div class="input-group" style="width: 90%;margin-left: 5%;margin-right: 5%">
        <input type="text" required="" id="device_name" class="form-control" style="height:50px;padding-left: 80px; border-radius:8px;" name="device_name">
        <span style="position: absolute;left:10px;top:30%;font-size: 16px;color: #333; z-index: 40;">设备名称:</span>
    </div>
    <div class="input-group" style="width: 90%;margin-left: 5%;margin-right: 5%">
        <input type="text" id="lockstatus" class="form-control" value="未锁定" name="lockstatus" disabled style="width: 100%;height:50px;float: left;padding-left: 80px;border-radius:8px;">
        <span style="position: absolute;left:10px;top:30%;font-size: 16px;color: #333; z-index: 40;">设备状态:</span>
        <button type="button" id="binding" class="btn btn-md btn-block"
                style="width: 20%;height:80%;position: absolute;left:78%;top:10%;z-index: 50;opacity:1;color:#ffffff;background-color: #81c784;" >锁 定</button>
        <input type="hidden" id="device_lock" name="device_lock" value="1">
        <input type="hidden" id="sn" name="sn" value="<?php echo $data['sn']?>">
        <input type="hidden" id="ticket" name="ticket" value="<?php echo $data['ticket']?>">
    </div>
<button type="button" class="btn btn-md btn-block" id="button"
        style="width: 90%;margin-left: 5%;margin-right: 5%;height: 40px;opacity:1;color:#ffffff;background-color: #81c784;" >绑 定 设 备</button>
</form>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8" src="/js/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8">
$("#button").click(function(){
    $.ajax({
        url     : 'bind',
        type    : 'post',
        dataType: 'json',
        data    : {device_name:$("#device_name").val(),device_lock:$("#device_lock").val(),sn:$("#sn").val(),ticket:$("#ticket").val()},
        success:function(data){
            switch (data.message){
                case 400:alert('绑定失败1，请重试');window.location.href='addStep1';break;
                case 500:alert('绑定失败2，请重试');window.location.href='addStep1';break;
                case 501:alert('绑定失败3，请重试');window.location.href='addStep1';break;
                case 200:alert('设备绑定成功');window.location.href='http://w.webbig.cn/device';break;
                case 401:alert('该设备不存在');window.location.href='addStep1';break;
                case 402:alert('该设备已绑定');window.location.href='http://w.webbig.cn/device';break;
                default :alert('绑定失败4，请重试');window.location.href='addStep1';break;
            }
        }
    })
})
$("#binding").click(function(){
    if($("#lockstatus").val() == '未锁定'){
        $("#lockstatus").val('已锁定');
        $("#device_lock").val('0');
        $("#binding").html('解 锁');
    }else{
        $("#lockstatus").val('未锁定');
        $("#device_lock").val('1');
        $("#binding").html('锁 定');
    }
})
</script>
</body>
</html>


