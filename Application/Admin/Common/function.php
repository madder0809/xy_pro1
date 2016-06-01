<?php

function getUid(){
	return 1;
}

function menu_sort($parent_id=0,$t=-1,$level="0")
{
	static $_menu = array();
	$t++;
	$query = M("menu")->where("pid = {$parent_id}")->select();
	if($query)
	{
		foreach ($query as $key => $val )
		{
			if($val['pid']!=0)
			{
				$val['level'] = $t;
			}
			$_menu[] = $val;
			menu_sort($val['id'],$t);
		}
		return $_menu;
	}
}

?>