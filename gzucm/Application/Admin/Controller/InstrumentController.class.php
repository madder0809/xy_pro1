<?php
namespace Admin\Controller;

class InstrumentController extends AdminController {

    private $validate = array(
        array('name', 'require', '名称不能为空'),
        array('number', 'require', '编号不能为空'),
        array('address', 'require', '实验室地址不能为空'),
        array('admin_id', 'require', '管理员不能为空'),
        array('brand','require','品牌不能为空'),
        array('model','require','型号不能为空'),
        array('spec','require','规格不能为空'),
        array('buy_date','require','购买日期不能为空'),
    );
    function _initialize()
    {
        parent::_initialize();
        $this->admin_user_list = M("admin_user")->where("status = 1")->select();
        $this->startDate = M("master")->where("`key` = 'startDate'")->getField("value");//学期开始日期
        set_time_limit(0);
        ini_set("memory_limit", "1024M");
    }

    public function index()
    {
        $data = I();
        $where .= $data['name'] ? " AND i.name LIKE '%{$data['name']}%'" : "";
        $where .= isset($data['status']) && $data['status'] <> -1 ? " AND i.status = {$data['status']}" : "";
        $where .= $data['lab_id'] ? " AND i.lab_id = {$data['lab_id']}" : "";
        $count = M("instrument i")->join("LEFT JOIN laboratory l ON i.lab_id = l.id")
            ->field("i.*,l.name as lab_name,l.number as lab_number,l.address,l.admin_id")
            ->where("1 {$where}")
            ->count();
        $Page = new \Think\Page($count,10);
        $data['admin_user'] = array_column($this->admin_user_list, 'username', 'uid');
        $data['_page'] = $Page->show();
    	$data['list'] = M("instrument i")->join("LEFT JOIN laboratory l ON i.lab_id = l.id")
    	->field("i.*,l.name as lab_name,l.number as lab_number,l.address,l.admin_id")->where("1 {$where}")->order("id ASC")
    	->limit($Page->firstRow.','.$Page->listRows)->select();
        $data['status'] = array("-1"=>"不限","0"=>"正常","1"=>"故障");
        $data['lab_list'] = array_column(M("laboratory")->field("id,name")->select(),"name","id");
    	$this->assign($data);
        $this->display();
    }

    #添加
    public function add()
    {
    	if(IS_POST){
            $instrument = M("instrument");
            if($instrument->validate($this->validate)->create()){
                if($instrument->add()){
                    $this->success("添加成功",U("index"));
                }else{
                    $this->error("添加失败");
                }
            }else{
                $this->error($instrument->getError());
            }
        }else{
            $data['admin_user'] = $this->admin_user_list;
            $this->assign($data);
            $this->ajaxReturn($this->fetch('edit'));
        }
    }

