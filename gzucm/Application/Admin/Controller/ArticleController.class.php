<?php

namespace Admin\Controller;
class ArticleController extends AdminController {
    public $type_name = array(1=>"通知公告",2=>"成果展示",3=>"中心概况",4=>"中心师资",5=>"规章制度",6=>"中心动态",7=>"教学实验室",8=>"资料下载");
    public $status = array(1=>"已通过",2=>"未通过",0=>"未审核");
    private $validate = array(
        array('title', 'require', '标题不能为空'),
        array('content', 'require', '内容不能为空')
        );
    public function _initialize(){
        parent::_initialize();
        if(!I("type")) $this->error("出错了");
        $this->type = I("type");//文章类型
    }
    
    //通知公告
    public function index(){
        $title = I("title");
        $where = "type = {$this->type}";
        $where .= $title ? " AND title like '%{$title}%'" :"";
        $count = M('article')->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,10);
        $data['_page'] = $Page->show();
        $notice_list = M("article")->where($where)->order('publishtime DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $data['type'] =  $this->type;
        $data['status'] = $this->status;
        $data['notice_list'] = $notice_list;
        $data['title'] = $title;
        $data['type_name'] = $this->type_name[$this->type];
        $this->assign($data);
        $this->display();
    }
    //审核
    public function audit(){
        $data = I();
        if(M("article")->save($data)!==false){
            $this->success("审核成功",U("index",array("type"=>$this->type)));
        }else{
            $this->error("审核失败");
        }
    }
    //发布
    public function add(){
        if(IS_POST){
            if(M("article")->validate($this->validate)->create()){
                if(M("article")->add()){
                    $this->success("发布成功",U("index",array("type"=>$this->type)));
                }else{
                    $this->error("发布失败");
                }
            }else{
                $this->error(M("article")->getError());
            }   
        }else{
            $data['type'] = $this->type;
            $data['status'] = $this->status;
            $this->assign($data);
            $this->assign('current_url', U('Article/index', array('type'=>$this->type)));
            $this->display('edit');
        }
    }

    //编辑
    public function edit(){
        $id = I("id");
        if(!$id){
            $this->error("出错了");
        }
        $article = M("article");
        if(IS_POST){
            if($article->validate($this->validate)->create()){
                if($article->save()!==false){
                    $this->success("编辑成功",U("index",array("type"=>$this->type)));
                }
            }else{
                $this->error($article->getError());
            }
        }else{
            $data['id'] = $id;
            $data['type'] = $this->type;
            $data['status'] = $this->status;
            $info = M("article")->find($id);
            $data['info'] = $info;
            $this->assign($data);
            $this->assign('current_url', U('Article/index', array('type'=>$this->type)));
            $this->display("edit");
        }
    }

    //删除
    public function del(){
        $id = I('id');
        if(!$id) $this->error("没找到对应文章");
        if(M('article')->where("id = {$id}")->delete()){
            $this->success('删除成功', U('index',array("type"=>$this->type)));
        }else{
            $this->error('删除失败');
        }
    }
}
?>