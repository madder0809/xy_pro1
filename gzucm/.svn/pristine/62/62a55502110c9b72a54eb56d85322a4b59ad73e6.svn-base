<?php

namespace Admin\Controller;
class NoticeController extends AdminController {
    //public $type = array(1=>"文字",2=>"图文");
    public $status = array(0=>"未审核",1=>"已通过",2=>"未通过");
    public $type = 1;//通知公告
    #通知公告
    public function index(){
        $title = I("title");
        $where = "type = {$this->type}";
        $where .= $title ? " AND title like '%{$title}%'" :"";
        $notice_list = M("article")->where($where)->order('publishtime DESC')->select();
        $data['type'] =  $this->type;
        $data['status'] = $this->status;
        $data['notice_list'] = $notice_list;
        $data['title'] = $title;
        $this->assign($data);
        $this->display();
    }

    #发布
    public function add(){
        if(IS_POST){
            M("article")->create();
            $this->success("发布成功",U("index"));
        }else{
            $data['type'] = $this->type;
            $data['status'] = $this->status;
            $this->assign($data);
            $this->display('edit');
        }
    }

    #编辑
    public function edit(){
        $id = I("id");
        if(!$id){
            $this->error("出错了");
        }
        if(IS_POST){
            M("article")->create();
            if(M("article")->save()){
                $this->success("编辑成功",U("index"));
            }
        }else{
            $data['id'] = $id;
            $data['type'] = $this->type;
            $data['status'] = $this->status;
            $info = M("article")->find($id);
            $data['info'] = $info;
            $this->assign($data);
            $this->display("edit");
        }
    }
}
?>