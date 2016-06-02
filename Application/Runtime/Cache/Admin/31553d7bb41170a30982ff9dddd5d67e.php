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

	<form action="/index.php/Admin/Menu/add" method="post">
		<p>菜单名称:<input type="text" name="title" value=""></p>
		<p>
		上级菜单:
		<select name="pid">
			<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id']==$_GET['pid']) echo "selected=true" ?>><?php echo ($vo["sort_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		</p>
		<p>
			控制器:<input type="text" name="cotroller">
		</p>
		<p>方法:<input type="text" name="function"></p>
		<p>参数:<input placeholder="示例:?a=bbbccc" type="text" name="param"></p>
		<p>排序:<input type="text" name="sort" value="0"></p>
		<p>是否显示:
			<input type="radio" name="student" value="1" checked="checked" />显示
			<input type="radio" name="student" value="0"/>隐藏
		</p>
		<p>备注:<input type="text" name="remark" value=""></p>
		<p><input type="submit" name="submit" value="提交"></p>
	</form>
</div>
</body>
</html>