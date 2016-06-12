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
    
 <div class="suspend conent" id="img1">
    <h4>通知<a href="javascript:void();" onclick="img1();"></a></h4>
    <i></i>
    <ul>
        <li>全校今天下午搞卫生</li>
    </ul>
</div>
<div class="option_click">
        <div style="width:1000px;margin:0 auto;" id="option">
            <a href="<?php echo U('Home/Index/index');?>" class="click_switch">首页</a>
            <a href="<?php echo U('Home/Center/index');?>">中心介绍</a>
            <a href="<?php echo U('Home/Show/index');?>">成果展示</a>
            <a href="<?php echo U('Home/Lib/index');?>">实验室管理</a>
            <a href="<?php echo U('Home/Play/index');?>">资源点播共享</a>
            <a href="<?php echo U('Home/Exam/index');?>">安全考试</a>
            <a href="<?php echo U('Home/Contact/index');?>">联系我们</a>
            <a href="<?php echo U('Home/Person/index');?>" style="border-right:1px #b6721b solid;">个人中心</a>
        </div>
</div>
    <div class="switch_page">
        <img src="/Public/images/scene.jpg" height="201" width="1000" style="margin:10px 0;">
        <?php if(cookie('uid')): ?><!-- 已登录 -->
            <div class="page_left">
                <h4>用户登陆</h4>
                <i></i>
                <div class="status">
                    <img src="/Public/images/1.jpg" height="500" width="500">
                    <ul>
                        <li>用户名：<span><?php echo ($realname); ?></span></li>
                        <li>角   色：<span>学生</span></li>
                    </ul>
                    <button class="quit" onclick="javascript:location='<?php echo U('Home/Index/logout');?>'">退出登陆</button>
                </div>
            </div>
            <?php else: ?>
            <!-- 未登录 -->
            <div class="page_left">
                <h4>用户登陆</h4>
                <i></i>
                <div class="user_login">
                    <form method="post" action="/index.php/Home/Index/login">
                    <ul>
                        <li><span>帐&nbsp;&nbsp;&nbsp;号</span><input type="text" name="username" style="width:69%;" /></li>
                        <li><span>密&nbsp;&nbsp;&nbsp;码</span><input type="password" name="password" style="width:69%;" /></li>
                        <li><span style="margin-right: 8px;">验证码</span><input type="text" name="verify" style="width:70px;" />
                            <img src="<?php echo U('Home/Index/verify');?>" height="26" onclick="this.src='/index.php/Home/Index/verify/d/'+Math.random();"></li>
                        <li><button class="user_land" type="submit">登陆</button>
                        <button type="button" class="user_enroll" onclick="javascript:location='<?php echo U('Home/Index/register1');?>'">注册</button></li>
                    </ul>
                    </form>
                </div>
            </div><?php endif; ?>
        
        
        <div class="page_centre">
        <h4>中心动态<a href="javascript:void();">更多</a></h4>
            <i></i>
            <div class="example2">
        <ul>
            <li><img src="/Public/images/play.jpg" height="152" width="181" alt="1"/></li>
            <li><img src="/Public/images/play.jpg" height="152" width="181" alt="2"/></li>
            <li><img src="/Public/images/play.jpg" height="152" width="181" alt="3"/></li>
        </ul>
        <ol>
            <li>1</li>
            <li>2</li>
            <li>3</li>
        </ol>
    </div>
            <div class="trends_time">
                <ul>
                    <li><a href="javascript:void();"><p>思政第一课王省良校长讲国际...</p></a><span>2015-09-24</span></li>
                    <li><a href="javascript:void();"><p>陈英华副书记慰问“北马”赛...</p></a><span>2015-09-23</span></li>
                    <li><a href="javascript:void();"><p>学校党委理论学习中心组开展...</p></a><span>2015-09-22</span></li>
                    <li><a href="javascript:void();"><p>樊代明院士来校做报告 妙论...</p></a><span>2015-09-21</span></li>
                    <li><a href="javascript:void();"><p>第四届“赢在广州”大学生创...</p></a><span>2015-09-18</span></li>
                    <li><a href="javascript:void();"><p>第四届“赢在广州”大学生创...</p></a><span>2015-09-18</span></li>
                </ul>
            </div>
        </div>
        <div class="page_right">
            <h4>通知公告</h4>
            <i></i>
            <div class="notice">
                <i class="notice_wire"></i>
                <ul>
                    <li><i class="notice_round"></i><a href="javascript:void();">工会小组长变更公示</a></li>
                    <li><i class="notice_round"></i><a href="javascript:void();">教学实验中心第十四期课程建设中期</a></li>
                    <li><i class="notice_round"></i><a href="javascript:void();">教学实验中心第十三期期课程建设结</a></li>
                    <li><i class="notice_round"></i><a href="javascript:void();">教学实验中心第七批大学生科创中期</a></li>
                    <li><i class="notice_round"></i><a href="javascript:void();">教学实验中心第六批大学生科创结题</a></li>
                    <li><i class="notice_round"></i><a href="javascript:void();">教学实验中心第八批大学生科创开题</a></li>
                </ul>
            </div>
        </div>

        <div class="page_left fast" style="height:240px;">
            <h4>快速通道</h4>
            <i></i>
            <div class="fast_pass">
                <ul>
                    <li><a href="javascript:void();" class="appliance">仪 器 使 用 预 约</a></li>
                    <li><a href="javascript:void();" class="subject">主 要 实 验 课 程</a></li>
                    <li><a href="javascript:void();" class="experiment">实 验 视 频</a></li>
                </ul>
            </div>
        </div>
        <div class="page_centre fruit" style="height:240px;">
        <h4>科研成果<a href="javascript:void();">更多</a></h4>
            <i></i>
            <div class="scientific_fruit">
                <ul>
                    <li><a href="javascript:void();"><img src="/Public/images/scientific.jpg" height="68" width="226"><br>国家级中医学实验教学示范中心科研成果</a></li>
                    <li><a href="javascript:void();"><img src="/Public/images/scientific.jpg" height="68" width="226"><br>国家级中医学实验教学示范中心科研成果</a></li>
                    <li><a href="javascript:void();"><img src="/Public/images/scientific.jpg" height="68" width="226"><br>国家级中医学实验教学示范中心科研成果</a></li>
                    <li><a href="javascript:void();"><img src="/Public/images/scientific.jpg" height="68" width="226"><br>国家级中医学实验教学示范中心科研成果</a></li>
                </ul>
            </div>
        </div>
        <div class="page_right system" style="height:240px;">
            <h4>规章制度</h4>
            <i></i>
            <div class="rules_system">
                <ul>
                    <li><a href="javascript:void();"><i class="notice_square"></i>教学实验中心规章制度大全</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>教学实验中心规章制度大全</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>教学实验中心规章制度大全</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>教学实验中心规章制度大全</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>教学实验中心规章制度大全</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>教学实验中心规章制度大全</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>教学实验中心规章制度大全</a></li>
                </ul>
            </div>
        </div>

        <div class="page_left friendship">
            <h4>友情链接</h4>
            <i></i>
            <div class="rules_system">
                <ul>
                    <li><a href="javascript:void();"><i class="notice_square"></i>上海中医药大学门户</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>上海中医药大学图书馆</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>上海中医药大学课程中心</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>上海市中医医师临床技能实训中心</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>高等学校实验教学示范中心</a></li>
                </ul>
            </div>
        </div>
        <div class="page_centre icon_laboratory">
        <h4>教学实验室<a href="javascript:void();">更多</a></h4>
            <i></i>
            <div class="laboratory">
                <ul style="float:left;">
                    <li><a href="javascript:void();"><span>1</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>2</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>3</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>4</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>5</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>6</span>生物化学实验室(...</a></li>
                </ul>
                <ul style="float:left;margin: 0 25px;">
                    <li><a href="javascript:void();"><span>7</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>8</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>9</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>10</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>11</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>12</span>生物化学实验室(...</a></li>
                </ul>
                <ul>
                    <li><a href="javascript:void();"><span>13</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>14</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>15</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>16</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>17</span>生物化学实验室(...</a></li>
                    <li><a href="javascript:void();"><span>18</span>生物化学实验室(...</a></li>
                </ul>
            </div>
        </div>
        <div class="page_right download">
            <h4>资料下载</h4>
            <i></i>
            <div class="rules_system">
                <ul>
                    <li><a href="javascript:void();"><i class="notice_square"></i>图书软件采购表格下载</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>图书软件采购表格下载</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>图书软件采购表格下载</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>图书软件采购表格下载</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>图书软件采购表格下载</a></li>
                    <li><a href="javascript:void();"><i class="notice_square"></i>图书软件采购表格下载</a></li>
                </ul>
            </div>
        </div>
        <div class="page_whole mien">
            <h4>实验室风采</h4>
            <i></i>
            <div id="demo">
            <table border="0" align=center cellpadding="1" cellspacing="1" cellspace="0" >
            <tr><td valign=top bgcolor=ffffff id="marquePic1">
            <table width='100%' border='0' cellspacing='0'><tr>
            <td align=center><a href='javascript:void();'><img src="/Public/images/autoplay_1.jpg" height="153" width="181"><br><br>01</a></td>
            <td align=center><a href='javascript:void();'><img src="/Public/images/autoplay_2.jpg" height="153" width="181"><br><br>02</a></td>
            <td align=center><a href='javascript:void();'><img src="/Public/images/autoplay_3.jpg" height="153" width="181"><br><br>03</a></td>
            <td align=center><a href='javascript:void();'><img src="/Public/images/autoplay_4.jpg" height="153" width="181"><br><br>04</a></td>
            <td align=center><a href='javascript:void();'><img src="/Public/images/autoplay_5.jpg" height="153" width="181"><br><br>05</a></td>
            <td align=center><a href='javascript:void();'><img src="/Public/images/autoplay_5.jpg" height="153" width="181"><br><br>05</a></td>
            </tr></table>
            </td><td id="marquePic2" valign="top"></td></tr>
            </table>
            </div>
            <div>
            </div>
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