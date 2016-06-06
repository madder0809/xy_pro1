<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
    protected function _initialize(){
    	define(UID,getUid());
    	if(!UID){
    		$this->redirect("Log/index");
    	}
    	$rule  = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
    	//exit($rule);
    	$role = $this->checkrule($rule);
    	if(!$role) $this->error("权限不足");
    	$menu = $this->getMenu();
    	$this->assign($menu);//可见的菜单列表
    }
    //检测权限
    protected function checkrule($rule, $type="", $mode='url'){
    	static $Auth    =   null;
        if (!$Auth) {
            $Auth       =   new \Think\Auth();
        }
        if(!$Auth->check($rule,UID,$type,$mode)){
            return false;
        }
        return true;
    }
    //检测可见菜单
    protected function getMenu(){
    	//主菜单
    	$menus['main'] = M("menu")->where("pid = 0 AND is_display = 1")->order("sort asc")->field("id,title,url")->select();
    	//权限判断
    	foreach ($menus['main'] as $k => $v) {
    		if(!$this->checkrule(strtolower(MODULE_NAME.'/'.$v['url'])))
    			unset($menus['main'][$k]);
    		if(strtolower(CONTROLLER_NAME.'/'.ACTION_NAME)  == strtolower($v['url']))
    		{
                $menus['main'][$k]['class']='current';
                $id = $v['id'];//当前主菜单ID
    		}
    	}

    	if(!$id){ //父级ID
            $url = strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);
            $r = M('menu')->where("lower(url) like '%{$url}%'")->field('t_pid')->find();
            $id = $r['t_pid'];
        }
    	$menus['nav'] = menu_sort($id);
		
    	foreach ($menus['nav'] as $k => $v) {
    		if(!$this->checkrule(strtolower(MODULE_NAME.'/'.$v['url'])))
    			//unset($menus['nav'][$k]);
    		if(strtolower(CONTROLLER_NAME.'/'.ACTION_NAME)  == strtolower($v['url']))
    		{
                $menus['nav'][$k]['class']='current'.$v['level'];
    		}
    	}
    	return $menus;
    }
}
?>
