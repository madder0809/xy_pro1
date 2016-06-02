<?php

function getUid(){
	return 1;
}

function menu_sort($parent_id=0,$t=-1,$type='str')
{
	static $_menu = array();
	$t++;
	$where = array("pid"=>$parent_id,"is_display"=>1);
	$query = M("menu")->where($where)->order('pid ASC')->select();
	if($query)
	{
		foreach ($query as $key => $val )
		{
			if($val['pid']!=0)
			{
				$val['level'] = $t;
				$replace = $type=='str' ? '&nbsp' : ' ';
				$val['sort_name'] = str_repeat($replace,$t*3).'┝'.$val['title'];
			}else{
				$val['sort_name'] = $val['title'];
			}
			$_menu[] = $val;
			menu_sort($val['id'],$t);
		}
		return $_menu;
	}
}

function get_top_parent_id($id){
	
}
?>