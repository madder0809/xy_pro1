<?php
namespace Home\Controller;
use Think\Controller;
class LibController extends Controller{
	private $validate = array(
			array('uid','require','请先登陆'),
			array('starttime', 'require', '名称不能为空'),
			array('endtime', 'require', '结束时间不能为空'),
			array('iname', 'require', '实验室仪器不能为空'),
			array('iid', 'require', '仪器编号不能为空'),
			array('starttime','endtime','开始时间必须小于结束时间',1,'lt')
	);
	//仪器使用预约
	public function index(){
		if(IS_POST){
			$data = I();
			$appointment = M("appointment");
			if($appointment->validate($this->validate)->create()){
				if($appointment->add($data)){
					$this->success("预约成功",U("index"));
				}else{
					$this->success("预约失败");
				}
			}else{
				$this->error($appointment->getError());
			}
		}else{
			$data['uid'] = cookie("uid") ? cookie("uid") : '';
			if($data['uid']){
				$data['i_list'] = M("instrument")->cache(true)->distinct(true)->field("name")->select();//仪器列表
				$this->assign($data);
				$this->display();
			}else{
				$this->error("请先登陆",U("Home/Index/index"));
			}

		}

	}
	//预约查询
	public function orderSearch(){
		$data = I();
		$data['uid'] = cookie("uid") ? cookie("uid") : '';
		if(! $data['uid']){
			$this->error("请先登陆",U("Home/Index/index"));
		}
		$where = "a.uid = {$data['uid']}";
		$where .= $data['iname'] ? " AND i.name='{$data['iname']}'" : "";
		$where .= $data['status']!=="0" ? "" : " AND a.status={$data['status']}";
		$data['i_list'] = M("instrument")->distinct(true)->field("name")->select();//仪器列表
		$data['status'] = array("-1"=>"未通过","0"=>"未审核","1"=>"已通过");
		$count = M("appointment a")->join("left join instrument i on a.iid = i.id")
				->join("left join laboratory l on i.lab_id = l.id")->where($where)->count();
		$Page = new \Think\Page($count,3);
		$data['_page'] = $Page->show();
		$data['list'] = M("appointment a")->join("left join instrument i on a.iid = i.id")
						->join("left join laboratory l on i.lab_id = l.id")
						->limit($Page->firstRow.','.$Page->listRows)->order("a.id DESC")
						->where($where)->field("a.*,i.name,i.number,l.address,i.table_no")->select();
		$this->assign($data);
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

	public function getInum(){
		$data = I();
		if($data['name']){
			$this->ajaxReturn(M('instrument')->where($data)->field("id,number")->select());
		}
	}
}
?>