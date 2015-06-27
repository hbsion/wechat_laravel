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
    <span style="margin-right: 10px;margin-left: 10px;font-weight: bold;">2 设置Wifi</span> >
    <span style="margin-left: 10px;">3 绑定设备</span>
</div>
<hr style="border:none;height: 1px;background-color: #d4d4d4;">
<form method="get" action="#" style="font-size: 20px;color: #656565; margin-top: 35%;" >
    <span style="margin-left: 10%;">开始配置前，请确认：</span><br/><br/>
    <span style="margin-left: 10%;font-size: 18px;">您的手机应通过WIFI连接上网。</span>
<div style="width: auto;margin-top: 40%;">
<button type="button" id="confirm" class="btn btn-md btn-block"
        style="width: 40%;float: left;margin-left: 5%;margin-right: 10%;opacity:1;color:#ffffff;background-color: #81c784;">确 认</button>
<button type="button" id="cancel" class="btn btn-md btn-block" style="width: 40%;opacity:1;color:#ffffff;background-color: #81c784;" >取 消</button>
</div>
</form>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8" src="/js/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8">
$("#confirm").click(function(){
    window.location.href='/wifi/airkiss?sn=<?php echo $data['sn']?>&ticket=<?php echo $data['ticket']?>';
});
$("#cancel").click(function(){
    window.location.go(-1);
});
</script>
</body>
</html>


