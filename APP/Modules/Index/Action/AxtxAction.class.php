<?php
class AxtxAction extends Action{
	public function index(){
		$one = M('class')->where(array('pid'=>5,'show'=>array('NEQ',-1)))->select();
		foreach ($one as $key=>$v)
		{
			$two = M('class')->where(array('pid'=>$v['id'],'show'=>array('NEQ',-1)))->select();
			$one[$key]['two'] = $two;
		}
		$id = $_GET['id']?$_GET['id']:15;
		$classname = ($id==15)?"捐款项目":"项目跟进";
		$Goods = M('article'); // 实例化User对象
		import('ORG.Util.Page');// 导入分页类
		$whereq = array('flag'=>array('NEQ',-1),'pid'=>$id);
		$count = $Goods->where($whereq)->count();// 查询满足要求的总记录数
		$Page = new Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('prev','<  PREVIOUS');
		$Page->setConfig('next','NEXT  >');
		$show = $Page->show();// 分页显示输出
		$goods = $Goods->limit($Page->firstRow.','.$Page->listRows)->where($whereq)->order('id DESC')->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->query = $goods;
		$this->id = $id;
		$this->classname = $classname;
		$this->one = $one;
		$this->display();
	}
	public function show(){
		$one = M('class')->where(array('pid'=>5,'show'=>array('NEQ',-1)))->select();
		foreach ($one as $key=>$v)
		{
			$two = M('class')->where(array('pid'=>$v['id'],'show'=>array('NEQ',-1)))->select();
			$one[$key]['two'] = $two;
		}
		$this->one = $one;
		$id = $_GET['id'];
		$data = M('article')->where(array('id'=>$id))->select();
		$this->data=$data;
		$this->display();
		
		
		
		
	}
}