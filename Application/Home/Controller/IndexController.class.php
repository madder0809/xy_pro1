<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	//首页
    public function index(){
    	$uid = cookie("uid") ? cookie("uid") : '';
    	//用户信息
    	$userinfo = M('user')->find($uid);
    	$this->assign($userinfo);
        $this->display();
    }

    //登录提交页
    public function login(){
    	if(IS_POST){
    		$data = I('');
    		//检测验证码
    		$Verify = new \Think\Verify();
    		if($Verify->check($data['verify'])){
    			$userinfo = M("user")->where("username = '{$data['username']}'")->find();
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
    public function register1(){

    	$this->display();
    }
    //注册step2
    public function register2(){
    	if(I('xuehao')){
    		$this->assign("student_no",I("xuehao"));
    		$this->display();
    	}else{
    		$data = I();
    		//身份证验证
            //邮箱验证
            //手机验证
    		$data['password'] = md5($data['password']);
    		$data['native'] = $data['fir_na'].$data['sec_na'];
    		M('user')->create($data);
    		$uid = M('user')->add();
    		if($uid){
    			cookie("uid",$uid);
    			cookie("username",$data['username']);
    			$this->success("注册成功",U("Home/Index/index"));	
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
    	$r = M("user")->where("student_no = '{$sid}'")->find();
    	$data = $r ? 0 : 1;
    	$this->ajaxReturn($data);
    }
}