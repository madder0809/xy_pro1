<?php

function is_login(){
    $admin_user = session('admin_user');
    if(!empty($admin_user)){
        return user_auth_sign($admin_user) == session('user_auth_sign') ? $admin_user['uid']:-1;
    }
    return -1;
}

function user_auth_sign($data){
	$code = http_build_query($data);
	return sha1($code);
}

function thinkMD5($key){
	return md5(md5($key) . "^&!@$#(_>:"|';~&-=AC&^');
}

//随机字符串
function getRandStr($length){
	$str = null;
	$source = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()_+<>?:{}|~.=-][';";
	$max = strlen($source)-1;

	for($i=0;$i<$length;$i++){
		$str.=$source[rand(0,$max)];
	}
	return $str;
}

function is_admin($uid=''){
	if(empty($uid)){
		$uid = session('admin_user.uid');

		define('ADMIN_ID', 1);
	}
	return $uid == ADMIN_ID;
}

/**
 * 把返回的数据集转换成Tree
 * @access public
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
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
            $parentId = $data[$pid];
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

function alert($msg){
        echo "<script>alert('{$msg}')</script>";
}

if( ! function_exists('array_column'))
{
  function array_column($input, $columnKey, $indexKey = NULL)
  {
    $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
    $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
    $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
    $result = array();
 
    foreach ((array)$input AS $key => $row)
    { 
      if ($columnKeyIsNumber)
      {
        $tmp = array_slice($row, $columnKey, 1);
        $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
      }
      else
      {
        $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
      }
      if ( ! $indexKeyIsNull)
      {
        if ($indexKeyIsNumber)
        {
          $key = array_slice($row, $indexKey, 1);
          $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
          $key = is_null($key) ? 0 : $key;
        }
        else
        {
          $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
        }
      }
 
      $result[$key] = $tmp;
    }
    return $result;
  }
}