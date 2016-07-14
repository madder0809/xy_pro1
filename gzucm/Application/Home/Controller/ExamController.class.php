<?php
namespace Home\Controller;
use Think\Controller;
class ExamController extends Controller{
	//安全考试
	public function index(){
		$iname = I("iname");
		if($iname){
			//试题列表
			$test = M("test_instrument")->where("iname = '{$iname}'")->find();
			if($test['tid']){//有试题,测验
				$data['list'] = $this->getExamList($test['order'],M("test")->where("id IN ({$test['tid']})")->select());
			}else{//没有试题,提交预订
				$this->appointment();
				exit();
			}
		}else{
			//随机抽取试题
			$list = M("test")->select();
			$data['list'] = $this->getExamList(2,$list);
		}
		$this->assign($data);
		$this->display();
	}
	public function checkExam(){
		if(IS_POST){
			$data = I();
			$test = M("test");
			foreach ($data['t'] as $k=>$v){
				$tmp = $ans['ans'][] = $test->where("id = {$v}")->getField("answer");
				$ans['is_ans'][] = $tmp == $data['t_a'][$k];
			}

			if($ans['is_ans'][0] && $ans['is_ans'][1]){
				if(session("_appointment")){
					$this->appointment();
					exit();
				}
				$this->success("答题成功");
			}else{
				$this->ajaxReturn($ans['ans']);
			}
		}
	}

	private function appointment(){
		$data = session("_appointment");
		session("_appointment",null);
		if($data){
			if(M('appointment')->add($data)){
				$this->success("预约成功",U("Lib/index"));
			}else{
				$this->success("预约失败");
			}
		}
	}

	private function getExamList($order,$list){
		if(count($list)>2){
			if($order==1){//顺序答题
				$arr = array($list[0],$list[1]);
			}else{//随机答题
				$rand_keys = array_rand($list, 2);
				$arr = array($list[$rand_keys[0]],$list[$rand_keys[1]]);
			}
			return $arr;
		}else{
			return $list;
		}
	}
}
?>