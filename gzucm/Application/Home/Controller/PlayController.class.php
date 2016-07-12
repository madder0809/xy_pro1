<?php
namespace Home\Controller;
use Think\Controller;
class PlayController extends Controller{
	//资源点播
	public function index(){
	    $experiment_list = M('experiment')->where(array('type'=>1))->limit(6)->select();
	    $this->assign('experiment_list', $experiment_list);
	    
	    $video_subject_list = M('experiment')->where(array('type'=>2))->limit(6)->field('id,subject')->group('subject')->limit(3)->select();
	    
	    foreach ($video_subject_list as $key => $video){
	       $video_list = M('experiment')->where(array('type'=>2, 'subject' =>$video['subject']))->limit(4)->select();
	       $video_subject_list[$key]['video_list'] = $video_list; 
	    }
	    $this->assign('video_subject_list', $video_subject_list);
		$this->display();
	}

	public function search(){

	}

	public function upload(){
		if(IS_POST){
			$video_file = I("video_file");
			if(!$video_file) $this->error("请上传视频");
			$rules = array(
					array('subject','require','科目不能为空！', 1, 'regex', 3),
					array('class_name', 'require', '课程名称不能为空', 1, 'regex', 3),
			);
			$data = I();
			$data['release_man'] = cookie("uid") ? cookie("uid") : '';
			if(!$data['release_man']) $this->error("请先登录",U("Index/index"));
			$video_info = M('video_info');
			foreach ($video_file as $v){
				$video = explode(",",$v);
				$fileinfo['path'] = $video[0];
				$fileinfo['filename'] = $video[1];
				$video_id = $video_info->add($fileinfo);
				if($video_id) $video_id_list[] = $video_id;
			}
			$data['subject'] = $data['class_name'];
			$data['is_portal'] = 1;
			$data['video_id'] = implode(",",$video_id_list);
			$experiment = M('experiment');
			if($experiment->validate(rules)->create($data)){
				if($experiment->add()){
					$this->success("资源上传成功");
				}else{
					$this->error("上传失败");
				}
			}else{
				$this->error($experiment->getError());
			}
		}else{
			$this->display();
		}
		
	}


}
?>