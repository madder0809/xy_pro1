<?php
namespace Home\Controller;
use Think\Controller;
class LibController extends Controller{
	//仪器使用预约
	public function index(){
		$this->display();
	}
	//预约查询
	public function orderSearch(){
		$this->display();
	}
	//综合设计性实验安排 Experimental Arrangemen
	public function expArr(){
		$this->display();
	}
	//综合设计性实验查询
	public function expArrSearch(){
		$this->display();
	}
	//创新性实验安排 innovation Experimental Arrangemen
	public function inExpArr(){
		$this->display();
	}
	//创新性实验查询
	public function inExpArrSearch(){
		$this->display();
	}
}
?>