<?php
namespace Home\Controller;
use Think\Controller;
class PlayController extends Controller{
	//资源点播
	public function index(){
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