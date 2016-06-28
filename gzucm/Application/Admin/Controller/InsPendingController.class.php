<?php
namespace Admin\Controller;

class InsPendingController extends AdminController {
    function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $this->display();
    }

    public function pending(){

    }

    #删除
    public function del()
    {
    	$id = I('id');
        if(empty($id)){
            $this->error('出错了');
        }
        if(M("instrument")->delete($id)){
            $this->success('删除成功', U('index'));
        }else{
            $this->error('删除失败');
        }
    }









}