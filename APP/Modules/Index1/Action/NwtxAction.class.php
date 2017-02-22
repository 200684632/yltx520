<?php
class NwtxAction extends Action{
	public function index(){
		$Goods = M('poetry'); // 实例化User对象
		import('ORG.Util.Page');// 导入分页类
		$whereq = array('flag'=>array('NEQ',-1),'pid'=>0);
		$count = $Goods->where($whereq)->count();// 查询满足要求的总记录数
		$Page = new Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('prev','<  PREVIOUS');
		$Page->setConfig('next','NEXT  >');
		$show = $Page->show();// 分页显示输出
		$goods = $Goods->limit($Page->firstRow.','.$Page->listRows)->where($whereq)->order('id DESC')->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->query = $goods;
		$this->display();
	}
	public function shi(){
		$id = $_GET['id'];
		M('poetry')->where(array('id'=>$id))->setInc('clicknum');
		$data1 = M('poetry')->field('author,image,content')->where(array('id'=>$id,'flag'=>array('NEQ',-1)))->select();
		$this->image = $data1;
		$data = M('poetry')->where(array('pid'=>$id,'flag'=>array('NEQ',-1)))->select();
		$this->data = $data;
		$this->display();
	}
}