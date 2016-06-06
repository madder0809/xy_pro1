<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/visitor.css">
    <script type="text/javascript" src="/Public/js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="/Public/js/jquery.luara.0.0.1.min.js"></script>
    <script type="text/javascript" src="/Public/js/float.js"></script>
    <script type="text/javascript">
        $(function(){
        $(".switch_page").hide();//隐藏wenben
        $(".switch_page:eq(0)").show();//显示第一个wenben
        $("#option a").click(function(){
            $(".click_switch").removeClass("click_switch");//移除样式
            $(this).addClass("click_switch");//添加样式
            var i=$(this).index();//获得下标
            $(".switch_page").hide();//隐藏wenben
            $(".switch_page:eq("+i+")").show();//显示第i个wenben
        });

        $(".position").hide();//隐藏wenben
        $(".position:eq(0)").show();//显示第一个wenben
        $("#specific_position a").click(function(){
            $(".navigation_chart").removeClass("navigation_chart");//移除样式
            $(this).addClass("navigation_chart");//添加样式
            var i=$(this).index();//获得下标
            $(".position").hide();//隐藏wenben
            $(".position:eq("+i+")").show();//显示第i个wenben
        });

        $(".position1").hide();//隐藏wenben
        $(".position1:eq(0)").show();//显示第一个wenben
        $("#specific_position1 a").click(function(){
            $(".navigation_chart1").removeClass("navigation_chart1");//移除样式
            $(this).addClass("navigation_chart1");//添加样式
            var i=$(this).index();//获得下标
            $(".position1").hide();//隐藏wenben
            $(".position1:eq("+i+")").show();//显示第i个wenben
        });

        $(".position2").hide();//隐藏wenben
        $(".position2:eq(0)").show();//显示第一个wenben
        $("#specific_position2 a").click(function(){
            $(".navigation_chart2").removeClass("navigation_chart2");//移除样式
            $(this).addClass("navigation_chart2");//添加样式
            var i=$(this).index();//获得下标
            $(".position2").hide();//隐藏wenben
            $(".position2:eq("+i+")").show();//显示第i个wenben
        });

        $(".user_data").hide();//隐藏wenben
        $(".user_data:eq(0)").show();//显示第一个wenben
        $("#personal_profile a").click(function(){
            $(".revise").removeClass("revise");//移除样式
            $(this).addClass("revise");//添加样式
            var i=$(this).index();//获得下标
            $(".user_data").hide();//隐藏wenben
            $(".user_data:eq("+i+")").show();//显示第i个wenben
        });

        $(".about").hide();//隐藏wenben
        $(".about:eq(0)").show();//显示第一个wenben
        $("#mine a").click(function(){
            $(".course").removeClass("course");//移除样式
            $(this).addClass("course");//添加样式
            var i=$(this).index();//获得下标
            $(".about").hide();//隐藏wenben
            $(".about:eq("+i+")").show();//显示第i个wenben
        });

         var speed=50
            marquePic2.innerHTML=marquePic1.innerHTML
            function Marquee(){
            if(demo.scrollLeft>=marquePic1.scrollWidth){
            demo.scrollLeft=0
            }else{
            demo.scrollLeft++
            }
            }
            var MyMar=setInterval(Marquee,speed)
            demo.onmouseover=function() {clearInterval(MyMar)}
            demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)};

        //调用Luara示例
        $(".example2").luara({width:"180",height:"150",interval:4500,selected:"seleted",deriction:"left"});

    });
    function img1(){
        document.getElementById("img1").style.display="none";
    };

    </script>
</head>
<body>
<div class="suspend conent" id="img1">
    <h4>通知<a href="javascript:void();" onclick="img1();"></a></h4>
    <i></i>
    <ul>
        <li>全校今天下午搞卫生</li>
    </ul>
</div>

<div class="service">
    <h4>客服中心</h4>
    <i></i>
    <ul>
        <li><span>咨询服务：</span><a href="javascript:void();"><img src="/Public/images/icon_qq.png" height="19" width="19"></a>唐老师</li>
        <li><span>咨询邮箱：</span>93023885@qq.com</li>
        <li><span>咨询电话：</span><i>400-608-8260</i></li>
    </ul>
    <p style="border-top: 1px #ccc solid;padding-top: 10px;">服务时间<i>（北京）：</i></p>
    <p>09:00-18:00</p>
</div>
<div class="experiment_center">

    <div class="head_logo">
        <div class="head_title">
            <img src="/Public/images/syzx_logo.png" height="67" width="348">
            <a href="home_page.html"><img src="/Public/images/icon-room.png" height="17" width="18">学校主页</a>
            <h3>教学实验中心</h3>
            <img src="/Public/images/icon_prose.png" height="34" width="217" style="padding:0 20px 0 0;float:right;">
        </div>
    </div>
    <div class="option_click">
        <div style="width:1000px;margin:0 auto;" id="option">
            <a href="index.html" class="click_switch">首页</a>
            <a href="javascript:void();">中心介绍</a>
            <a href="javascript:void();">成果展示</a>
            <a href="javascript:void();">实验室管理</a>
            <a href="javascript:void();">资源点播共享</a>
            <a href="javascript:void();">安全考试</a>
            <a href="javascript:void();">联系我们</a>
            <a href="javascript:void();" style="border-right:1px #b6721b solid;">个人中心</a>
        </div>
    </div>
 <div class="switch_page">
        <div class="navigation">
            <h4>注册</h4>
            <i></i>
            <div class="specific_position" id="specific_position">
                <a href="javascript:void();" class="navigation_chart"><span>>></span><p>注册</p></a>
            </div>
        </div>
        <div class="position">
            <h3>您的位置：首页>>注册</h3>
            <div class="lookup">
                <form id="xuehao" method="post" action="<?php echo U('Home/Index/register2');?>" onsubmit="return check_form();">
                <span>学号：</span><input type="text" name="xuehao" style="width:250px;height:27px;" /><i class="warning">*</i>
                <div class="button_center">
                    <button class="confirm" type="submit">确认</button><button class="cancel">取消</button>
                </div>
                </form>
            </div>
        </div>
</div>
<script type="text/javascript">
    function check_form(){
        var sid = $("#xuehao").find("input[name='xuehao']").val();//学号
        var ok = "";
        if(!sid){
            alert("学号不能为空");
            ok = false;
        }else{
            var url = "<?php echo U('Home/Index/check_sid');?>";
            $.ajax({
                url:url,
                async : false,
                type : 'post',
                data : {sid:sid},
                dataType : 'json',
                success : function (data){
                    if(!data){
                        alert('该学籍号已被注册');
                    }
                    ok = data ? true : false;
                }
            });
        }
        return ok;
    }
</script>
	<div class="page_base">
        <div style="width:1000px;margin:0 auto;">
            <p style="padding-top: 20px;">版权所有©2014广州中医药大学</p>
            <p>教育网 粤ICP备05008872号</p>
            <p>电信网 粤ICP备05063128号</p>
            <span>地址：广州市番禺区广州大学城外环东路232号广州中医药大学</span><br>
            <span style="margin: 0 0 -10px 0;">总机：大学城 020-39358233 三元里 020-36588233  邮编：510006</span>
        </div>
    </div>
</div>
</body>
</html>