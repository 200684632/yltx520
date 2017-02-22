<?php
/**
 * 感悟管理
 */
class FeelingAction extends CommonAction {
	public function index() {
		$type = $_GET['type'];
		$Goods = M('feeling'); // 实例化User对象
		import('ORG.Util.Page');// 导入分页类
		$whereq = array('flag'=>array('NEQ',-1),'type'=>$type);
		$count = $Goods->where($whereq)->count();// 查询满足要求的总记录数
		$Page = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$goods = $Goods->limit($Page->firstRow.','.$Page->listRows)->where($whereq)->order('id DESC')->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->goods = $goods;
		$this->display();
		
	}
	/**
	 * 详细内容
	 * Enter description here ...
	 */
	public function update(){
		if(isset($_GET['id'])){
			$where = array(
				'id'=>$_GET['id']
			);
			$goods =M('feeling')->where($where)->select();
			urldecode($goods);
			$this->goods = $goods;
			$this->display();
		}
	}
	/**
	 * 修改
	 * Enter description here ...
	 */
	public function updata1(){
		$where = array(
			'id'=>$_GET['id'],
		);
				import('ORG.Net.UploadFile');
		        $upload = new UploadFile();// 实例化上传类
		        $upload->maxSize  = 3145728 ;// 设置附件上传大小
		        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		        $upload->savePath = './Uploads/Images/';// 设置附件上传目录
		        if(!$upload->upload()) {// 上传错误提示错误信息
		//            $this->error('文件上传失败');
		        }else{ // 上传成功 获取上传文件信息
		            $info =  $upload->getUploadFileInfo();
		            $path = __ROOT__.'/Uploads/Images/'.$info[0]['savename'];
		        }
		if (!empty($_POST['name'])){
			if ($_POST['intro']){
				if ($path){
					$str = $_POST['intro'];
				if(get_magic_quotes_gpc())//如果get_magic_quotes_gpc()是打开的
				  {
					$str=stripslashes($str);//将字符串进行处理
				  }
					$data = array(
						'title'=>$_POST['name'],
						'content'=>$str,
						'creattime'=>$_POST['time'],
						'describe'=>$_POST['desc'],
						'image'=>$path
					);
				}else {
					$data = array(
						'title'=>$_POST['name'],
						'content'=>$_POST['intro'],
						'creattime'=>$_POST['time'],
						'describe'=>$_POST['desc'],
					);
				}
				$query  = M('feeling')->where($where)->save($data);
				if($query){
					$this->success('添加成功');
				}else {
					$this->error('修改失败');
				}
			}else{
				$this->error('内容不能为空');
			}
		}else{
			$this->error('标题不能为空');
		}
	}
	//添加活动
	public function add() {
		if (IS_POST){
				import('ORG.Net.UploadFile');
		        $upload = new UploadFile();// 实例化上传类
		        $upload->maxSize  = 3145728 ;// 设置附件上传大小
		        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		        $upload->savePath = './Uploads/Images/';// 设置附件上传目录
		        if(!$upload->upload()) {// 上传错误提示错误信息
		//            $this->error('文件上传失败');
		        }else{ // 上传成功 获取上传文件信息
		            $info =  $upload->getUploadFileInfo();
		            $path = __ROOT__.'/Uploads/Images/'.$info[0]['savename'];
		        }
			if ($_POST['type']){
				if (!empty($_POST['name'])){
					if (count($_POST['desc'])){
						$data = array(
							'title'=>$_POST['name'],
							'content'=>$_POST['intro'],
							'type'=>$_POST['type'],
							'creattime'=>$_POST['time'],
							'describe'=>$_POST['desc'],
							'image'=>$path
						);
						$query  = M('feeling')->add($data);
						if($query){
							$this->success('添加成功',U('index').'/type/'.$_POST['type']);
						}else {
							echo M('feeling')->getLastSql();
							$this->error('添加失败');
						}
					}else{
						$this->error('内容过长');
					}
				}else {
					$this->error('标题不能为空');
				}
			}else {
				$this->error('请选择类型');
			}
		}else {
			$this->display();
		}
	}
	//删除
	public function del () {
		$id = (int) $_GET['id'];
		$where = array('id' => $id);
		$data  = array('flag'=>-1);
		$query = M('feeling')->where($where)->save($data);
		if ($query){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败请重试！');
		}	
	}
//详细图片上传
	public function uploadIntro()
	{
		import('ORG.Net.UploadFile');
		// 实例化上传类
		$upload = new UploadFile();
		//大小
		$upload->maxSize = 1000*1024;
		//允许上传类型
		$upload->allowExts = array('jpg','gif','png','jpeg');
		// 设置附件上传目录
		$upload->savePath =  './Uploads/Images/';
		// 使用子目录保存
		$upload->autoSub = true;
		// 使用日期函数生成子目录
		$upload->subType = 'date';
		// 日期格式
		$upload->dateFormat = 'Ym';
		if (!$upload->upload())
		{
			$a = array('error' => 1, "message" => $upload->getError());
			$this->ajaxReturn($a);
				exit();
		}
		else
		{
			$info = $upload->getUploadFileInfo();
			$a = array('error' => 0, 'url' => '/Uploads/Images/'.$info[0]['savename']);
			$this->ajaxReturn($a);
			exit();
		}
	}
	//获取配置信息
	public function cofmsg()
	{
		$goods = M('cofmsg')->where(array('id'=>1))->select();
		$this->goods = $goods;
		$this->display();
		
	}
	//修改配置信息
	public function upcofmsg()
	{
		$title = $_POST['zhuti'];
		$key = $_POST['company'];
		$km = $_POST['km'];
		$money = $_POST['money'];
		$day = $_POST['date'];
		$describe = $_POST['content'];
		$query = M('cofmsg')->where(array('id'=>1))->save(array('title'=>$title,'key'=>$key,'km'=>$km,'money'=>$money,'day'=>$day,'describe'=>$describe));
		if ($query)
		{
			$this->success('配置信息更新成功');
		}else
		{
			$this->success('配置信息更新失败');
		}
	}
}