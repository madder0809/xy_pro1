<?php
namespace Admin\Controller;

class MenuController extends AdminController {
	//列表
    public function index(){
        $menu_all = menu_sort(0);
        $this->assign("menu_all",$menu_all);
        $this->display();
    }
    //添加
    public function add(){
        if($_POST['submit']){
            $Menu = D('Menu');
            $_POST['url'] = $_POST['cotroller']."/".$_POST['function'].$_POST['param'];
            $t_pid = $Menu->where("id = {$_POST['pid']}")->field("t_pid")->find();
            $_POST['t_pid'] = $t_pid['t_pid'];
            $Menu->create();
            $r = $Menu->add();
            if($r){
                $this->success("添加成功");
            }else{
                $this->error("添加失败");
            }
        }else{
            $menu = menu_sort(0,-1,'html');
            $this->assign("menu",$this->menu);
            $this->display();
        }
    }
    //编辑
    public function edit(){
        $menu = menu_sort(0,-1,'html');
        $this->assign("menu",$this->menu);
        $this->display();
    }
    //删除
    public function del(){
        
    }

    //排序
    public function list_order(){
    	
    }
    
}