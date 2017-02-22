<?php
class IndexAction extends Action{
	public function index()
	{
		$query = M('cofmsg')->where(array('id'=>1))->select();
		session('title',$query[0]['title']);
		session('key',$query[0]['key']);
		session('describe',$query[0]['describe']);
		session('day',$query[0]['day']);
		session('km',$query[0]['km']);
		session('money',$query[0]['money']);
		$this->display();
	}
	public function yltx(){
		$one = M('class')->where(array('pid'=>1,'show'=>array('NEQ',-1)))->select();
		foreach ($one as $key=>$v)
		{
			$two = M('article')->where(array('pid'=>$v['id'],'show'=>array('NEQ',-1)))->select();
			$one[$key]['two'] = $two;
		}
		$this->one = $one;
		$id = $_GET['id']?$_GET['id']:$one[0]['two'][0]['id'];
		$query = M('article')->where(array('id'=>$id))->select();
		$this->query = $query;
		$this->display();
	}
	//刘佩详情
	public function lp(){
		$one = M('class')->where(array('pid'=>2,'show'=>array('NEQ',-1)))->select();
		foreach ($one as $key=>$v)
		{
			$two = M('article')->where(array('pid'=>9))->select();
			$one[$key]['two'] = $two;
			break;
		}
		$this->one = $one;
		$id = $_GET['id']?$_GET['id']:$one[0]['two'][0]['id'];
		$query = M('article')->where(array('id'=>$id))->select();
		$this->query = $query;
		$this->display();
	}
	public function nwtx(){
		$this->display();
	}
	public function cy(){
		$this->display();
	}
}