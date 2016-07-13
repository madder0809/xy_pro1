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
		$article = M("article");
		$info = $article->find($id);
		$this->assign($info);
		$article->where("id = {$id}")->setInc('views');//浏览数自增
		//点击排序
		$views_list = $article->where("status = 1")->field("id,title,views")->order("views DESC")->limit(10)->select();
		$this->assign("views_list",$views_list);
		$this->display();
	}
}
?>