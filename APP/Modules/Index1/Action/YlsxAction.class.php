<?php
class YlsxAction extends Action{
	 public function index(){
		$Goods = M('feeling'); // 实例化User对象
		import('ORG.Util.Page');// 导入分页类
		$whereq = array('flag'=>array('NEQ',-1),'type'=>'feeling');
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
	//益路随想详情页
	public function xq(){
		$id = $_GET['id'];
		M('feeling')->where(array('id'=>$id))->setInc('clicknum');
		$query = M('feeling')->where(array('id'=>$id,'flag'=>array('NEQ',-1)))->select();
		$this->goods = $query;
		$this->display();
	}
}
