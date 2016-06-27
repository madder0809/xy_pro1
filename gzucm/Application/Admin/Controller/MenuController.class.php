<?php
namespace Admin\Controller;
use Common\Tree;

class MenuController extends AdminController {
    
    private $rules = array(
        array('title','require','菜单名称不能为空！',1,'regex', 3),
        array('name', 'require', '应用名称不能为空', 1, 'regex', 3),
    );
    
    /* 菜单树列表最多之多三级 */
    public function index(){
    	$Auth = new \Think\Auth();
    	$menu_list = M('auth_menu')->where(array('pid'=>0))->order("sort desc,id asc")->getField('id,name,title,pid,sort');
    	foreach ($menu_list as $key => $nav){
    		$second_menu = M('auth_menu')->where(array('pid'=>$nav['id']))->order("sort desc,id asc")->getField('id,name,title,pid,sort');
    		foreach ($second_menu as $key_second => $second){
    			$third_menu = M('auth_menu')->where(array('pid'=>$second['id']))->order("sort desc,id asc")->getField('id,name,title,pid,sort');
    			$second_menu[$key_second]['_child'] = $third_menu;
    		}
    		$menu_list[$key]['_child'] = $second_menu;
	    }
	    $this->assign('menu_list',$menu_list);
	    $this->display();
	}
	
	function add(){
	    if(IS_POST){
     	  $menu = M('auth_menu');
    	   if($menu->validate($this->rules)->create()){
    	   	  if($menu->add()){
    	      	   $this->cheanMenuCache();
    	           $this->success('菜单增加成功', U('index'));
    	       }else{
    	           $this->error('菜单增加失败');
    	       }
    	   }
	    }else{
    		$this->assign('pid', I('pid'));
    		
	        include_once 'Application/Admin/Common/Tree.class.php';
	        $menu_list = M('auth_menu')->where(array('menu_type'=>1))->field('id,name,title,pid')->select();
	        $tree = new  Tree();
            $menu_list = $tree->toFormatTree($menu_list);
            $this->assign('menu_list', $menu_list);
            $this->ajaxReturn($this->fetch('edit'));
	    }
	}
	
	function edit(){
	    $id = I('id');
	    if(empty($id)){
	       $this->error('出错了');    
	    }
	    
	    if(IS_POST){
	        $menu = M('auth_menu');
	        if($menu->validate($this->rules)->create()){
	            if($menu->save() !== false){
	            	$this->cheanMenuCache();
	                $this->success('菜单编辑成功', U('index'));
	            }else{
	                $this->error('菜单编辑失败');
	            }
	        }
	    }else{
	        include_once 'Application/Admin/Common/Tree.class.php';
	        $menu_list = M('auth_menu')->where(array('menu_type'=>1))->field('id,name,title,pid')->select();
	        $tree = new  Tree();
	        $menu_list = $tree->toFormatTree($menu_list);
	        $this->assign('menu_list', $menu_list);
	        
	        $menu = M('auth_menu')->where(array('id'=>$id))->find();
	        $this->assign('menu', $menu);
	        $this->assign('pid', $menu['pid']);
	        $this->assign('id', $id);
	        $this->ajaxReturn($this->fetch('edit'));
	    }
	}
	
	function del(){
		$id = I('id');
		if(empty($id)){
			$this->error('出错了');
		}
		
		if(!M('auth_menu')->where(array('pid'=>$id))->select()){
			if(M('auth_menu')->where(array('id'=>$id))->delete()){
				$this->cheanMenuCache();
				$this->success('删除成功', U('index'));
			}else{
				$this->error('删除失败');
			}
		}else{
			$this->error('删除失败：此菜单下还有子菜单，请先删除子菜单');
		}
	}
	
	function cheanMenuCache(){
	}
	
	function update_sort(){
		$id = I('id');
		if(IS_POST && !empty($id)){
			$sort = I('sort');
			M('auth_menu')->where(array('id'=>$id))->save(array('sort'=>$sort));
		}
	}
}