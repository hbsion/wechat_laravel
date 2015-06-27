<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <script type="text/javascript" charset="utf-8" src="/js/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/index.css" />
    <link rel="stylesheet" href="/css/remodal.css">
    <link rel="stylesheet" href="/css/remodal-default-theme.css">
</head>
<body>
<!--<pre id="output"></pre>-->

<?php
$mac = $device->result->device_mac;
$data = $device->result->device_data;
$pw_status = $data->pw =='1'?'on':'off';
$lc_status = $data->lc =='1'?'on':'off';
$io_status = $data->io =='1'?'on':'off';
$uv_status = $data->uv =='1'?'on':'off';
switch($data->mo){
    case  "0" :$mo_status = 'on';break;
    case  "1" :$mo_status = 'auto_on';break;
    case  "2" :$mo_status = 'sleep_on';break;
    case  "3" :$mo_status = 'energy_on';break;
    default :$mo_status = 'off';break;
}
$tm_status = $data->tm >'000'?'on':'off';
$fa_status = in_array($data->fa ,array(1,2,3,4,5))?'on':'off';

if($pw_status == 'on'){
    if($lc_status == 'on'){
        $io_status = $uv_status =$tm_status = $fa_status = 'off';
        $pw_status = 'lock';
        switch($data->mo){
            case  "0" :$mo_status = 'off';break;
            case  "1" :$mo_status = 'auto_off';break;
            case  "2" :$mo_status = 'sleep_off';break;
            case  "3" :$mo_status = 'energy_off';break;
            default :$mo_status = 'off';break;
        }
    }
}else{
    $lc_status = $io_status = $uv_status = $tm_status = $fa_status = 'off';
    switch($data->mo){
        case  "0" :$mo_status = 'off';break;
        case  "1" :$mo_status = 'auto_off';break;
        case  "2" :$mo_status = 'sleep_off';break;
        case  "3" :$mo_status = 'energy_off';break;
        default :$mo_status = 'off';break;
    }
}

?>

<div class="container" id="container">
    <!--    <button type="button" class="btn btn-lg btn-success" id="connect"> 连接 </button>-->
    <!--    <button type="button" class="btn btn-lg btn-danger" id="heartbeat"> 心跳 </button>-->
    <div class="title">
        <h3>Media Cleaner</h3>
    </div>
    <div id ="controlBox">
        <div id ="pw" mykey='pw' value='off' class="<?php echo $pw_status?>"></div>
        <div id ="lc" mykey='lc' value='off' class="<?php echo $uv_status?>">
            <h6>灯光</h6>
        </div>
        <a onclick="tankuang('modalmode');"><div id ="mode"  mykey='mo' value='off' class="<?php echo $mo_status?>">
                <h6><?php switch($data->mo){
                        case  "0" :echo "手动模式";break;
                        case  "1" :echo "自动模式";break;
                        case  "2" :echo "睡眠模式";break;
                        case  "3" :echo "节能模式";break;
                    } ?></h6>
            </div></a>
        <div id ="lock"  mykey='lock' value='off' class="<?php echo $lc_status?>">
            <h6>童锁</h6>
        </div>
        <div id ="fan"  mykey='fa' value='off' data.value="<?php echo $data->fa?>" class="<?php echo $fa_status?>">
            <h6>风速<?php switch($data->fa){
                    case  "1" :echo "：1";break;
                    case  "2" :echo "：2";break;
                    case  "3" :echo "：3";break;
                    case  "4" :echo "：4";break;
                    case  "5" :echo "：5";break;
                } ?></h6>
        </div>
        <div id ="ion"  mykey='io' value='off' class="<?php echo $io_status?>">
            <h6>负离子</h6>
        </div>
        <a onclick="tankuang('modaltimer');"><div id ="timer"  mykey='tm' value='off' class="<?php echo $tm_status?>">
                <h6>定时：<?php echo ceil($data->tm/60); ?></h6>
            </div></a>
    </div>
</div>
<style>
    .select h5{
        height: 10%;
        margin-top: 2.5%;
        margin-bottom: 2.5%;

    }
</style>
<div class="scroll-content remodal" data-remodal-id="modalmode" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc"
     style="width: 90%;margin-left:5%;margin-right:5%;height: 70%;font-size:20px;overflow:auto;">
    <div class="select">
        <h5 data-remodal-action="cancel" id="hand">手动模式</h5>
        <h5 data-remodal-action="cancel" id="auto">自动模式</h5>
        <h5 data-remodal-action="cancel" id="sleep">睡眠模式</h5>
        <h5 data-remodal-action="cancel" id="energy">节能模式</h5>
    </div>
