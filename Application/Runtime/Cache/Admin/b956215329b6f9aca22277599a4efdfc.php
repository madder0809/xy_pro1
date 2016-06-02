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

 <div class="table">
	<div class="top_menu">
		<a href="/index.php/Admin/Menu/add/pid/0">添加菜单</a>
	</div>
	<table>
		<tr>
			<th width="5%">ID</th>
			<th width="70%">菜单名称</th>
			<th width="20%">操作</th>
		</tr>
		<?php if(is_array($menu_all)): $i = 0; $__LIST__ = $menu_all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			<td><?php echo ($vo["id"]); ?></td>
			<td><?php echo ($vo["sort_name"]); ?></td>
			<td>
			<a href="/index.php/Admin/Menu/add/pid/<?php echo ($vo["id"]); ?>">添加子菜单</a> | 
			<a href="/index.php/Admin/Menu/edit/id/<?php echo ($vo["id"]); ?>">编辑</a> | 
			<a href="/index.php/Admin/Menu/del/id/<?php echo ($vo["id"]); ?>">删除</a>
			</td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
</div>
</body>
</html>