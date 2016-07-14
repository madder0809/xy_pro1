<?php
namespace Home\Controller;
use Think\Controller;
class PlayController extends Controller{
	//资源点播
	public function index(){
	    
	    //主要实验课程
	    $experiment_list = M('experiment')->where(array('type'=>1, 'status'=>1))->limit(6)->select();
	    $this->assign('experiment_list', $experiment_list);
	    
	    //实验视频
	    $video_subject_list = M('experiment')->where(array('type'=>2, 'status'=>1))->field('id,subject')->group('subject')->limit(3)->select();
        foreach ($video_subject_list as $key => $list){
            $video_list = M('experiment e')->join('video_info vi on vi.eid = e.id')->where(array('type'=>2, 'status'=>1, 'subject'=>$list['subject']))->limit(4)->select();
            $video_subject_list[$key]['video_info'] = $video_list;
        }
		$this->assign('video_subject_list', $video_subject_list);
		
		//点击排序
		$views_list = M("article")->where("status = 1")->field("id,title,views")->order("views DESC")->limit(10)->select();
		$this->assign("views_list",$views_list);
		$this->display();
	}

	public function search(){

	}
	
	
	//更多
	function more(){
	   $type = I('type');
	   
	   $where['type'] = $type;
	   
	   if($type == 1){
           //主要实验课程
           
	       $experiment_id_list = M('experiment')->where($where)->field('id')->select();
	       foreach ($experiment_id_list as $list){
	           $experiment_id_str .= $list['id'].',';
	       }
	       $experiment_id_str = rtrim($experiment_id_str, ',');
	       
	       $count = M('video_info vi')->where(array('eid'=>array('in', $experiment_id_str)))
	           ->join("experiment e on e.id = vi.eid")->count();
	       $Page = new \Think\Page($count,15);
	       $this->assign('_page', $Page->show());
	       
	      
	       $video_info_list = M('video_info vi')->where(array('eid'=>array('in', $experiment_id_str)))->field('e.class_name,vi.*')
	           ->join("experiment e on e.id = vi.eid")
	           ->limit($Page->firstRow.','.$Page->listRows)->select();
	       
	       foreach ($video_info_list as $key=>$list){
	           $pos = strrpos($list['filename'], '.');
	           $video_info_list[$key]['class_name'] = substr($list['filename'], 0, $pos);
	       }
	       
	       $this->assign('subject', "主要实验视频");
	   }else{
	       //实验视频
	       $subject = I('subject');
	       
	       $where['subject'] = $subject;
	       
	       $count = M('experiment e')->join('video_info vi on vi.eid = e.id')->where($where)->count();
	       $Page = new \Think\Page($count,15);
	       $this->assign('_page', $Page->show());
	       
	       $video_info_list = M('experiment e')->join('video_info vi on vi.eid = e.id')
               ->where($where)->field('e.class_name,e.id eid,vi.*')
               ->limit($Page->firstRow.','.$Page->listRows)
	           ->select();
            
	       $this->assign('subject', $subject);
	   }
	   
	   $this->assign('type', $type);
	   $this->assign('video_info_list', $video_info_list);
	   $this->assign('list_size', count($video_info_list));
	   $this->display();
	}
	
	function player(){
	    $id = I('id');
	    if(!empty($id)){
	       $type = I('type');
	       $this->assign('type', $type);
	       
	       if($type == 1){
	           
	       }
	       
           $experiment = M('experiment')->where(array('type'=>$type, 'id'=>$id))->find();
           $this->assign('experiment', $experiment);
           
           //相关课程推荐
           $recommend_list = M('experiment')->where(array('subject'=>$experiment['subject'], 'id'=>array('neq', $experiment['id'])))->limit(2)->select();
           foreach ($recommend_list as $key => $list){
               $video_list = M('video_info')->where(array('eid'=>$list['id']))->find();
               $recommend_list[$key]['cover_path'] = $video_list['cover_path'];
           }
           $this->assign('recommend_list', $recommend_list);
           

               $video_list = M('video_info')->where(array('eid'=>$id))->select();
               foreach ($video_list as $key=>$list){
                   $pos = strrpos($list['filename'], '.');
                   $video_list[$key]['filename'] = substr($list['filename'], 0, $pos);
               }
               $this->assign('video_list', $video_list);
               $this->display();

	    }else{
	        $this->error('出错了');
	    }
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

			$data['subject'] = $data['class_name'];
			$data['is_portal'] = 1;
			$data['release_time'] = date("Y-m-d");
			$data['type'] = 1;
			//$data['video_id'] = implode(",",$video_id_list);
			$experiment = M('experiment');
			if($experiment->validate($rules)->create($data)){
				if($eid = $experiment->add()){
					$video_info = M('video_info');
					foreach ($video_file as $v){
						$video = explode(",",$v);
						$fileinfo['path'] = $video[0];
						$fileinfo['filename'] = $video[1];
						$fileinfo['eid'] = $eid;
						$fileinfo['cover_path'] = makeCover($fileinfo['path']);
						$video_info->add($fileinfo);
					}
					$this->success("资源上传成功");
				}else{
					$this->error("上传失败");
				}
			}else{
				$this->error($experiment->getError());
			}
		}else{
			//分类列表
			$i_list = M("instrument")->cache(true)->distinct(true)->field("name")->select();//仪器列表
			$this->assign("i_list",$i_list);
			$this->display();
		}
		
	}


}
?>