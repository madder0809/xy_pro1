<?php
namespace Admin\Controller;

class UserController extends AdminController {
	//用户列表
    public function index(){
    	$user = M('user')->order("id ASC")->select();
    	$this->assign("user",$user);
        $this->display();
    }
    //添加用户
    public function add(){
		$this->display();
    }
    //编辑用户
    public function edit(){
    	$this->display();
    }
    //删除
    public function del(){
    	$this->display();
    }

}