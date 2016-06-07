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
        /*$(function(){
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
        });*/

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

    /*});*/
    function img1(){
        document.getElementById("img1").style.display="none";
    };

    </script>
</head>
<body>


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
            <a href="<?php echo U('Home/Index/index');?>">首页</a>
            <a href="<?php echo U('Home/Center/index');?>">中心介绍</a>
            <a href="<?php echo U('Home/Show/index');?>">成果展示</a>
            <a href="<?php echo U('Home/Lib/index');?>" class="click_switch">实验室管理</a>
            <a href="<?php echo U('Home/Play/index');?>">资源点播共享</a>
            <a href="<?php echo U('Home/Exam/index');?>">安全考试</a>
            <a href="<?php echo U('Home/Contact/index');?>">联系我们</a>
            <a href="<?php echo U('Home/Person/index');?>" style="border-right:1px #b6721b solid;">个人中心</a>
        </div>
</div>
<div class="switch_page">
        <div class="navigation">
            <h4>实验室管理</h4>
            <i></i>
            <div class="specific_position" id="specific_position2">
                    <a href="<?php echo U('Home/Lib/index');?>" title="仪器使用预约"><span>>></span><p>仪器使用预约</p></a>
                    <a href="<?php echo U('Home/Lib/orderSearch');?>" class="navigation_chart2" title="预约查询"><span>>></span><p>预约查询</p></a>
                    <a href="<?php echo U('Home/Lib/expArr');?>"title="综合设计性实验安排"><span>>></span><p>综合设计性实验安排</p></a>
                    <a href="<?php echo U('Home/Lib/expArrSearch');?>" title="综合设计性实验查询"><span>>></span><p>综合设计性实验查询</p></a>
                    <a href="<?php echo U('Home/Lib/inExpArr');?>"title="创新性实验安排"><span>>></span><p>创新性实验安排</p></a>
                    <a href="<?php echo U('Home/Lib/inExpArrSearch');?>"title="创新性实验查询"><span>>></span><p>创新性实验查询</p></a>
            </div>
        </div>
        <div class="position2" style="position: relative;">
            <h3>您的位置：实验室管理>>预约查询</h3>
            <div class="inquiry_situation">
                <span>开始日期：</span><input name="Fruit" type="text" value="" style="height:25px;width:155px;" /><select style="width:85px;color:#8e8e8e;height:31px;margin:0 25px 0 5px;">
                        <option value ="1">9:00</option>
                        <option value ="2">10:00</option>
                    </select>
                <span>结束日期：</span><input name="Fruit" type="text" value="" style="height:25px;width:155px;" /><select style="width:85px;color:#8e8e8e;height:31px;margin-left: 5px;">
                        <option value ="1">9:00</option>
                        <option value ="2">10:00</option>
                    </select><br>
                <span>实验仪器：</span><select style="width:155px;color:#8e8e8e;height:30px;">
                        <option value ="1">分光仪</option>
                    </select>
                <span>状态：</span><select style="width:90px;color:#8e8e8e;height:31px;margin-left: 5px;margin:10px 30px 0 0;">
                        <option value ="1">所有</option>
                    </select><button class="order_inquiry">查询</button>
            </div>
            <div class="current">
                <table border="0"cellpadding="0" cellspacing="0">
                    <tr style="background:#f2f2f2;">
                        <td style="width:35px;">序号</td>
                        <td style="width: 85px;">仪器名称</td>
                        <td style="width: 195px;">使用起止日期</td>
                        <td>用户备注</td>
                        <td style="width:75px;">实验室地址</td>
                        <td>实验台号</td>
                        <td>仪器编号</td>
                        <td>状态</td>
                        <td style="width: 75px;">操作</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>分光计</td>
                        <td>3月1日周一9:00至3月2日周二17:00</td>
                        <td>aaa</td>
                        <td>药科楼A307</td>
                        <td>1</td>
                        <td>asg221</td>
                        <td>待审批</td>
                        <td><a href="javascript:void();" class="editor">编辑</a><a href="javascript:void();" class="delete">删除</a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>分光计</td>
                        <td>3月1日周一9:00至3月2日周二17:00</td>
                        <td>aaa</td>
                        <td>药科楼A307</td>
                        <td>2</td>
                        <td>sa677</td>
                        <td><span class="not_through">审批不通过</span></td>
                        <td><a href="javascript:void();" class="editor">编辑</a><a href="javascript:void();" class="delete">删除</a></td>
                    </tr>
                </table>
            </div>
            <div class="page_turning">
                每页<select style="width:65px;color:#585858;height:30px;margin:0 5px;">
                        <option value ="1">10</option>
                        <option value ="2">11</option>
                    </select>条
                    <span>共<i>61</i>条记录</span>
                    <div class="currently">
                        <button>I<</button>
                        <button><</button>
                        <button  class="location">1</button>
                        <button>2</button>
                        <button>3</button>
                        <button>></button>
                        <button>>I</button>
                    </div>
            </div>
        </div>
    </div>
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