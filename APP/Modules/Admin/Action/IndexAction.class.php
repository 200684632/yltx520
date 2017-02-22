<?php

class IndexAction extends CommonAction {
	public function index () {
	    $one = M('class')->where(array('pid'=>0))->select();
			foreach ($one as $k=>$v)
			{
				$two = M('class')->where(array('pid'=>$v['id'],'show'=>array('NEQ',-1)))->select();
				$one[$k]['two'] = $two;
			}
		$this->one = $one;
		$this->display();
	}
	public function copy() {
		$this->display();
	}
	//退出登录
	public function logout () {
		session_unset();
		session_destroy();
		$this->success('退出登陆', U('/Admin/Login'));
	}
	//增加管理员
    public function addadmin(){
        if(IS_POST){
            $accout = $_POST['accout'];
            $name = $_POST['username'];
            $password = $_POST['password'];
            $data = array(
                    'account'=>$accout,
                    'username'=>$name,
                    'password'=>md5($password)
            );
            if ($name){
                if ($password){
                      if ($accout){
                          $num = M('admin')->add($data);
                          if ($num){
                              $this->success('添加成功');
                          }else{
                              $this->error('添加失败');
                          }
                      }else{

                      }
                }else{
                    $this->error('密码不能为空');
                }
            }else{
                $this->error('用户名不能为空');
            }
        }else{
            $this->display();
        }
    }
	//报名
	public function bm(){
		if (IS_POST){
			$m = $_POST['m'];//月份
			$data = M('sign')->where(array('m'=>$m))->select();//查数据
			if (!$data){
				for ($i=1;$i<=$this->day($m);$i++){
					$id = $_POST['arrive'.$i];//内容
					if ($id){
						$num = M('sign')->data(array('day'=>$i,'placr'=>$id,'m'=>$m))->add();
					}else {
						$num = M('sign')->data(array('day'=>$i,'m'=>$m))->add();
					}
				}
			}else{
				for ($i=1;$i<$this->day($m);$i++){
					$id = $_POST['arrive'.$i];
					if ($id){
					$num = M('sign')->data(array('placr'=>$id))->where(array('day'=>$i,'m'=>$m))->save();
					}
				}
			}
			if ($num){
				$this->success('提交成功');
			}else {
				$this->error('提交失败');
			}
		}else{
			$this->display();
		}
	}
	public function day($month){
	if (in_array($month, array(1, 3, 5, 7, 8, 01, 03, 05, 07, 10, 12))) {
           return 31;  
	}elseif ($month == 2){  
            if (intval(date('Y')) % 400 == 0 || (intval(date('Y')) % 4 == 0 && intval(date('Y')) % 100 !== 0)) {        //鍒ゆ柇鏄惁鏄棸骞�  
                return 29;  
            } else {  
                return 28;  
            }  
        } else {  
            return 30;  
        }
	}
	//修改密码
	public function zhongxin(){
		if(IS_POST){
			$name = $_POST['name'];
			$psw = $_POST['psw'];
			$newpsw = $_POST['newpsw'];
			$newpsw1 = $_POST['newpsw1'];
			if ($newpsw == $newpsw1){
				$user = M('admin')->where(array('account'=>$name,'password'=>md5($psw)))->select();
				if ($user){
					$num = M('admin')->where(array('account'=>$name,'password'=>md5($psw)))->data(array('password'=>md5($newpsw)))->save();
					if ($num){
						$this->success('修改成功',U('Login/index'));
					}else{
						$this->error('修改失败');
					}
				}else{
					$this->error('用户名或者密码错误');
				}
			}else {
				$this->error('两次输入的新密码不一样');
			}
		}else{
			$this->display();
		}
	}
}