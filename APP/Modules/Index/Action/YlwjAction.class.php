<?php
class YlwjAction extends Action{
	public function index()
	{
		$Goods = M('article'); // 实例化User对象
		import('ORG.Util.Page');// 导入分页类
		$whereq = array('flag'=>array('NEQ',-1),'pid'=>'17');
		$count = $Goods->where($whereq)->count();// 查询满足要求的总记录数
		$Page = new Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('prev','<  PREVIOUS');
		$Page->setConfig('next','NEXT  >');
		$show = $Page->show();// 分页显示输出
		$goods = $Goods->limit($Page->firstRow.','.$Page->listRows)->where($whereq)->order('id DESC')->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->goods = $goods;
		$this->display();
	}
	public function activity(){
		$this->display();
	}
	//报名参与
	public function cy(){
		$query = M('sign')->where(array('m'=>date('m')))->select();
		$this->query = $query;
		$this->display();
	}
	public function data(){
		$m = $_POST['m'];
		$query = M('sign')->where(array('m'=>$m))->select();
		echo json_encode(array('result'=>$query,));	
	}
}