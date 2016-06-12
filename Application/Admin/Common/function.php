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

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}


?>