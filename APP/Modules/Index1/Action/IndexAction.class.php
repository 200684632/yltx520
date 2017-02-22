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
	//
	public function yltx(){
		$id = $_GET['id']?$_GET['id']:38;
		M('feeling')->where(array('id'=>$id))->setInc('clicknum');
		$query = M('feeling')->where(array('id'=>$id,'flag'=>array('NEQ',-1)))->select();
		$this->query = $query;
		$this->display();
	}
	//刘佩详情
	public function lp(){
		M('lp')->where(array('name'=>'刘佩'))->setInc('clicknum');
		$query = M('lp')->where(array('name'=>'刘佩'))->select();
		$this->query = $query;
		$this->display();
	}
	public function nwtx(){
		$this->display();
	}
}