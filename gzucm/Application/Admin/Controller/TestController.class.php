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
            $tmp = M("test_instrument")->where("iname = '{$_GET['iname']}'")->field("tid,t_count,order")->find();
            $data['t_count'] = $tmp['t_count'];
            $data['order'] = $tmp['order'];
            $t_list = explode(",",$tmp['tid']);
            foreach($data['t_list'] as $k=>$v){
                if(in_array($v['id'],$t_list)) $data['t_list'][$k]['selectd'] = 1;
            }
            $this->assign($data);
            $this->display();
        }
    }
    //改变答题顺序
    public function setOrder(){
        $data = I();
        if(I("order")){
            M("test_instrument")->where("iname = '{$data['iname']}'")->save($data);
        }
    }
    //选择试题
    public function modified(){
        $data = I();
        $ti = M("test_instrument")->where("iname = '{$data["iname"]}'")->find();
        $t_list = explode(",",$ti['tid']);
        foreach($t_list as $k=>$v){//清除空值
            if(empty($v)) unset($t_list[$k]);
        }
        if($data['control'] == "add"){
            if(!in_array($data['tid'],$t_list))
            $t_list[] = $data['tid'];
        }elseif($data['control'] == "remove"){
            if(in_array($data['tid'],$t_list)){
                foreach ($t_list as $k=>$v){
                    if($v==$data['tid']) array_splice($t_list, $k);
                }
            }
        }else{
            exit();
        }
        array_filter($t_list);
        $data['tid'] = implode(",",$t_list);
        $data['t_count'] = count($t_list);
        if(M("test_instrument")->where("iname = '{$data['iname']}'")->save($data)!==false)
        $this->ajaxReturn($data['t_count']);
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