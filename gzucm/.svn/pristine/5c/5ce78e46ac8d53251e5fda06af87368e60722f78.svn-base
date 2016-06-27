<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
	
    public function login(){
    	if(IS_POST){
    		if($this->verifyLogin(I('username'), I('password')) > 0){
    			$this->success('登录成功！', U('index/index'));
    		}
    	}else{
    		if(is_login() > 0){
				$this->redirect('index/index');
    		}else{
    			$this->assign('username', S('usernmae'));
    			$this->display();
    		}
    	}
    }
    
    public function logout(){
    	session('[destroy]');
        session_destroy();
    	redirect(U('public/login'));
    }
    
    private function verifyLogin($username, $password){
    	if(!isset($username)){
    		$this->error('用户名不能为空！');
    	}
    	if(!isset($password)){
    		$this->error('密码不能为空！');
    	}
    	
    	$map = array('username'=>$username);
    	$admin_user = M('admin_user')->where($map)->find();
    	if(is_array($admin_user)){
    		if(thinkMD5($password) == $admin_user['password']){
    			$user=array();
    			$user['uid'] = $admin_user['uid'];
    			$user['username'] = $admin_user['username'];
                session('admin_user', $user,60*60);
    			session('user_auth_sign', user_auth_sign($user));
    			S('usernmae', $user['username']);
    			return $admin_user['uid'];
    		}
    	}
    	$this->error('用户不存在或密码错误');
    }
    
    function password(){
    	echo thinkMD5('111111');
    }
    
    function empty_menu(){
    	$this->show('没有更多菜单了^_^');
    }
    
    function edit_password() {
    	if(IS_POST){
    		$old_password = I('old_password');
    		$password = I('password');
    		$repeat_password = I('repeat_password');
    		
    		if(empty($old_password)){
    			$this->error('旧密码不能为空');
    		}
    		if(strlen($password)<6){
    			$this->error("新密码的长度必须大于6位");
    		}
    		if($password !== $repeat_password){
    			$this->error('两次密码不一致');
    		}
    		
    		$uid = session('admin_user.uid');
    		$pass = M('admin_user')->where(array('uid'=>$uid))->getField('password');
    		if($pass == thinkMD5($old_password)){
    		    if(M('admin_user')->where(array('uid'=>$uid))->save(array('password'=>thinkMD5($password))) !== false){
		    		$this->success('重置密码成功', $_SERVER['HTTP_REFERER']);
		    	}else{
		    		$this->error('重置密码失败');
		    	}
    		}else{
    			$this->error('您输入的旧密码不正确');
    		}
    	}else{
    		$this->ajaxReturn($this->fetch('edit_password'));
    	}
    }
}