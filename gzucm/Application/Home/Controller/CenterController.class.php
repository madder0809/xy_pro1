<?php
namespace Home\Controller;
use Think\Controller;
class CenterController extends Controller{
	public $type_name = array(3=>"中心概况",4=>"中心师资",5=>"规章制度"); 

	public function _initialize(){
		$this->type = I("type") ? I("type") : "3";//默认是中心概况
		if(!$this->type) $this->error("找不到文章");
	}

	//中心概况
	public function index(){
		$count = M("article")->where("type = {$this->type} AND status = 1")->count();
		$data['type'] = $this->type;
		$data['type_name'] = $this->type_name;
		if($count > 1){
			$data['list'] = M("article")->where("type = {$data['type']} AND status = 1")->order("id DESC")->select();
			$this->assign($data);
			$this->a_list($data['list']);
		}elseif($count = 1){
			$data['article'] = M("article")->where("type = {$data['type']} AND status = 1")->order("id DESC")->find();
			$this->assign($data);
			$this->view($article);
		}
	}
	
	public function view($article){
		if(!$article){
			
		}
		$this->display("view");
	}

	public function a_list(){
		$this->display("list");
	}


}
?>