</div>

<div class="remodal" data-remodal-id="modaltimer" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc"
     style="width: 90%;margin-left:5%;margin-right:5%;font-size:20px;height: 70%;overflow:auto;">
    <div class="select">
        <h5 data-remodal-action="cancel" id="none">无</h5>
        <h5 data-remodal-action="cancel" id="oneh">一小时</h5>
        <h5 data-remodal-action="cancel" id="twoh">二小时</h5>
        <h5 data-remodal-action="cancel" id="threeh">三小时</h5>
        <h5 data-remodal-action="cancel" id="fourh">四小时</h5>
        <h5 data-remodal-action="cancel" id="fiveh">五小时</h5>
        <h5 data-remodal-action="cancel" id="sixh">六小时</h5>
        <h5 data-remodal-action="cancel" id="sevenh">七小时</h5>
        <h5 data-remodal-action="cancel" id="eighth">八小时</h5>
        <h5 data-remodal-action="cancel" id="nineh">九小时</h5>
        <h5 data-remodal-action="cancel" id="tenh">十小时</h5>
        <h5 data-remodal-action="cancel" id="elevenh">十一小时</h5>
        <h5 data-remodal-action="cancel" id="twelveh">十二小时</h5>
    </div>
</div>

<div id="alertBox" class="alertBox"><span></span></div>
<script src="/js/zepto.js"></script>
<script src="/js/remodal.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="application/javascript">
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideOptionMenu');
    });
    var host   = 'ws://182.92.148.183:9001';
    var socket = null;
    var mac = "<?php echo $mac;?>";
    var user = 10000;
    var sn = 0;
    var heartbeat = 30;
    var output = document.getElementById('output');
    var print  = function ( message ) {
        var samp       = document.createElement('samp');
        samp.innerHTML = message + '\n';
        output.appendChilc(samp);
        return;
    };
    function tankuang(url){
        if($("#lock").attr('class') != 'on' && $("#pw").attr('class') != 'off'){
            window.location.href="#"+url;
        }
    }
    function pwoff(){
        if($("#pw").attr('class') == "off") {
            event.preventDefault();
        }
    }

    $("#lock").click(function(){
        pwoff();
        if($("#lock").attr('value') == 'off'){
            $("#lock").attr('value','on');
        }else{
            $("#lock").attr('value','off');
        }
    });

    try {
        socket = new WebSocket(host);
        socket.onopen = function ( ) {
            //print('connection is opened');
            login(socket);
            return;
        };
        socket.onmessage = function ( msg ) {
            obj = JSON.parse(msg.data);
            data = obj.data;
            for(var i=0;i<data.length;i++){
                arr = data[i].split('::');
                switch (arr[0]){
                    case 'pw':
                        if(arr[1]=='1'){
                            $("#pw").attr('class','on');
                        }else{
                            $("#pw,#lock,#timer,#lc,#mode,#fan,#ion").attr('class','off');
                            $("#mode h6").html('手动模式');
                        }
                        break;
                    case 'lc':
                        if(arr[1] == '0'){
                            $("#lock").attr('class','off');
                        }else{
                            $("#lock").attr('class','on');
                        }
                        break;
                    case 'uv':
                        if(arr[1] == '0'){
                            $("#lc").attr('class','off');
                        }else{
                            $("#lc").attr('class','on');
                        }
                        break;
                    case 'tm':
                        if(Math.ceil(arr[1]/(60)) == '0'){
                            $("#timer").attr('class','off');
                            $("#timer h6").html('定时：0');
                        }else{
                            $("#timer").attr('class','on');
                            $("#timer h6").html('定时：' + Math.ceil(arr[1]/(60)));
                        }
                        break;
                    case 'mo':
                        switch (arr[1]){
                            case '0':
                                $("#mode").attr('class','on');
                                $("#mode h6").html('手动模式');
                                break;
                            case '1':
                                $("#mode").attr('class','auto_on');
                                $("#mode h6").html('自动模式');
                                break;
                            case '2':
                                $("#mode").attr('class','sleep_on');
                                $("#mode h6").html('睡眠模式');
                                break;
                            case '3':
                                $("#mode").attr('class','energy_on');
                                $("#mode h6").html('节能模式');
                                break;
                            default :
                                $("#mode").attr('class','off');
                                $("#mode h6").html('手动模式');
                                break;
                        }
                        break;
                    case 'fa':
                        $("#fan h6").html('风速：'+arr[1]);
                        $("#fan").attr('data.value',arr[1]);
                        $("#fan").attr('class','on');
                        break;
                    case 'io':
                        if(arr[1] == '1'){
                            $("#ion").attr('class','on');
                        }else{
                            $("#ion").attr('class','off');
                        }
                        break;
                    default:
                        break;
                }
            }
            arr = data[1].split('::');
            mode = data[4].split('::');
            if(arr[1] == '1'){
                $("#timer,#fan,#ion,#lc").attr('class','off');
                $("#pw").attr('class','lock');
                switch (mode[1]){
                    case '0':$("#mode").attr('class','off');break;
                    case '1':$("#mode").attr('class','auto_off');break;
                    case '2':$("#mode").attr('class','sleep_off');break;
                    case '3':$("#mode").attr('class','energy_off');break;
                    default :$("#mode").attr('class','off');break;
                }
            }

            return;
        };
        socket.onclose = function ( ) {
            //print('connection is closed');
            return;
        };
    }
    catch ( e ) {
        console.log(e);
    }

    //阻止浏览器默认拖拽
    document.ondragstart=function(){return false;}

    $(function(){
        $("#controlBox > div,.select > h5").click(function(){
            if($("#lock").attr('class') == 'on' && this.id != 'lock'){
                event.preventDefault();
            }
            if("<?php echo $pw_status ?>" == 'off' && this.id != 'pw'){
                event.preventDefault();
            }
            sn  = Math.floor(Math.random()*10240);
            key = this.id;
            switch (this.id){
                case 'pw':
                    if ($(this).hasClass("on")){
                        value = '0';
                    }else{
                        value = '1';
                    };
                    break;
                case 'lock':
                    key = 'lc';
                    if ($(this).hasClass("on")){
                        value = '0';
                    }else{
                        value = '1';
                    };
                    break;
                case 'ion':
                    key = 'io';
                    if ($(this).hasClass("on")){
                        value = '0';
                    }else{
                        value = '1';
                    };
                    break;
                case 'fan':
                    key = 'fa';
                    value = parseInt($(this).attr('data.value')) + parseInt(1);
                    if(value == 6 || value == null){
                        value = 1;
                    }
                    break;
                case 'lc':
                    key = 'uv';
                    if ($(this).hasClass("on")){
                        value = '0';
                    }else{
                        value = '1';
                    };
                    break;
                case 'hand':    value = '0';break;
                case 'auto':    value = '1';break;
                case 'sleep':   value = '2';break;
                case 'energy':  value = '3';break;
                case 'none':    value = '0';break;
                case 'oneh':    value = '1';break;
                case 'twoh':    value = '2';break;
                case 'threeh':  value = '3';break;
                case 'fourh':   value = '4';break;
                case 'fiveh':   value = '5';break;
                case 'sixh':    value = '6';break;
                case 'sevenh':  value = '7';break;
                case 'eighth':  value = '8';break;
                case 'nineh':   value = '9';break;
                case 'tenh':    value = '10';break;
                case 'elevenh': value = '11';break;
                case 'twelveh': value = '12';break;
                default:        break;
            };

            if(key != 'mode' || key != 'timer'){
                if(key == 'hand' || key == 'auto' || key == 'sleep' || key == 'energy'){
                    key = 'mo';
                }
                if(key == 'oneh' || key == 'twoh' || key == 'threeh' || key == 'fourh' || key == 'fiveh'|| key == 'sixh' || key == 'sevenh'|| key == 'eighth'|| key == 'nineh'|| key == 'tenh'|| key == 'elevenh'|| key == 'twelveh'|| key == 'none'){
                    key = 'tm';
                }
                str = '{\"cmd\":\"command\",\"mac\":\"'+ mac +'\",\"data\":{\"sn\":'+ sn + ',\"cmd\":\"download\","data":[\"'+ key +'::' + value + '\"]}}';
                socket.send(str);
            }
        })

    });

    function login(socket){
        login_msg = '{\"cmd\":\"ws_login\",\"mac\":\"'+ mac +'\"}';
        socket.send(login_msg);

        setInterval(function(){
            heart = '{\"cmd\":\"heartbeat\"}';
            socket.send(heart);
        },heartbeat*1000);
    }


    function phraseData(data){
        obj = JSON.parse(data);
        data = obj.data;
        var mydata = new obj;
        for(var i=0;i<data.length;i++){
            arr = data[i].split('::');
            mydata.arr[0] = arr[1];
        }
        $.each(mydata, function(key, val) {
            alert(mydata[key]);
        });
    }
</script>
</body>
</html>