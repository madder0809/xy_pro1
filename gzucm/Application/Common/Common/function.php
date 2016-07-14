<?php 


function makeCover($path){
    if(empty($path)){
        return "";
    }

    $dir .= './Uploads/video_cover/';
    if(!is_dir($dir)) {
        mkdir($dir, '0777');
    }

    $video_filename = basename($path);
    $pos = strrpos ($video_filename, '.');
    $cover_path = $dir . substr($video_filename, 0, $pos).".png";

    $ffmpegInstance = new \ffmpeg_movie('d:\\wamp\\www\\gzucm\\Uploads\\video\\'.$video_filename);
    if($ffmpegInstance){
        $ff_frame = $ffmpegInstance->getFrame(5);
        $gd_image = $ff_frame->toGDImage();
        imagejpeg($gd_image, $cover_path);
        imagedestroy($gd_image);
        return $cover_path;
    }
    return "";
}