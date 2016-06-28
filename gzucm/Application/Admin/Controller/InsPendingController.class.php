<?php
namespace Admin\Controller;

class InsPendingController extends AdminController {
    function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $data = I();
        $where .= $_GET['type'] ? " AND a.status <> 0" : " AND a.status = 0";
        $where .= $data['name'] ? " AND i.name like '%{$data['name']}%'" : "";
        $where .= $data['realname'] ? " AND u.realname like '%{$data['realname']}%'" : "";
        $count = M("appointment a")
            ->join("LEFT JOIN user u ON a.uid = u.id LEFT JOIN instrument i ON a.iid=i.id")
            ->where("1 {$where}")
            ->count();
        $Page = new \Think\Page($count,10);
        $data['_page'] = $Page->show();
        $data['list'] = M("appointment a")
            ->join("LEFT JOIN user u ON a.uid = u.id LEFT JOIN instrument i ON a.iid=i.id")
            ->field("a.*,u.realname,u.adviser,i.name")
            ->where("1 {$where}")
            ->limit($Page->firstRow.','.$Page->listRows)->order("id DESC")
            ->select();
        $data['status_name'] = array("-1"=>"未通过","0"=>"未审核","1"=>"已通过");
        $this->assign($data);
        $this->display();
    }

    public function audit(){
        $data = I();
        if(M("appointment")->save($data)!==false){
            $this->success("审核成功",U("index"));
        }else{
            $this->error("审核失败");
        }
    }

    #删除
    public function del()
    {
    	$id = I('id');
        if(empty($id)){
            $this->error('出错了');
        }
        if(M("appointment")->delete($id)){
            $this->success('删除成功', U('index'));
        }else{
            $this->error('删除失败');
        }
    }









}