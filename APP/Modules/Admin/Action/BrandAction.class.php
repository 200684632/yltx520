<?php
/**
 * 品牌管理
 */
class BrandAction extends CommonAction
{
	public function index()
	{
		$Goods = M('images'); // 实例化User对象
		import('ORG.Util.Page');// 导入分页类
		$whereq = array('flag'=>array('NEQ',-1));
		$count = $Goods->where($whereq)->count();// 查询满足要求的总记录数
		$Page = new Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$goods = $Goods->limit($Page->firstRow.','.$Page->listRows)->where($whereq)->order('id DESC')->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		for ($i = 0,$ilen = count($goods);$i<$ilen;$i++){
			$str = trim($goods[$i]['images'],'|');
			$arr = explode('|',$str);
			$goods[$i]['images'] = $arr;
		}
		$this->goods = $goods;
		$this->display();
	}

	/**
	 * 添加品牌
	 */
	public function add()
	{
		if (IS_POST){
			$path = $_POST['path'];
			$type = $_POST['type'];
			$name = $_POST['name'];
			$describe = $_POST['describe'];
			if ($path)
			{
				if ($type)
				{
					if ($name)
					{
						$data = array('images'=>$path,'title'=>$name,'type'=>$type,'describe'=>$describe);
						$query = M('images')->add($data);
						if ($query)
						{
							$this->success('添加成功',U('index'));
						}else
						{
							$this->error('添加失败了');
						}
					}else 
					{
						$this->error('请输入主题');
					}
				}else 
				{
					$this->error('请选择类型');
				}
			}else
			{
				$this->error('请选择上传文件');
			}
		}else
		{
			$this->display();
		}
	}
	
	/**
	 * LOGO图片上传
	 */
	public function upload()
	{
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','mp4','mp3');// 设置附件上传类型
		$upload->savePath =  './Uploads/File/';// 设置附件上传目录
		if(!$upload->upload())	// 上传错误提示错误信息
		{
			echo json_encode(array(
				'status' => 0,
				'msg' => $upload->getErrorMsg()
				));
		}
		else 	// 上传成功 获取上传文件信息
		{
			$info =  $upload->getUploadFileInfo();
			echo json_encode(array(
				'status' => 1,
				'name' => $info[0]['savename']
				));
		}
	}
//	//详情
//	public function edit(){
//		$id = $_GET['id'];
//		$where = array('id'=>$id,'flag'=>array('NEQ',-1));
//		$query = M('images')->field('images,type')->where($where)->select();
//		$str = trim($query[0]['images'],'|');
//		$arr = explode('|',$str);
//		$query[0]['images'] = $arr;
//		var_dump($query);
//		$this->query = $query;
//		$this->display();
//	}
	public function del () {
		$id = (int) $_GET['id'];
		$where = array('id' => $id);
		$data  = array('flag'=>-1);
		$query = M('images ')->where($where)->save($data);
		if ($query){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败请重试！');
		}	
	}
	public function delone(){
		$id = $_GET['id'];
		$aid = $_GET['aid'];
		$query = M('images')->field('images')->where(array('id'=>$id))->select();
		$str = trim($query[0]['images'],'|');
		$arr = explode('|',$str);
//		for ($i = 0,$ilen = count($arr);$i<$ilen;$i++){
//			if ($i!=$aid){
//				array_push($data, $var);
//			}
//		}
		unset($arr[$aid]);
		$strsql = implode('|', $arr);
		$data = array('images'=>$strsql);
		$num = M('images')->where(array('id'=>$id))->save($data);
		if ($num) {
			$this->success('删除成功');
		}else {
			$this->error('删除失败');
		}
	}
}