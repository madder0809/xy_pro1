<?php
namespace Admin\Controller;

class LaboratoryController extends AdminController {
    private $validate = array(
        array('name', 'require', '实验室名称不能为空'),
        array('number', 'require', '实验室编号不能为空'),
        array('address', 'require', '实验室地址不能为空'),
        array('admin_id', 'require', '管理员不能为空'),
        array('accommodate_people','require','容纳人数不能为空'),
        array('accommodate_group','require','容纳组数不能为空'),
        array('area','require','占地面积不能为空'),
        array('course','require','面向课程不能为空'),
    );
    public function _initialize(){
        parent::_initialize();
        $this->admin_user_list = M("admin_user")->where("status = 1")->select();
    }

    public function index(){
        $where = I();
        if($where['name']){
            $where['name'] = array("like","%{$where['name']}%");
        }else{
            unset($where['name']);
        }
        if($where['status']=="-1") unset($where['status']);
        $count = M("laboratory")->where($where)->count();
        $Page = new \Think\Page($count,10);
        $data['_page'] = $Page->show();
    	$data['list'] = M("laboratory")->where($where)->order("id DESC")->limit($Page->firstRow.','.$Page->listRows)->select();
        $data['admin_user'] = array_column($this->admin_user_list, 'username', 'uid');
        $data['status'] = array("-1"=>"不限","0"=>"正常","1"=>"故障");
    	$this->assign($data);
        $this->display();
    }

    #添加
    public function add(){
        if(IS_POST){
            $laboratory = M("laboratory");
            if($laboratory->validate($this->validate)->create()){
                if($laboratory->add()){
                    $this->success("添加成功",U("index"));
                }else{
                    $this->error("添加失败");
                }
            }else{
                $this->error($laboratory->getError());
            }
        }else{
            $data['admin_user'] = $this->admin_user_list;
            $this->assign($data);
            $this->ajaxReturn($this->fetch('edit'));
        }
    }

    #编辑
    public function edit(){
        $id = I("id");
        if(!$id) $this->error("出错了");
        $laboratory = M("laboratory");
        if(IS_POST){
            if($laboratory->validate($this->validate)->create()){
                if($laboratory->save()!==false){
                    $this->success("编辑成功",U("index"));
                }else{
                    $this->success("编辑失败",U("index"));
                }
            }else{
                $this->error($laboratory->getError());
            }
        }else{
            $data['id'] = $id;
            $data['laboratory'] = $laboratory->find($id);
            $data['admin_user'] = $this->admin_user_list;
            $this->assign($data);
            $this->ajaxReturn($this->fetch('edit'));
        }
    }

    #删除
    public function del(){
        $id = I('id');
        if(empty($id)){
            $this->error('出错了');
        }
        if(M("laboratory")->delete($id)){
            $this->success('删除成功', U('index'));
        }else{
            $this->error('删除失败');
        }
    }

    #导入
    public function import(){
        if(IS_POST){
            include_once 'Application/Admin/Common/GzucmExcel.class.php';
            $excel = new GzucmExcel();
            $upload_ret = $excel->uploadExcel();
            $filename = $upload_ret['filename'];
            $excel->getSheet($filename,"Sheet1");
            $list = $excel->parseExcelBySheetName(2);//$startrow=2
            $this->saveToDb($list);
            $this->success("导入成功",U('index'));
        }else{
            $this->ajaxReturn($this->fetch('import'));
        }
    }

    private function saveToDb($list){
        $_validate = array(
            array('number','','实验室编号不能重复',1,'unique',1)
        );

        foreach ($list as $k=>$v){
            $data['name'] = $v['A'];
            $data['number'] = $v['B'];
            $data['address'] = $v['C'];
            $data['admin_id'] = M("admin_user")->where("realname = '{$v['D']}'")->getField("uid");
            $data['accommodate_people'] = $v['E'];
            $data['accommodate_group'] = $v['F'];
            $data['area'] = $v['G'];
            $data['course'] = $v['H'];
            $data[''] = $v[''];
            $data['status'] = $v['I'];
            $data['reason'] = $v['J'];
            $data['call_repair'] = $v['K'] == "是" ? 1 : 0;
            $data['fix_time'] = $v['L'];
            if($data['address'])
            $id = M("laboratory")->where("address = '{$data['address']}'")->getField('id');
            if($id){ //已存在,保存信息
                $data['id'] = $id;
                if(M("laboratory")->validate($_validate)->create($data))
                    M("laboratory")->save($data);
            }else{//新增
                if(M("laboratory")->validate($_validate)->create($data))
                    M("laboratory")->add($data);
            }
            unset($data);
        }
    }
    
}