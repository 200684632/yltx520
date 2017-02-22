<?php
class PoetryAction extends CommonAction{
	public function index(){
		$Goods = M('poetry'); // 实例化User对象
		import('ORG.Util.Page');// 导入分页类
		$whereq = array('flag'=>array('NEQ',-1),'pid'=>0);
		$count = $Goods->where($whereq)->count();// 查询满足要求的总记录数
		$Page = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$goods = $Goods->limit($Page->firstRow.','.$Page->listRows)->where($whereq)->order('id DESC')->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->goods = $goods;
		$this->display();
	}
	//添加诗集
	public function add(){
		if (IS_POST){
	        $name = $_POST['name'];
	        $intro = $_POST['intro'];
	        $text = $_POST['text'];
	        $id = $_POST['id'];
	        if ($name){
	        	if ($intro){
		        	$data = array('author'=>$name,'content'=>$intro,'pid'=>$id,'title'=>$text);
		        	$query = M('poetry')->add($data);
		        	if ($query){
		        		$this->success('添加成功',U('index'));
		        	}else {
		        		$this->error('添加失败');
		        	}
	        	}else{
	        		$this->error('内容不能为空');
	        	}
	        }else{
	        	$this->error('诗名不能为空');
	        }
		}else{
				$where = array('id'=>$_GET['id']);
				$query = M('poetry')->field('id')->where($where)->select();
				$this->goods = $query;
				$this->display();
			}
		}
		//详情页面
		public function xq(){
			$id = $_GET['id'];
			$query = M('poetry')->where(array('id'=>$id,'flag'=>array('NEQ',-1)))->select();
			$this->goods = $query;
			$this->display();
		}
		public function sjlb(){
			$id = $_GET['id'];
			$query = M('poetry')->where(array('pid'=>$id,'flag'=>array('NEQ',-1)))->order('id desc')->select();
			$this->goods = $query;
			$this->display();
		}
		//编辑作者
		public function updataauthor(){
			if (IS_POST)
			{
				import('ORG.Net.UploadFile');
		        $upload = new UploadFile();// 实例化上传类
		        $upload->maxSize  = 3145728 ;// 设置附件上传大小
		        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		        $upload->savePath = './Uploads/author/';// 设置附件上传目录
		        if(!$upload->upload()) {// 上传错误提示错误信息
		//            $this->error('文件上传失败');
		        }else{ // 上传成功 获取上传文件信息
		            $info =  $upload->getUploadFileInfo();
		            $path = __ROOT__.'/Uploads/author/'.$info[0]['savename'];
		        }
		        $id = $_POST['id'];
		        $author = $_POST['name'];
				$content = $_POST['text'];
				$image = $path;
				if ($image){
					$data = array('author'=>$author,'content'=>$content,'image'=>$image);
				}else{
					$data = array('author'=>$author,'content'=>$content);
				}
				$num = M('poetry')->where(array('id'=>$id))->save($data);
				if ($num){
					$this->success('修改成功',U('index'));
				}else{
					$this->error('修改失败');
				}
			}else
			{
				$id = $_GET['id'];
				$query = M('poetry')->where(array('id'=>$id))->select();
				$this->query = $query;
				$this->display();
			}
		}
		//修改诗集
		public function update(){
			$id = $_GET['id'];
			$name = $_POST['name'];
	        $content = $_POST['intro'];
	        $text = $_POST['text'];
	        $data = array('author'=>$name,'content'=>$content,'title'=>$text);
	        $query = M('poetry')->where(array('id'=>$id))->save($data);
	        if ($query){
	        	$this->success('修改成功',U('index'));
	        }else{
	        	$this->error('修改失败');
	        }
		}
		//添加诗人
		public function author(){
			if (IS_POST){
				import('ORG.Net.UploadFile');
		        $upload = new UploadFile();// 实例化上传类
		        $upload->maxSize  = 3145728 ;// 设置附件上传大小
		        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		        $upload->savePath = './Uploads/author/';// 设置附件上传目录
		        if(!$upload->upload()) {// 上传错误提示错误信息
		//            $this->error('文件上传失败');
		        }else{ // 上传成功 获取上传文件信息
		            $info =  $upload->getUploadFileInfo();
		            $path = __ROOT__.'/Uploads/author/'.$info[0]['savename'];
		        }
				$name = $_POST['name'];
				$content = $_POST['text'];
				$image = $path;
				if ($name){
					if ($content){
						$data = array('author'=>$name,'content'=>$content,'image'=>$image,'pid'=>0);
						$query = M('poetry')->add($data);
						if ($query){
							$this->success('添加成功',U('index'));
						}else{
							$this->error('添加失败，请重试');
						}
					}else{
						$this->error('多少来点介绍吧');
					}
				}else{
					$this->error('姓名不能为空');
				}
			}else {
				$this->display();
			}
		}
		//删除整行
		public function del(){
			$id = $_GET['id'];
			$query = M('poetry')->where(array('id'=>$id))->save(array('flag'=>-1));
			if ($query) {
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
}