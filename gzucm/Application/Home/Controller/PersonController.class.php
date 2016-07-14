<?php
namespace Home\Controller;
use Think\Controller;
class PersonController extends Controller{
	protected function _initialize(){
		$this->uid = cookie("uid") ? cookie("uid") : "";
		if(!$this->uid) $this->error("请先登陆");
	}
	//个人中心
	public function index(){
		$uid = $this->uid;
		if(IS_POST){
			$data = I();
			if(!$data['password']) $this->error("请输入账户密码");
			$user_model = D("user");
			$user = $user_model->find($uid);
			if(!md5($data['password'])==$user['password']) $this->error("输入密码有误");
			unset($data['password']);
			if($user_model->create($data)){
				if($user_model->save($data)){
					$this->success("修改成功",U("index"));
				}else{
					$this->error("修改失败");
				}
			}else{
				$this->error($user_model->getError());
			}
		}else{
			$data['info'] = $info = M("user")->find(cookie("uid"));
			$region = M("region");
			$data['fir_na'] = $region->where("father_id = 0")->select();
			$data['sec_na'] = $region->where("father_id = {$info['fir_na']}")->select();
			$this->assign($data);
			$this->display();
		}
	}

	public function pwdChange(){
		$uid = $this->uid;
		if(IS_POST){
			$user = D("user");
			$info = $user->find($uid);
			$data = I();
			if(md5($data['oldpwd'])!=$info['password']) $this->error("旧密码错误,修改失败");
			$data['password'] = md5($data['password']);
			$data['confirm_pwd'] = md5($data['confirm_pwd']);
			if($user->create($data)){
				if($user->save($data)){
					$this->success("修改成功",U("Person/pwdChange"));
				}else{
					$this->error("修改失败");
				}
			}else{
				$this->error($user->getError());
			}
		}else{
			$this->assign("uid",$uid);
			$this->display();
		}
	}

	public function myUpload(){
		$uid = $this->uid;
		$experiment = M("experiment");
		$data['count'] = $experiment->where("release_man = {$uid} AND is_portal = 1")->count();
		$Page = new \Think\Page($data['count'],2);
		$data['_page'] = $Page->show();
		$data['list'] = $experiment->where("release_man = {$uid} AND is_portal = 1")
				->limit($Page->firstRow.','.$Page->listRows)->order("id DESC")->select();
		$video = M("video_info");
		foreach($data['list'] as $k =>$v){
			$data['list'][$k]['cover'] = $video->where("eid = {$v['id']}")->getField("cover_path");
		}
		$data['status']=array("0"=>"正在等待审核","1"=>"已通过审核","2"=>"未通过审核");
		$this->assign($data);
		$this->display();
	}

	public function uploadRemove(){
		$id = I("id");
		if($id){
			if(M("experiment")->delete($id)){
				$this->success("删除成功",$_SERVER['HTTP_REFERER']);
			}else{
				$this->error("删除失败");
			}
		}
	}
	
	public function saveToDb(){
		$instrument = M("instrument");
		$list = M("instrument")->field("name")->select();//仪器列表
		$test_instrument = M("test_instrument");
		foreach ($list as $k=>$v){
			if(!$test_instrument->where("iname = '{$v['name']}'")->count()){
				$data['iname']=$v['name'];
				$data['is_test'] = 1;
				$data['order'] = 1;
				$data['tid'] = 0;
				$test_instrument->add($data);
				unset($data);
			}
		}
	}
}
?>