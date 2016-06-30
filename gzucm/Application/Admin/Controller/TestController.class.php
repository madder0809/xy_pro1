<?php
namespace Admin\Controller;

class TestController extends AdminController {
    #列表
    public function index(){
        if(I("name")) $where['iname'] = I("name");
        $t_i = M("test_instrument");
        $data['i_list'] = M("instrument")->distinct(true)->field("name")->select();//仪器列表
        $count = $t_i->where($where)->count();
        $Page = new \Think\Page($count,10);
        $data['_page'] = $Page->show();
        $data['list'] = $t_i->where($where)->order("iname DESC")->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign($data);
        $this->display();
    }

    public  function edit(){
        if(IS_POST){

        }else{
            $test = M("test");
            $count = $test->where()->count();
            $Page = new \Think\Page($count,2);
            $data['_page'] = $Page->show();
            $data['t_list'] = $test->limit($Page->firstRow.','.$Page->listRows)->select();//试题列表
            $data['tmp_list'] = $data['t_list'][0]['id'].",".$data['t_list'][1]['id'];
            $this->assign($data);
            $this->display();
        }
    }

    public function modified(){
        $data = I();

    }

    public function import(){
        if(IS_POST){
            include_once 'Application/Admin/Common/GzucmExcel.class.php';
            $excel = new GzucmExcel();
            $upload_ret = $excel->uploadExcel();
            $filename = $upload_ret['filename'];
            $excel->getSheet($filename,"Sheet1");
            $list = $excel->parseExcelBySheetName(2);//$startrow=2
            $num = $this->saveToDb($list);
            $this->success("{$num}条纪录导入成功",U('index'));
        }else{
            $this->ajaxReturn($this->fetch("import"));
        }
    }

    private function saveToDb($list){
        $test = M("test");
        $num = 0;
        foreach ($list as $k =>$v){
            $data['title'] = $v['A'];
            $data['opt_A'] = $v['B'];
            $data['opt_B'] = $v['C'];
            $data['opt_C'] = $v['D'];
            $data['opt_D'] = $v['E'];
            $data['answer'] = $v['F'];
            if($test->add($data)) $num++;
        }
        return $num;
    }

}