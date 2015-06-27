
/**
 * 适用于 input,textaera
 * onEmptyText: 当输入内容为空的时候显示文本
 * onErrorText:当验证失败的时候显示的文本
 * onFocusText: 当获得焦点的时候显示的文本
 * targetId:显示提示消息的元素id
 * @param {Object} inputArg
 */
$.fn.extend({
    checkRequired:function(inputArg){
        //只有必填项才去验证，非必填项无意义
        if(inputArg.required){
                //获得焦点提示
                $(this).bind("focus",function(){
                    //如果文本存在则不替换提示样式
                    if ($(this).val() != undefined && $(this).val() != "") {
                        //显示正确信息文本
                        addText(inputArg.targetId,inputArg.onSuccessText);
                        //切换样式
                        addClass(inputArg.targetId,"suceed");
                    }else{
                        //显示获得焦点文本
                        addText(inputArg.targetId,inputArg.onFocusText);
                        //切换样式
                        addClass(inputArg.targetId,"onFocus");
                    }
                });
                
                //失去焦点提示
                $(this).bind("blur",function(){
                    if($(this).val()!=undefined && $(this).val()!=""){
                        addMessage(true,inputArg);
                    }else{
                        addMessage(false,inputArg);
                    }
                });
        }
    }
});


/**
 * 适用于 select
 * targetId:显示提示消息的元素id
 * @param {Object} inputArg
 */

$.fn.extend({
    checkSelect:function(inputArg){
        $(this).bind("change", function(){
            var selecting=$(this).val();
            $(inputArg.relation).parent(".controls").parent(".control-group").hide();
            var pr=inputArg.links.split(";");
            for(var i=0; i<pr.length; i++)
            {
                sr=pr[i].split(":");
                var selected=sr[0];
                var linked=sr[1];
                show_r=linked.split(",");
                if (selecting==selected){
                    for(var j=0; j<show_r.length ; j++){
                        $("#"+show_r[j]).parent(".controls").parent(".control-group").show();
                    }
                }
            }
            });
    }
});

/**
 * 适用于 input,textaera
 * onEmptyText: 当输入内容为空的时候显示文本
 * onSuccessText: 当验证成功的时候显示的文本
 * onErrorText:当验证失败的时候显示的文本
 * onFocusText: 当获得焦点的时候显示的文本
 * dataType:输入的数据类型
 * min:输入的最小值
 * max:输入的最大值
 * targetId:显示提示消息的元素id
 * @param {Object} inputArg
 */
$.fn.extend({
    checkRange:function(inputArg){
        //绑定焦点事件
        $(this).bind("focus",function(){
            var flag=true;
            if($(this).val()!=undefined && $(this).val()!=""){
                flag=false;
            }
            if (flag) {
                //显示获得焦点文本
                addText(inputArg.targetId, inputArg.onFocusText);
                //切换样式
                addClass(inputArg.targetId, "onFocus");
            }
        });
        
        //绑定失去焦点事件
        $(this).bind("blur",function(){
            var flag=false;
            var value=$(this).val();
            if (value == undefined || value == "") {
                //显示获得焦点文本
                addText(inputArg.targetId,inputArg.onEmptyText);
                //切换样式
                addClass(inputArg.targetId,"onEmpty");
            }else {
                switch (inputArg.dataType) {
                    case "text":
                        if(value.length < inputArg.min || value.length >= inputArg.max){
                            flag=false;
                        }else{
                            flag=true;
                        }
                        break;
                    case "number":
                        if (isNaN(value)) {
                            flag = false;
                        }
                        else {
                            if (value < inputArg.min || value >= inputArg.max) {
                                flag = false;
                            }
                            else {
                                flag = true;
                            }
                        }
                        break;
                }
                if(flag){
                    //显示获得焦点文本
                    addText(inputArg.targetId, inputArg.onSuccessText);
                    //切换样式
                    addClass(inputArg.targetId, "suceed");
                }else{
                    //显示获得焦点文本
                    addText(inputArg.targetId, inputArg.onErrorText);
                    //切换样式
                    addClass(inputArg.targetId, "failed");
                }
            }
        });
    }
});
/**
 * 适用于 input,textaera
 * onFocusText:获得焦点提示文字
 * onEmptyText:当输入项为空显示文字
 * onErrorText:验证错误显示文字
 * onSuccessText:输入成功显示文本
 * regularText: 匹配的正则表达式
 * regularTarget:比较的目标正则表达(常用正则表达式)
 * targetId:用于显示提示信息的控件id
 * @param {Object} inputArg
 */
