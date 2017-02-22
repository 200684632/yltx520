<?php
class YlszAction extends Action{
	public function index(){
		$one = M('class')->where(array('pid'=>4,'show'=>array('NEQ',-1)))->select();
		foreach ($one as $key=>$v)
		{
			$two = M('class')->where(array('pid'=>$v['id'],'show'=>array('NEQ',-1)))->select();
			$one[$key]['two'] = $two;
		}
		if ($_GET['id']==14){
			$type = 'image';
		}else{
			$type = 'vedio';
		}
		$id = $_GET['id']?$_GET['id']:13;
		$this->id = $id;
		$this->one = $one;
		$Goods = M('images'); // 实例化User对象
		import('ORG.Util.Page');// 导入分页类
		$whereq = array('flag'=>array('NEQ',-1),'type'=>$type);
		$count = $Goods->where($whereq)->count();// 查询满足要求的总记录数
		$Page = new Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$goods = $Goods->limit($Page->firstRow.','.$Page->listRows)->where($whereq)->order('id DESC')->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		for ($i = 0,$ilen = count($goods);$i<$ilen;$i++){
			$str = trim($goods[$i]['images'],'|');
			$arr = explode('|',$str);
			$goods[$i]['images'] = $arr;
		}
		$this->query = $goods;
		$this->display();
	}
	public function xq()
	{
		$one = M('class')->where(array('pid'=>4,'show'=>array('NEQ',-1)))->select();
		foreach ($one as $key=>$v)
		{
			$two = M('class')->where(array('pid'=>$v['id'],'show'=>array('NEQ',-1)))->select();
			$one[$key]['two'] = $two;
		}
		$this->one = $one;
		$id = $_GET['id'];
		M('images')->where(array('id'=>$id))->setInc('clicknum');
		$goods = M('images')->field('title,images')->where(array('id'=>$id))->select();
		for ($i = 0,$ilen = count($goods);$i<$ilen;$i++){
			$str = trim($goods[$i]['images'],'|');
			$arr = explode('|',$str);
			$goods[$i]['images'] = $arr;
		}
		$this->goods = $goods;
		$this->display();
	}
	
}