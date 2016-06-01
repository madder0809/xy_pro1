<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    protected function _initialize(){
    	define(UID,getUid());
    	if(!UID){
    		$this->redirect("Log/index");
    	}
    	$role = $this->checkrule();
    	$menu = $this->getMenu();
    }
    //检测权限
    protected function checkrule(){

    }
    //检测可见菜单
    protected function getMenu(){

    }
}
?>
