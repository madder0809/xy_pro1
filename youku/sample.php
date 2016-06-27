<?php

/*****YoukuUpload SDK*****/
header('Content-type: text/html; charset=utf-8');
include("include/YoukuUploader.class.php");

$client_id = "1fda71f1947edbe0"; // Youku OpenAPI client_id
$client_secret = "fb57dace4c73cfd5c2ecb1673aa488f2"; //Youku OpenAPI client_secret

/*
**The way with username and password applys to the partner level clients!
**Others may use access_token to upload the video file.
**In addition, refresh_token is to refresh expired access_token. 
**If it is null, the access_token would not be refreshed.
**You may refresh it by yourself.
**Like "http://open.youku.com/docs/api/uploads/client/english" for reference.
*/

$params['access_token'] = "b493986f5a0a302178787598fd06dc35"; 
$params['refresh_token'] = "93879e32c23b952c6be64fd4202a85c7";
$params['username'] = "madder0809@163.com"; //Youku username or email
$params['password'] = md5("shai1267"); //Youku password

set_time_limit(0);
ini_set('memory_limit', '128M');
$youkuUploader = new YoukuUploader($client_id, $client_secret);
$file_name = "1213.mp4"; //video file

try {
    $file_md5 = @md5_file($file_name);
    if (!$file_md5) {
        throw new Exception("Could not open the file!\n");
    }
}catch (Exception $e) {
    echo "(File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
    return;
}

$file_size = filesize($file_name);
$uploadInfo = array(
		"title" => "test", //video title
		"tags" => "test", //tags, split by space
		"file_name" => $file_name, //video file name
		"file_md5" => $file_md5, //video file's md5sum
		"file_size" => $file_size //video file size
);
$progress = true; //if true,show the uploading progress 
$r = $youkuUploader->upload($progress, $params,$uploadInfo); 
var_dump($r);
?>