var regulars={
    checkNum:/\D/,
    checkDecimal:/^-?\d+(\.\d+)?$/g,
    checkInteger:/^[-+]?\d*$/,
    checkEmail:/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/,
    checkTelephone:/^((1[358]\d{9})|((0(10|2[1-3]|[3-9]\d{2}))?(-)?[1-9]\d{6,7}))$/,
    checkQQ:/^\d{5,13}$/,
    checkName:/^[\u4E00-\u9FA5]{2,5}$/
};
$.fn.extend({
    checkRegExp:function(inputArg){
        if($(this).is("input") || $(this).is("textarea")){
                //绑定获得焦点
                $(this).bind("focus",function(){
                    var flag=false;
                    if($(this).val()==undefined || $(this).val()==""){
                        flag=true;
                    }
                    if (flag) {
                        //显示获得焦点文本
                        addText(inputArg.targetId, inputArg.onFocusText);
                        //切换样式
                        addClass(inputArg.targetId, "onFocus");
                    }
                });
                
                //失去焦点
                $(this).bind("blur",function(){
                    var flag=false;
                    if($(this).val()==undefined || $(this).val()==""){
                        flag=true;
                    }
                    if (flag) {
                        //显示获得焦点文本
                        addText(inputArg.targetId, inputArg.onEmptyText);
                        //切换样式
                        addClass(inputArg.targetId, "onEmpty");
                    }else{
                        var targetValue=false;
                        if(inputArg.regularTarget!=undefined && inputArg.regularTarget!=""){
                            targetValue= regulars[inputArg.regularTarget].test($(this).val());
                        }else{
                            targetValue= inputArg.regularText.test($(this).val());
                        }
                        if(targetValue){
                            //显示获得焦点文本
                            addText(inputArg.targetId, inputArg.onSuccessText);
                            //切换样式
                            addClass(inputArg.targetId, "suceed");
                        }else{
                            //显示获得焦点文本
                            addText(inputArg.targetId, inputArg.onErrorText);
                            //切换样式
                            addClass(inputArg.targetId, "failed");
                        }
                    }
                });
        }
        
        
    }
});
/**
 * 根据输入框的不同类型来判断
 * @param {Object} flag
 * @param {Object} inputArg
 */
function addMessage(flag,inputArg){
    if(flag){
        //显示正确信息文本
        addText(inputArg.targetId,inputArg.onSuccessText);
        //切换样式
        addClass(inputArg.targetId,"suceed");
    }else{
        //显示错误信息文本
        addText(inputArg.targetId,inputArg.onErrorText);
        //切换样式
        addClass(inputArg.targetId,"failed");
    }
}
/**
 * 给目标控件添加显示的文本信息
 * @param {Object} targetId 目标控件id
 * @param {Object} text        需要显示的文本信息
 */
function addText(targetId,text){
    if(text==undefined){
        text="";
    }
    $("#"+targetId).html("&nbsp;&nbsp;&nbsp;&nbsp;"+text);
}
/**
 * 切换样式
 * @param {Object} targetId 目标控件id
 * @param {Object} className 显示的样式名称
 */
function addClass(targetId,className){
    if(className!=undefined && className!=""){
        $("#"+targetId).removeClass();
        $("#"+targetId).addClass(className);
    }
}
