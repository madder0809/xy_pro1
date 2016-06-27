<?php
namespace Admin\Controller;
use Think\Controller;

class AdminController extends Controller {
    
    function _initialize(){
        if(is_login() < 0 ){
            $this->redirect('Public/login');
        }
        
        $uid = session('admin_user.uid');
        $username = session('admin_user.username');
        
    	$Auth = new \Think\Auth();
        if(!is_admin()){
        	$a = (strtolower(CONTROLLER_NAME) !=='index') && (strtolower(ACTION_NAME) !== 'index');
        	if(!(strtolower(CONTROLLER_NAME) =='index') && (strtolower(ACTION_NAME) == 'index')){
        		//访问权限
        		if(!$Auth->check(CONTROLLER_NAME.'/'.ACTION_NAME, $uid,1)){
        			$this->error('未授权访问！');
        		}
        	}
        }
        $this->getMenu();
        
        $group_name = M('auth_group_access aga')
            ->join(' auth_group ag on ag.id = aga.group_id')
            ->where(array('aga.uid'=>$uid))
            ->getField('title');
        $this->assign('group_name', $group_name);
        
        $this->assign('username', $username);
    }
    
    function getMenu(){
        $uid = session('admin_user.uid');
//     	$menus = session('menus_'.CONTROLLER_NAME.'_'.ACTION_NAME.$uid);
    	if(!$menus){
    	    $Auth = new \Think\Auth();
    	    $uid = session('admin_user.uid');
    	    $menus = M('auth_menu')->order("id asc, sort desc")->getField('id,name,title,pid');
    	    foreach ($menus as $key => $menu){
    	        if(!is_admin() && !$Auth->check($menu['name'], $uid, 1, null)){
    	            unset($menus[$key]);
    	        }
    	    }
    	    
    	    $menus = list_to_tree($menus);
    	    foreach ($menus as $key => $menu){
    	        $menus[$key]['name'] = $this->getFirstUrl($menu);   // 第一个有效url
    	    
    	        $root_id = $this->getRoot();                        // 顶层节点
    	        if($menu['id'] == $root_id){
    	            $menus[$key]['selected'] = 'selected';
    	            $this->assign('_menu', $menus[$key]['_child']);
    	        }
    	    }
    	}
        
        $this->assign('_nav_list', $menus);
    }
    
    function getRoot($id=''){
        if(empty($id)){
            $menu = M('auth_menu')->where("name like '%".CONTROLLER_NAME."%'")->field('id,pid,title')->find();
            if($menu['pid'] == 0){
                return $menu['pid'];
            }else{
                $id = $menu['id'];
            }
        }
        
        $menu = M('auth_menu')->where(array('id'=>$id))->field('id,pid,title')->find();
        if($menu['pid'] == 0){
            return $menu['id'];
        }else{
            return $this->getRoot($menu['pid']);
        }
    }
    
    function getFirstUrl($menu){
        if($menu['name'] == '#node'){
            return $this->getFirstUrl(reset($menu['_child']));
        }else{
            return $menu['name'];
        }
    }
    
    function getMenu1(){
    	$uid = session('admin_user.uid');
    	
//     	$nav_list = session('nav_'.CONTROLLER_NAME.'_'.ACTION_NAME.$uid);
    	if(empty($nav_list)){
    	    $Auth = new \Think\Auth();
    	    $nav_list = M('auth_menu')->where(array('pid'=>0))->order("id asc, sort desc")->getField('id,name,title,pid');
            foreach ($nav_list as $key => $nav){
    	        if( !$Auth->check($nav['name'], $uid,1, null)){	//验证一级菜单的权限
    	            unset($nav_list[$key]);
    	        }else{
    	            $second_menu = M('auth_menu')->where(array('pid'=>$nav['id']))->order("id asc, sort desc")->getField('id,name,title,pid');
    	            foreach ($second_menu as $key_second => $second){
    	                if(!is_admin() && !$Auth->check($second['name'], $uid, 1, null)){		//验证二级菜单的权限
    	                    unset($second_menu[$key_second]);
    	                }else{
    	                    $third_menu = M('auth_menu')->where(array('pid'=>$second['id']))->order("id asc, sort desc")->getField('id,name,title,pid');
    	                    foreach ($third_menu as $key_third => $third){
    	                        if(!is_admin() && !$Auth->check($third['name'], $uid, 1, null)){		//验证三级菜单的权限
    	                            unset($third_menu[$key_third]);
    	                        }else{
    	                        	if($nav_list[$key]['name'] == '#node'){
    	                        		$nav_list[$key]['name'] = $third['name'];		//三级菜单的第一个name替换一级菜单的name    	                        		
    	                        	}
    	                        }
    	                    }
    	                    $second_menu[$key_second]['_child'] = $third_menu;
    	                    
    	                    if($nav_list[$key]['name'] == '#node'){
    	                        $nav_list[$key]['name'] = $second['name'];		//二级菜单的第一个name替换一级菜单的name    	                        		
    	                    }
    	                }
    	            }
    	            
    	             if($nav_list[$key]['name'] == '#node'){
    	             	$nav_list[$key]['name'] = 'Public/empty_menu';		//替换一级菜单的name    	                        		
    	             }
    	            
    	            $nav_list[$key]['_child'] = $second_menu;
    	        }
    	    
    	    }
    	    session('nav_'.CONTROLLER_NAME.'_'.ACTION_NAME.$uid, $nav_list);
    	}
        
//     	$nav_id = session('nav_id_'.CONTROLLER_NAME.'_'.ACTION_NAME.$uid);
        if(empty($nav_id)){
            $nav_id = M('auth_menu')->where("name like '%".CONTROLLER_NAME."/".ACTION_NAME."%'")->getField('pid');
            $menu = $nav_list[$nav_id]['_child'];
            if(!$menu){
                $nav_id = M('auth_menu')->where(array('id'=>$nav_id))->getField('pid');
            }
            session('nav_id_'.CONTROLLER_NAME.'_'.ACTION_NAME.$uid, $nav_id);
        }
        
        $nav_list[$nav_id]['selected'] = 'selected';
        $this->assign('_nav_list', $nav_list);

    	$this->assign('_menu', $nav_list[$nav_id]['_child']);
    }
}