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
    	$role = $this->checkrule($rule);
    	//if(!$role) $this->error("权限不足");
    	$menu = $this->getMenu();
    	$this->assign($menu);
    }
    //检测权限
    protected function checkrule($rule, $type="", $mode='url'){
    	static $Auth    =   null;
        if (!$Auth) {
            $Auth = new \Think\Auth();
        }
        if(!$Auth->check($rule,UID,$type,$mode)){
            return false;
        }
        return true;
    }

    //检测可见菜单
    protected function getMenu($controller=CONTROLLER_NAME){
    	//主菜单
        $menus['main'] = M("menu")->where("pid = 0 AND is_display = 1")->order("sort ASC")->select();
        
        $menus['child'] = array();
         foreach ($menus['main'] as $key => $item) {
                // 判断主菜单权限
                if (!$this->checkrule(strtolower(MODULE_NAME.'/'.$item['url']))) {
                    unset($menus['main'][$key]);
                    continue;//继续循环
                }
                if(strtolower(CONTROLLER_NAME.'/'.ACTION_NAME)  == strtolower($item['url'])){
                    $menus['main'][$key]['class']='current';
                }
            }
        $menu_url = strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);
        //当前菜单ID
        $id = M('menu')->where("LOWER(url) = '{$menu_url}'")->getField('id');
        //子菜单
        if($child_menu = M('menu')->where("pid = {$id}")->select()){
            
        }else{
            
        }
        return $menus;
    }
}
?>
