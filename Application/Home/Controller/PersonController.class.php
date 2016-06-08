<?php
namespace Home\Controller;
use Think\Controller;
class PersonController extends Controller{
	protected function _initialize(){
		if(!cookie("uid")){
			$this->display("log");
			exit();
		}
		
	}
	//个人中心
	public function index(){
		//$info = M("user")->where
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