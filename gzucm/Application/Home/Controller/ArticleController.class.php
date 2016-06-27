<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller{
	public function _initialize(){
		$this->type = I("type");
		if(!$this->type) $this->error("找不到文章");
	}
	//成果展示,科研成果
	public function index(){
		$count = M("article")->where("type = {$this->type} AND status = 1")->count();
		if($count > 1){
		$list = M("article")->where("type = {$this->type} AND status = 1")->order("id DESC")->select();
			$this->a_list($list);
		}elseif($count = 1){
			$id = M("article")->where("type = {$this->type} AND status = 1")->order("id DESC")->getField("id");
			$this->view($id);
		}
	}
	
	public function a_list($list){
		$this->assign("list",$list);
		$this->display("a_list");
	}

	//只有一篇文章列表
	public function list_view($id){
		$this->assign($info);
		$this->display("view");
	}

	public function view($id){
		$id = $id?$id:I("id");
		if(!$id){
			$this->error("没找到该文章");
		}
		$info = M("article")->find($id);
		$this->assign($info);
		$this->display("view");
	}
}
?>