    #编辑
    public function edit()
    {
    	$id = I("id");
        if(!$id) $this->error("出错了");
        $instrument = M("instrument");
        if(IS_POST){
            if($instrument->validate($this->validate)->create()){
                if($instrument->save()!==false){
                    $this->success("编辑成功",U("index"));
                }else{
                    $this->success("编辑失败");
                }
            }else{
                $this->error($instrument->getError());
            }
        }else{
            $data['id'] = $id;
            $data['instrument'] = M("instrument i")->join("LEFT JOIN laboratory l ON i.lab_id = l.id")
            ->where("i.id = {$id}")
	    	->field("i.*,l.name as lab_name,l.number as lab_number,l.address")
	    	->find();
            $data['admin_user'] = $this->admin_user_list;
            $this->assign($data);
            $this->ajaxReturn($this->fetch('edit'));
        }
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

    public function situation()
    {
        $data = I();
        $where .= $data['name'] ? " AND i.name LIKE '%{$data['name']}%'" : "";
        $where .= isset($data['status']) && $data['status'] <> -1 ? " AND i.status = {$data['status']}" : "";
        $where .= $data['lab_id'] ? " AND i.lab_id = {$data['lab_id']}" : "";
        $count = M("instrument i")->join("LEFT JOIN laboratory l ON i.lab_id = l.id")
            ->field("i.*,l.name as lab_name,l.number as lab_number,l.address,l.admin_id")
            ->where("1 {$where}")
            ->count();
        $Page = new \Think\Page($count,10);
        $data['admin_user'] = array_column($this->admin_user_list, 'username', 'uid');
        $data['_page'] = $Page->show();
        $data['list'] = M("instrument i")->join("LEFT JOIN laboratory l ON i.lab_id = l.id")
            ->field("i.*,l.name as lab_name,l.number as lab_number,l.address,l.admin_id")->where("1 {$where}")->order("id ASC")
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $data['status'] = array("-1"=>"不限","0"=>"正常","1"=>"故障");
        $data['lab_list'] = array_column(M("laboratory")->field("id,name")->select(),"name","id");
        $data['isUseSituation'] =  "situation";
        if($data['isUseSituation']) $data['list'] = $this->getSituation($data['list']);
        $this->assign($data);
        $this->display("index");
    }

    #导入
    public function import()
    {
        if(IS_POST){
            include_once 'Application/Admin/Common/GzucmExcel.class.php';
            $excel = new GzucmExcel();
            $upload_ret = $excel->uploadExcel();
            $filename = $upload_ret['filename'];
            $excel->getSheet($filename,"实验中心资产");
            $list = $excel->parseExcelBySheetName(2);//$startrow=2
            $num = $this->saveToDb($list);
            $this->success("{$num}条纪录导入成功",U('index'));
        }else{
            $this->ajaxReturn($this->fetch('import'));
        }
    }

    #保存到数据库
    private function saveToDb($list){
        $tmp = array();
        $_validate = array(
            array('number','','资产编号不能重复',1,'unique',1)
        );
        $i = 0;
        $table_no = 1;//初始台号
        foreach ($list as $k=>$v){
            $data['name'] = $v['C'];
            $lab_id = M("laboratory")->where("address = '{$v['N']}'")->getField("id");
            $data['lab_id'] = $lab_id ? $lab_id : M("laboratory")->add(array("address"=>$v['N'],"name"=>$v['N']));
            $data['number'] = $v['B'];
            if($tmp[$v['C']]){
                $table_no++;
                $data['table_no'] = $table_no;
            }else{
                $tmp[$v['C']]++;
                $table_no = 1;
                $data['table_no'] = $table_no;//默认台号为0
            }
            $data['brand'] = $v['AA'];
            $data['model'] =$v['AC'];
            $data['spec'] = $v['AD'];
            $data['remark'] = $v['V'];
            $data['buy_date'] = $v['AG'];
            if(M("instrument")->validate($_validate)->create($data)){
                M("instrument")->add($data);
                $i++;
            }
            unset($data);
        }
        return $i;
    }

    /**
     * @param $this->startDate 学期开始的日期
     * @return array $twoWeekDays 双周的14天分别的日期
     */
    public function getTwoWeek(){
        $week = date('w',strtotime($this->startDate));
        $diff = 1-$week;
        $startMon = date("Y-m-d",strtotime("+{$diff}days",strtotime($this->startDate)));
        $now = date("Y-m-d");
        $diffDays = round((strtotime($now)-strtotime($startMon))/3600/24);
        $diff = $diffDays % 14;
        $twoWeekStartDay = date("Y-m-d",strtotime("-{$diff}days",strtotime($now)));
        for($i=0;$i<=13;$i++){
            $twoWeekDays[] = $twoWeekStartDay;
            $twoWeekStartDay = date("Y-m-d",strtotime("+1days",strtotime($twoWeekStartDay)));
        }
        return $twoWeekDays;
    }

    private function getSituation($list){
        $model = M();
        $twoWeek = $this->getTwoWeek();
        $appointment = M("appointment");
        foreach ($list as $k => $v){
            foreach($twoWeek as $key => $val){
                $r = $model->query("SELECT count(1) as 'num' FROM `schedule` s LEFT JOIN laboratory l ON s.address = l.address WHERE l.id = {$v['lab_id']} AND s.`date` = '{$val}'");
                if($r[0]['num']>0){
                    $list[$k]['situation'][] = true;
                }else{
                    $r = $appointment->where("((starttime < '{$val}' AND endtime > '{$val}') OR (date_format(starttime,'%Y-%m-%d')='$val'))  AND iid = {$v['id']} AND status = 1")->count();
                    $list[$k]['situation'][] = $r>0 ? true : false;
                }
            }
        }
        return $list;
    }


}