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
			$data = I();
/*			$video = $_FILES['video'];
			var_dump($video);
			exit();*/
			$video = $data['file_name'];
			import('Vendor.Youku.VideoUpload');
			$upload = new \VideoUpload();
			try {
			    $file_md5 = @md5_file($video);
			    if (!$file_md5) {
			        throw new \Exception("Could not open the file!\n");
			    }
			}catch (\Exception $e) {
			    echo "(File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			    return;
			}
			$file_name = $video;
			$file_size = filesize($video);
			$uploadInfo = array(
				"title" => $data['title'], //video title
				"tags" => "test", //tags, split by space
				"file_name" => $file_name, //video file name
				"file_md5" => $file_md5, //video file's md5sum
				"file_size" => $file_size //video file size
			);
			$upload->upload($video,$uploadInfo);
		}else{
			$this->display();
		}
		
	}


}
?>