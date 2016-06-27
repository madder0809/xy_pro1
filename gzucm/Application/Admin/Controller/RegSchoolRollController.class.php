<?php
namespace Admin\Controller;

class RegSchoolRollController extends AdminController {
    private $validate = array(
        array("roll_start","require","开始学籍段必须"),
        array("roll_end","require","结束学籍段必须"),
        array("roll_start","roll_end","结束学籍号必须大于开始",1,"lt")
        );
    public function index(){
    	$roll_llist = M("reg_school_roll")->select();
    	$this->assign("roll_list",$roll_llist);
        $this->display();
    }

    public function add(){
    	if(IS_POST){
            if(M("reg_school_roll")->validate($this->validate)->create()){
                if(M("reg_school_roll")->add()){
                    $this->success("添加成功");
                }else{
                    $this->error("添加失败");
                }
            }else{
                $this->ajaxReturn(M("reg_school_roll")->getError());
            }
    	}else{
			$this->ajaxReturn($this->fetch('edit'));
    	}
    }

    public function edit(){
    	$rid = I("id");
    	if(IS_POST){
    		if(M("reg_school_roll")->validate($this->validate)->create()){
                if(M("reg_school_roll")->save()!==false){
                    $this->success("修改成功");
                }else{
                    $this->error("修改失败");
                }
            }else{
                $this->ajaxReturn(M("reg_school_roll")->getError());
            }
    	}else{
    		$info=M("reg_school_roll")->find($rid);
    		$this->assign("id",$rid);
    		$this->assign("info",$info);
    		$this->ajaxReturn($this->fetch('edit'));
    	}
    }

    public function del(){
    	$rid = I('id');
    	if(empty($rid)){
    		$this->error('出错了');
    	}
    	if(M('reg_school_roll')->where(array('id'=>$rid))->delete()){
    		$this->success('删除成功', U('index'));
    	}else{
    		$this->error('删除失败');
    	}
    }
}