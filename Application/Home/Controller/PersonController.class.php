<?php
namespace Home\Controller;
use Think\Controller;
class PersonController extends Controller{
	protected function _initialize(){
		if(!cookie("uid")){ //判断是否登陆
			$this->display("log");
			exit();
		}
	}
	//个人中心
	public function index(){
		$info = M("user")->find(cookie("uid"));
		$this->assign($info);
		$this->display();
	}

	public function pwdChange(){
		$this->display();
	}

	public function myUpload(){
		$this->display();
	}

}
?>