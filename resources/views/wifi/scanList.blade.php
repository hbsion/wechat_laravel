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
<div id="result"></div>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('scanQRCode'), true, true,true) ?>);

    wx.ready(function(){
        wx.scanQRCode({
            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
            scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
            success: function (res) {
                var resstr = res['errMsg'];
                var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果

                if(resstr == 'scanQRCode:ok'){
                    document.getElementById("result").innerHTML = '二维码扫描结果：';
                    var input = document.createElement("input" );
                    input.type = 'text';
                    input.id = 'scanqrcode';
                    input.value = result;
                    document.getElementById("result").appendChild(input);;
                    alert('扫码成功');
//                    wx.closeWindow();
                }else if(resstr == 'scanQRCode:cancel'){
                    alert('取消扫码');
                    wx.closeWindow();
                }else{
                    alert('扫码成功失败，请重试');
                    wx.closeWindow();
                }
            }
        });

    })
</script>
</body>
</html>


