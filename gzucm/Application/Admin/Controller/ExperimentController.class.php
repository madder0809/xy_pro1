<?php

namespace Admin\Controller;

class ExperimentController extends AdminController {
    
    private $rules = array(
        array('subject','require','科目不能为空！', 1, 'regex', 3),
        array('class_name', 'require', '课程名称不能为空', 1, 'regex', 3),
    );
    private $status = array("0"=>"未审核","1"=>"已审核");
    public function video(){
    	$param = I();
    	$where = array();
    	if($param['type']){
    		$where['type'] =  $param['type'];
    	}
    	
//     	if($param['username']){
//     		$where['au.username'] =  array('like', '%'.$param['username'].'%');
//     		$this->assign('adminusername', $param['username']);
//     	}
//     	if($param['auth_group']){
//     		$where['ag.title'] =  array('like', '%'.$param['auth_group'].'%');
//     		$this->assign('auth_group', $param['auth_group']);
//     	}

	    $count = M('experiment')->where($where)->count();
	    $page = new \Think\Page($count,1);
	    $this->assign('_page', $page->show());
	     
	    $experiment_list = M('experiment')->where($where)->select();
	    $this->assign('experiment_list', $experiment_list);
	    $type = I('type');
    	$this->assign('type', $type);
        $this->assign('status',$this->status);
        $this->display();
    }


    public function add(){
        $type = I('type');
    	if(IS_POST){
    	    $video_file = I('video_file');
    	    if(!$video_file){
    	        $this->error('附件不能为空');
    	    }else{
                foreach ($_POST['video_file'] as $video){
                    $video = explode(',', $video);
                    $fileinfo['path'] = $video[0];
                    $fileinfo['filename'] = $video[1];
                    $video_id = M('video_info')->add($fileinfo);
                    $video_id_list .= $video_id.',';
                }
                $video_id_list = rtrim($video_id_list, ',');
                $_POST['video_id'] = $video_id_list;
    	    }
    	    
    	    $experiment = M('experiment');
    	    if($experiment->validate($this->rules)->create()){
    	        $uid = $experiment->add();
    	        if($uid){
    				$this->success('实验课程添加成功', U('video',array('type'=>$type)));
    	        }else{
    				$this->error('实验课程增加失败');
    	        }
    	    }else{
    	        $this->error($experiment->getError());
    	    }
    	}else{
    	    $this->assign('type', $type);
            $this->assign('status',$this->status);
    	    $this->assign('sessionid', session_id());
			$this->ajaxReturn($this->fetch('edit'));
    	}
    }
    
    public function edit(){
        $type = I('type');
        
        $id = I('id');
        if(empty($id)){
            $this->error('出错了');    
        }
        
        if(IS_POST){
            $video_file = I('video_file');
            if(!$video_file){
                $this->error('附件不能为空');
            }else{
                foreach ($_POST['video_file'] as $video){
                    $video = explode(',', $video);
                    $fileinfo['path'] = $video[0];
                    $fileinfo['filename'] = $video[1];
                    $video_id = M('video_info')->add($fileinfo);
                    $video_id_list .= $video_id.',';
                }

                $video_id_list = rtrim($video_id_list, ',');
                $_POST['video_id'] = $video_id_list;
            }
            $experiment = M('experiment');
            if($experiment->validate($this->rules)->create()){
                if($experiment->save() !== fasle){
                    $this->success('实验课程编辑成功', U('video',array('type'=>$type)));
                }else{
                    $this->error('实验课程编辑失败');
                }
            }else{
                $this->error($experiment->getError());
            }
        }else{
            $experiment = M('experiment')->where(array('id'=>$id))->find();
            $video_list = M('video_info')->where(array('id'=>array('in',$experiment['video_id'])))->select();
            $this->assign('video_list', $video_list);
            $this->assign('id', $id);
            $this->assign('type', $type);
            $this->assign('status',$this->status);
            $this->assign('experiment', $experiment);
            $this->ajaxReturn($this->fetch('edit'));
        }
    }

}
?>