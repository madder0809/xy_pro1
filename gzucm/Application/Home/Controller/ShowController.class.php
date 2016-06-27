<?php
namespace Home\Controller;
use Think\Controller;
class ShowController extends Controller{
	public $type = 2;//成果展示
	//成果展示,科研成果
	public function index(){
		$list = M("article")->where("type = {$this->type}")->field("id,title")->select();
		$this->assign("list",$list);
		$this->display();
	}
	
	public function view(){
		$id = I("id");
		if(!$id){
			$this->error("没找到该文章");
		}
		$info = M("article")->find($id);
		$this->assign($info);
		$this->display();
	}
}
?>