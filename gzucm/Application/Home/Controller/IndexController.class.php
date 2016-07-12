<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	//首页
    public function index(){
    	$uid = cookie("uid") ? cookie("uid") : '';
		$article = M("article");
    	//用户信息
    	$data['userinfo'] = M('user')->find($uid);
        //通知公告
        $data['notice'] = $article->where("type = 1 AND status = 1")->order("id DESC")->limit(6)->select();
		//通知
		$tmp = $data['notice'];
		$data['fir_notice'] = array_shift($tmp);
		//中心动态
		$data['center'] = $article->where("type = 6 AND status = 1")->field("id,title,content,publishtime")->order("id DESC")->limit(6)->select();
		//轮转图
		$data['banner'] = $this->getBannerCover(6,3);
		//实验室轮转图
		$data['lab_banner'] = $this->getBannerCover(7,6);
		//规章制度
		$data['rules'] = $article->where("type = 5 AND status = 1")->field("id,title")->order("id DESC")->limit(7)->select();
		//科研成果
		$data['show'] = $this->getCover($article->where("type = 2 AND status = 1")->field("id,title,content")->order("id DESC")->limit(4)->select());
		//var_dump($data['show']);exit();
		//教学实验室
		$data['lab'] = $article->where("type = 7 AND status = 1")->field("id,title")->order("id DESC")->limit(18)->select();
		//资料下载
		$data['resource'] = $article->where("type = 8 AND status = 1")->field("id,title")->order("id DESC")->limit(6)->select();
    	$this->assign($data);
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

	/**
	 * @param $type 文章类型
	 * @param $num 获取的数目
	 * @return mixed
	 */
	private function getBannerCover($type,$num){
		$list = M("article")->where("type = {$type} AND status = 1")->field("content")->select();
		$i = 1;
		foreach ($list as $k=>$v){
			if($i>$num) break;
			preg_match ("<img.*src=[\"](.*?)[\"].*?>",htmlspecialchars_decode($v['content']),$match);
			if($match[1]){
				$arr[$i]['cover'] = $match[1];
				$i++;
			}
			unset($match);
		}
		return $arr;
	}

	//获取封面图
	private function getCover($list){
		foreach($list as $k=>$v){
			preg_match ("<img.*src=[\"](.*?)[\"].*?>",htmlspecialchars_decode($v['content']),$match);
			$list[$k]['cover'] = $match[1] ? $match[1] : "/gzucm/Public/Home/images/scientific.jpg";
			unset($match);
		}
		return $list;
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
