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
        //$(".switch_page").hide();//隐藏wenben
        //$(".switch_page:eq(0)").show();//显示第一个wenben
        $("#option a").click(function(){
            $(".click_switch").removeClass("click_switch");//移除样式
            $(this).addClass("click_switch");//添加样式
            var i=$(this).index();//获得下标
            $(".switch_page").hide();//隐藏wenben
            $(".switch_page:eq("+i+")").show();//显示第i个wenben
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
            <a href="<?php echo U('Home/Center/index');?>" class="click_switch">中心介绍</a>
            <a href="<?php echo U('Home/Show/index');?>">成果展示</a>
            <a href="<?php echo U('Home/Lib/index');?>">实验室管理</a>
            <a href="<?php echo U('Home/Play/index');?>">资源点播共享</a>
            <a href="<?php echo U('Home/Exam/index');?>">安全考试</a>
            <a href="<?php echo U('Home/Contact/index');?>">联系我们</a>
            <a href="<?php echo U('Home/Person/index');?>" style="border-right:1px #b6721b solid;">个人中心</a>
        </div>
</div>
<div class="switch_page">
        <div class="navigation">
            <h4>中心简介</h4>
            <i></i>
            <div class="specific_position" id="specific_position">
                    <a href="<?php echo U('Home/Center/index');?>"><span>>></span><p>中心概况</p></a>
                    <a href="<?php echo U('Home/Center/teachers');?>" class="navigation_chart"><span>>></span><p>中心师资</p></a>
                    <a href="<?php echo U('Home/Center/rules');?>"><span>>></span><p>规章制度</p></a>
            </div>
        </div>
        <div class="position">
            <h3>您的位置：中心简介>>中心师资</h3>
            <p>上海中医药大学教学实验中心于2003年正式成立，是校级建制的实验中心。教学实验中心的工作接受主管校长的全
面领导，中心重大决策向学校实验室建设委员会提出征询意见，中心主任具体贯彻实施。教学业务接受教务处的指导，
实验室的规范建设、整体规划、设备保障接受设备处的指导。中心与各二级学院、研究生部、成教部、国教院协调，完
成学校的各项实验教学任务。其他工作接受相应职能部门指导。</p>
            <p>中心下设中医学实验、中药学实验、基础医学实验和临床技能实训4大管理模块。中心使用面积约29212.4M2，设备
总台件为7846，设备总值为6031.2万元。</p>
            <p>中心建立了以能力培养为主线，分层次、多模块、相互衔接的实验教学体系，涵盖了基本实验、综合实验和创新性实
验，综合型和创新型实验课程比例达到74.4%。中心承担205门实验、实训课，3387项实验、实训项目，年完成实验人时
数597959。</p>
            <p>目前中心已荣获国家级中药学实验教学示范中心、国家级中医学实验教学示范中心、国家级中医药虚拟仿真实验教学
示范中心、上海市临床技能实训中心、上海市实验教学示范中心、上海市高校教师产学研见习基地等荣誉称号。</p>
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