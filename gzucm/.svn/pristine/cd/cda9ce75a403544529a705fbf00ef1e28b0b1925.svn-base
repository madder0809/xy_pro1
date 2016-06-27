<?php
namespace Admin\Controller;
class UserController extends AdminController {
	public $sex = array("1"=>"男","2"=>"女");
    public $type_name = array("1"=>"学生","2"=>"教师");
    public function _initialize(){
        parent::_initialize();
        if(!I("type")) $this->error("出错了");
        $this->type = I("type");
    }

    public function index(){
        $where['type'] = $this->type;
        if(I('realname')) $where['realname'] = array("like","%".I('realname')."%");
    	$count = M('user')->where($where)->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,10);
		$data['_page'] = $Page->show();
		$data['list'] = M('user u')
        ->join('LEFT JOIN region r1 on u.fir_na = r1.region_code')
        ->join("LEFT JOIN region r2 on u.sec_na = r2.region_code")
        ->field("u.*,r1.region_name as fir_na_name,r2.region_name as sec_na_name")
        ->where($where)
        ->order('u.id DESC')
        ->limit($Page->firstRow.','.$Page->listRows)
        ->select();
        $data['sex'] = $this->sex;
		$this->assign($data);
        $this->display();
    }

    #添加
    public function add(){
        if(IS_POST){
            $user = D("user");
            if($user->create()){
                if($user->add()){
                    $this->success("添加成功",U("index",array("type"=>$this->type)));
                }else{
                    $this->error("添加失败");
                }
            }else{
                $this->error($user->getError());
            }
        }else{
            $data['sex'] = $this->sex;
            $data['type'] = $this->type;
            $data['type_name'] = $this->type_name;
            $this->assign($data);
            $this->ajaxReturn($this->fetch('edit'));
        }
    }

    #编辑
    public function edit(){
        $id = I("id");
        if(!$id) $this->error("没找到该用户");
        $user = D("user");
        if(IS_POST){
            $data = I();
            if(!$user->create($data)){
                $this->error($user->getError());
            }else{
                if($user->save()!==false){
                    $this->success("编辑成功",U("index",array("type"=>$this->type)));
                }else{
                    $this->error("编辑失败");
                }
            }
        }else{
            $data['id'] = $id;
            $data['user'] = $user->find($id);
            $data['sex'] = $this->sex;
            $data['type'] = $this->type;
            $data['type_name'] = $this->type_name;
            $this->assign($data);
            $this->ajaxReturn($this->fetch('edit'));
        }
    }

    #删除
    function del(){
    	$id = I("id");
        if(!$id) $this->error("没找到该用户");
        if(M("user")->delete($id)){
            $this->success('删除成功', U('index',array("type"=>$this->type)));
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
            $num = $this->saveToDb($this->type,$list);
            $this->success("{$num}条信息导入成功",U('index',array("type"=>$this->type)));
        }else{
            $data['type'] = $this->type;
            $data['type_name'] = $this->type_name;
            $this->assign($data);
            $this->ajaxReturn($this->fetch('import'));
        }
    }

    private  function getNavite($str){ //获取籍贯code
        $na = explode("/",$str);
        $arr['fir_na'] = M("region")->where("region_name like '%{$na[0]}%'")->getField("region_code");
        $arr['sec_na'] = M("region")->where("region_name like '%{$na[1]}%'")->getField("region_code");
        return $arr;
    }

    private function saveToDb($type,$list=array()){
        $i = 0;//成功导入的数量
        $_validate = array(
            array('username','','用户名已被注册！',1,'unique',1),
            array('iden_no','','学籍号已被注册',1,'unique',1)
        );
        if($type == 1){//学生
            foreach($list as $k=>$v ){//学生
                $data['username'] = $v['A'];
                $data['realname'] = $v['B'];
                $data['sex'] = $v['C']=="男" ? "1" : "2";
                $data['iden_no'] = $v['D'];
                $data['grade'] = $v['E'];
                $data['specialty'] = $v['F'];
                $data['classes'] = $v['G'];
                if($v['H']){
                    $na = $this->getNavite($v['H']);
                    $data['fir_na'] = $na['fir_na'];
                    $data['sec_na'] = $na['sec_na'];
                }
                $data['id_card_no'] = (string)$v['I'];
                $data['mobile'] = $v['J'];
                $data['email'] = $v['K'];
                $data['adviser'] = $v['L'];
                $data['edu_level'] = $v['M'];
                $data['type'] = $this->type;
                if(M("user")->validate($_validate)->create($data)){
                    if(M("user")->add($data))
                    $i++;
                }
                unset($data);
                unset($na);
            }
        }else{//教师
            foreach($list as $k => $v){
                $data['username'] = $v['A'];
                $data['realname'] = $v['B'];
                $data['sex'] = $v['C']=="男" ? "1" : "2";
                $data['iden_no'] = $v['D'];
                $data['department'] = $v['E'];
                $data['teac_title'] = $v['F'];
                if($v['G']){
                    $na = $this->getNavite($v['G']);
                    $data['fir_na'] = $na['fir_na'];
                    $data['sec_na'] = $na['sec_na'];
                }
                $data['id_card_no']  = (string)$v['H'];
                $data['mobile'] = $v['I'];
                $data['email'] = $v['J'];
                $data['type'] = $this->type;
                if(M("user")->validate($_validate)->create($data)){
                    if(M("user")->add($data))
                        $i++;
                }
                unset($data);
                unset($na);
            }
        }
        return $i;
    }

}