<?php
class LpAction extends CommonAction{
	public function index(){
		$query = M('lp')->where(array('name'=>'刘佩'))->select();
		$this->query = $query;
		$this->display();
	}
	public function updata(){
		$where = array(
			'name'=>'刘佩'
		);
		$data = array(
			'summary'=>$_POST['intro'],
		);
		$query = M('lp')->where($where)->save($data);
		if ($query) {
			$this->success('修改成功！',U('index'));
		}else
		{
			$this->error('修改失败！');
		}
	}
}