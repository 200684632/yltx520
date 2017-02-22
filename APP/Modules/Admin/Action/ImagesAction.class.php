<?php
class ImagesAction extends CommonAction{
	public function index()
	{
		$this->display('add');
	}
	//图片页面展示
	public function imgview()
	{
		$Goods = M('images'); // 实例化User对象
		$whereq = array('flag'=>array('NEQ',-1));
		import('ORG.Util.Page');// 导入分页类
		$count = $Goods->where($whereq)->count();// 查询满足要求的总记录数
		$Page = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$goods = $Goods->limit($Page->firstRow.','.$Page->listRows)->where($whereq)->order('id DESC')->select();
		for ($i = 0,$ilen = count($goods);$i<$ilen;$i++){
			$arr = explode(',', $goods[$i]['images']);
				$array = array();
				foreach ($arr as $v)
				{
					if ($v)
					{
						$v = '/Uploads/photo/'.$v;
						array_push($array, $v);
					}
				}
			$goods[$i]['image'] = $array;
		}
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->goods = $goods;
		$this->display();
	}
	//图片路径
	public function update()
	{
		if(isset($_GET['id']))
		{
			$where = array(
				'id'=>$_GET['id']
			);
			$goods = M('images')->field('images')->where($where)->select();
			$arr = explode(',', $goods[0]['images']);
			$array = array();
			foreach ($arr as $v)
			{
				if ($v)
				{
					$v = '/shop/Uploads/photo/'.$v;
					array_push($array, $v);
				}
			}
			$goods = $array;
			$this->goods = $goods;
			$this->display();
		}
	}
	//上传图片
	public function add() 
	{
			$str = '';
			$path = $_POST['max'];
			$title = $_POST['title'];
			if ($title)
			{
				if (isset($path))
				{
					for ($i = 0,$ilen = count($path);$i<$ilen;$i++){
						$str.=','.$path[$i];
					}
					$data = array(
							'title'=>$title,
							'images'=>$str
					);
					$query = M('images')->add($data);
					if ($query)
					{
						$this->success('添加成功',U('imgview'));
					}else 
					{
						$this->error('添加失败');
					}
				}else
				{
					$this->error('你还没有选择图片');
				}
			}else
			{
				$this->error('你标题不能为空');
			}
	}
	//商品图册上传
	public function uploadPhoto()
	{
		import('ORG.Net.UploadFile');
		// 实例化上传类
		$upload = new UploadFile();
		// 设置附件上传目录
		$upload->savePath =  './Uploads/Photo/';
		// 使用子目录保存
		$upload->autoSub = true;
		// 使用日期函数生成子目录
		$upload->subType = 'date';
		// 日期格式
		$upload->dateFormat = 'Ym';
		// 生成缩略图
		$upload->thumb = false;
		// 缩略图宽度
		$upload->thumbMaxWidth = '400,100';
		// 缩略图高度
		$upload->thumbMaxHeight = '400,100';
		// 缩略图前缀名
		$upload->thumbPrefix = 'medium_,mini_';

		if (!$upload->upload())
		{
			echo json_encode(array(
				'status' => 0,
				'msg' => $upload->getErrorMsg()
				));
		}
		else
		{
			$info = $upload->getUploadFileInfo();
			var_dump($info);
			$max = $info[0]['savename'];
			$path = explode('/', $max);
			$imgpath = $path[0].'/'.$path[1];
			$medium = $path[0] . '/medium_' . $path[1];
			$mini = $path[0] . '/mini_' . $path[1];
			echo json_encode(array(
				'info'=>$info,
				'imgpath'=>$imgpath,
				'status' => 1,
				'max' => $max,
				'medium' => $medium,
				'mini' => $mini
				));
		}
	}

	//删除图册
	public function delPhoto() 
	{
		$state = true;
		foreach ($_POST as $v) 
		{
			if (!unlink('./Uploads/Photo/' . $v)) 
			{
				$state = false;
			}
		}

		echo $state ? 1 : 0;	
	}
	
	public function del()
	{
		$id = (int) $_GET['id'];
		$where = array('id' => $id);
		$data  = array('flag'=>-1);
		$query = M('images')->where($where)->save($data);
		if ($query){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败请重试！');
		}	
	}
}
