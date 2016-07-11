<?php
namespace Admin\Controller;

class AdminUserController extends AdminController {
	private $rules = array(     
	    array('username','','管理员已存在！',0,'unique', 3),
		array('username', 'require', '用户名不能为空', 1, 'regex', 3),
		array('password', 'require', '密码不能为空', 0, 'regex', 0),
		array('repeat_password','password','两次密码不相同',0,'confirm', 0), 
	    array('group_id', '0', '请选择角色', 0, 'notequal', 3),
	);
	
    public function index(){
    	$param = I();
    	$where = array();
    	if($param['username']){
    		$where['au.username'] =  array('like', '%'.$param['username'].'%');
    		$this->assign('adminusername', $param['username']);
    	}
    	if($param['auth_group']){
    		$where['ag.title'] =  array('like', '%'.$param['auth_group'].'%');
    		$this->assign('auth_group', $param['auth_group']);
    	}
    	
    	$count = M('admin_user au')
    	    ->where($where)
    		->join('left join auth_group_access aga on aga.uid = au.uid')
    		->join('left join auth_group ag on ag.id = aga.group_id')
    		->count();
    	$page = new \Think\Page($count,10);
    	$this->assign('_page', $page->show());
    	
    	$admin_user_list = M('admin_user au')
    		->where($where)
    		->join('left join auth_group_access aga on aga.uid = au.uid')
    		->join('left join auth_group ag on ag.id = aga.group_id')
    		->field('au.uid,au.username,ag.title as role')
    		->limit($page->firstRow . ', ' . $page->listRows)
    		->select();
    	$this->assign('admin_user_list', $admin_user_list);
        $this->display();
    }
    
    function add(){
    	if(IS_POST){
    		$password = I('password');
    		$_POST['password'] = thinkMD5($password);
    		$admin_user = M('admin_user');
    		if($admin_user->validate($this->rules)->create()){
    			$uid = $admin_user->add();
    			if($uid){
    				M('auth_group_access')->add(array('uid'=>$uid, 'group_id'=>I('group_id')));
    				$this->success('管理员增加成功', U('index'));
    			}else{
    				$this->error('管理员增加失败');
    			}
    		}else{
    			$this->error($admin_user->getError());
    		}
    	}else{
    		$role_list = M('auth_group')->where(array('status'=>1))->select();
    		$this->assign('role_list',$role_list);
    		$this->ajaxReturn($this->fetch('edit'));
    	}
    }
    
    function edit(){
    	$uid = I('uid');
    	if(empty($uid)){
    		$this->error('出错了');
    	}
    	if(IS_POST){
        	$uid = I('uid');
    	    if($uid == 1){
    	       $this->error('admin不可编辑');    
    	    }
    	    
    		$admin_user= M('admin_user');
    		if($admin_user->validate($this->rules)->create()){
    			if($admin_user->save() !== false){
    				$this->success('管理员编辑成功', U('index'));
    			}else{
    				$this->error('管理员编辑失败');
    			}
    		}else{
    			$this->error($admin_user->getError());
    		}
    	}else{
    		$admin_user = M('admin_user au')->where(array('au.uid'=>$uid))
    		->join('auth_group_access aga on aga.uid = au.uid')
    		->join('auth_group ag on ag.id = aga.group_id')
    		->field('au.uid,au.username,aga.group_id')->find();
    		$role_list = M('auth_group')->where(array('status'=>1))->select();
    		$this->assign('role_list',$role_list);
    		$this->assign('admin_user', $admin_user);
    		$this->assign('uid', $uid);
    		$this->ajaxReturn($this->fetch('edit'));
    	}
    }
    
    function del(){
    	$uid = I('uid');
    	if(empty($uid)){
    		$this->error('出错了');
    	}
    	
    	$uid = I('uid');
    	if($uid == 1){
    	    $this->error('admin不可删除');
    	}
    	
    	if(M('admin_user')->where(array('uid'=>$uid))->delete()){
    		$this->success('删除成功', U('index'));
    	}else{
    		$this->error('删除失败');
    	}
    }
    
    function reset(){
    	$uid = I('uid');
    	if(empty($uid)){
    		$this->error('出错了');
    	}
    	 
    	$uid = I('uid');
    	if($uid == 1){
    		$this->error('admin不可重置');
    	}
    	
    	if(M('admin_user')->where(array('uid'=>$uid))->save(array('password'=>thinkMD5('123456'))) !== false){
    		$this->success('重置密码成功', U('index'));
    	}else{
    		$this->error('重置密码失败');
    	}
    	
    }
    
}