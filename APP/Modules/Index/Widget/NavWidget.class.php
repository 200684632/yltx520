<?php

//导航条
class NavWidget extends Widget {
	public function render ($data) {
		$where = array('pid' => 0);
		$cate = M('category')->where($where)->order('sort')->select();
		foreach ($cate as $k => $v)
		{
			$where = array('pid' => $v['id']);
			$cate[$k]['child'] = M('category')->where($where)->order('sort')->select();
		}
		$data['cate'] = $cate;
		return $this->renderFile('nav', $data);
	}
}