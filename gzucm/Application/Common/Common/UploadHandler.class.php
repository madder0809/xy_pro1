<?php
class UploadHandler {
    
    public function upload() {

        import('Org.Net.UploadFile');
        $upload = new \UploadFile();
        $upload->maxSize  = 1024*1024*1000 ;// 设置附件上传大小
        $upload->allowExts  = array('mp4','jpg');// 设置附件上传类型
        $upload->savePath =  $this->getSaveDir();
        if(!$upload->upload()) {
            exit($upload->getErrorMsg());
        }else{
            $uploadFileInfo = $upload->getUploadFileInfo();
            $uploadFileInfo = $uploadFileInfo[0];
            $path = $uploadFileInfo['savepath'].$uploadFileInfo['savename'];
            
            //filename带文件路径，name原文件名
            return array('path'=>$path, 'filename'=>$uploadFileInfo['name']);
        }
        return false;
    }
    
    // 建立目录   /Uploads/Excel/
    function getSaveDir(){
        $dir = "./Uploads";
        if(!is_dir($dir)) {
            if(!mkdir($dir, '0777')){
                $this->error("上传目录 ".$dir." 不存在！");
            }
        }
        $dir .= '/video/';
        if(!is_dir($dir)) {
            if(!mkdir($dir, '0777')){
                $this->error("上传目录 ".$dir." 不存在！");
            }
        }
        return $dir;
    }
    
}