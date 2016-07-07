<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	//首页
    public function index(){
    	$uid = cookie("uid") ? cookie("uid") : '';
    	//用户信息
    	$data['userinfo'] = M('user')->find($uid);
        //通知公告
        $data['notice'] = M("article")->order("id DESC")->limit(6)->select();
        
    	$this->assign($userinfo);
        $this->display();
    }

    //登录提交页
    public function login(){
    	if(IS_POST){
    		$data = I();
    		//检测验证码
    		$Verify = new \Think\Verify();
    		if($Verify->check($data['verify'])){
    			$userinfo = M("user")->where("username = '{$data['username']}'")->find();
                if(!$this->check_user($userinfo['iden_no'])) $this->error("该用户已禁止登录");
    			if($userinfo){//有该用户信息,判断密码
    				if(md5($data['password'])==$userinfo['password']){
    					cookie("uid",$userinfo['id']);
    					cookie("username",$userinfo['username']);
    					$this->success("登录成功");
    				}else{//
    					$this->error('密码错误');
    				}
    			}else{//用户名不存在
    				$this->error('用户名不存在');
    			}
    		}else{
    			$this->success("验证码错误");
    		}
    	}
    }

    //退出登录
    public function logout(){
    	cookie("uid",null);
    	cookie("username",null);
    	$this->success("退出成功,正在返回首页");
    }

    //验证码
    public function verify(){
    	$config =    array(
		    'fontSize' =>'20px',    // 验证码字体大小
		    'length'   => 4,     // 验证码位数
		    'imageW' => 135,
		    'imageH' =>50,
		    'useCurve'=>false,
		);
    	$Verify =     new \Think\Verify($config);
		// 设置验证码字符为纯数字
		$Verify->codeSet = '0123456789'; 
		$Verify->entry();
    }

    //注册step1
    public function register_step1(){
    	$this->display();
    }

    //注册step2
    public function register_step2(){
    	if(I('xuehao')){
            $fir_na = M("region")->where("father_id = 0")->select();
            $this->assign("fir_na",$fir_na);
    		$this->assign("iden_no",I("xuehao"));
    		$this->display();
    	}else{
    		$data = I();
    		$data['confirm_pwd'] = md5($data['password']);
            $data['password'] = md5($data['password']);

    		//$data['native'] = $data['fir_na'].$data['sec_na'];
            $user = D('user');

    		if(!$user->create($data)){
                exit($user->getError());
            }else{
                $uid = $user->add($data);
                if($uid){
                    cookie("uid",$uid);
                    cookie("username",$data['username']);
                    $this->success("注册成功",U("Index/index"));    
                }
            }
    	}
    }

    //注册成功
    public function reg_success(){
    	$this->display();
    }

    //检测学号
    public function check_sid(){
    	$sid = I('sid');
    	$r = M("user")->where("iden_no = '{$sid}' and type =1")->find();
        if($this->check_user($sid)){ //0可以注册,1已被注册,2学籍段不能注册
            $data = $r ? 1 : 0; 
        }else{
            $data = 2;
        }
    	$this->ajaxReturn($data);
    }

    //注册验证
    public function reg_check(){
    	$data = I();
    	if(!$data){exit;}
    	//检测用户名是否已注册
    	if(M("user")->where("username = '{$data['username']}'")->find()){
    		$this->ajaxReturn($this->error_return(4));
    		exit();
    	}
       	foreach ($data as $k => $v) {
    		switch ($k) {
    			case 'mobile':
    				$preg = "/^1[34578]{1}\d{9}$/";
    				$error = 1;
    				break;
    			case 'id_card_no';
    				$preg = "/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/";
    				$error = 2;
    				break;
    			case 'email';
    				$preg = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    				$error = 3;
    				break;
    		}
    		if($preg){
    			if(!preg_match($preg,$v)){
    				$this->ajaxReturn($this->error_return($error));
    				return false;
    			}
    		}
    	}
    }

    public function error_return($num){
    	switch ($num) {
    		case 1:
    			$err_str = "请输入正确的手机号";
    			break;
    		case 2:
    			$err_str = "身份证号码不正确";
    			break;
    		case 3:
    			$err_str = "邮箱格式不正确";
    			break;
    		case 4:
    			$err_str = "用户名已被注册";
    			break;
            case 5:
                $err_str ='用户名必须为4-20位数字和字母的结合';
                break;
    		default:
    			# code...
    			break;
    	}
    	return $err_str;
    }

    //登录验证,学籍号
    public function check_user($iden_no){
        $roll_list = M("login_school_roll")->where("use_login = 1")->select();
        foreach ($roll_list as $k => $v) {
            if($iden_no>=$v['roll_start']&&$iden_no <= $v['roll_end']){
                $ok = true;
                break;
            }
        }
        return $ok ? true : false;
    }

    //获取城市
    public function get_region(){
        $father_id = I("father_id");
        if($father_id){
            $r = M("region")->where("father_id = {$father_id}")->select();
            $this->ajaxReturn($r);
        }
    }
}
