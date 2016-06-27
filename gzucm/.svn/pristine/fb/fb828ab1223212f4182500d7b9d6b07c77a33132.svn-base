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
		$fir_na = M("region")->where("father_id = 0")->select();
		$sec_na = M("region")->where("region_code = {$info['sec_na']}")->find();
		$this->assign("fir_na",$fir_na);
		$this->assign("sec_na",$sec_na);
		$this->assign("info",$info);
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