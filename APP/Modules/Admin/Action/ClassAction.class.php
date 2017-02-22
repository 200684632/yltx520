<?php
Class ClassAction extends Action{
	public function index(){
		$data = M('class')->where(array('pid'=>0,'show'=>array('NEQ',-1)))->select();
		$this->data = $data;
		$this->display();
	}
	public function sonclass(){
		$id = $_GET['id'];
		$data = M('class')->where(array('pid'=>$id,'show'=>array('NEQ',-1)))->select();
		$this->data = $data;
		$this->display('index');
	}
	public function add(){
		if(IS_POST)
		{
			$id = $_POST['pid'];
			$name = $_POST['title'];
			if ($name){
				$num = M('class')->data(array('pid'=>$id,'name'=>$name))->add();
				if ($num)
				{
					$this->success('分类添加完成',U('index'));
				}else 
				{
					$this->error('分类添加失败');
				}
			}else{
				$this->error('标题不能为空');
			}
		}else{
			$id = $_GET['id'];
			$data = M('class')->where(array('id'=>$id,'show'=>array('NEQ',-1)))->select();
			$this->data = $data;
			$this->display();
		}
	}
	public function update(){
		if (IS_POST){
			$id = $_GET['id'];
			$num = M('class')->where(array('id'=>$id))->save(array('show'=>-1));
			if ($num){
			$this->success('修改成功');
			}else
			{
				$this->error('修改失败');
			}
		}else{
			$id = $_GET['id'];
			$data = $data = M('class')->where(array('id'=>$id,'show'=>array('NEQ',-1)))->select();
			$this->data = $data;
			$this->display();
		}
	}
	public function del(){
		$id = $_GET['id'];
		$num = M('class')->where(array('id'=>$id))->save(array('show'=>-1));
		if ($num){
			$this->success('删除成功');
		}else
		{
			$this->error('删除失败');
		}
	}
	public function updateclass(){
        $id = $_GET['id'];
        $title = $_POST['title'];
        $num = M('class')->where(array('id'=>$id))->data(array('name'=>$title))->save();
        if ($num){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }
    }
}