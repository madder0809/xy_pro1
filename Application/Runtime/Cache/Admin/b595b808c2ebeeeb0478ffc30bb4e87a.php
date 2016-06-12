<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title><?php echo ($title); ?></title>
	<link rel="stylesheet" type="text/css" href="/Public/css/common.css">
	<script type="text/javascript" src="/Public/js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="/Public/js/common.js"></script>
</head>
<body>
<div id="banner">
	<div id="logo">LOGO</div>
	<ul>
		<!-- 主菜单 -->
		<?php if(is_array($main)): $i = 0; $__LIST__ = $main;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="/index.php/Admin/<?php echo ($vo["url"]); ?>"><li><?php echo ($vo["title"]); ?></li></a><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>
<div class="left_menu">
	<ul>
		<!-- 左边菜单 -->
		<?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><a href="/index.php/Admin/<?php echo ($nav["url"]); ?>"><li class="nav<?php echo ($nav["level"]); ?>"><?php echo ($nav["title"]); ?></li></a><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>

 
</body>
</html>