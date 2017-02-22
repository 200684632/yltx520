<?php
class CommonAction extends Action {
	public function _initialize () {
		//解决UPLOADIFY在某些浏览中掉失SESSION的问题
		if (isset($_POST[session_name()]) && empty($_SESSION)) {
			session_destroy();
			session_id($_POST[session_name()]);
			session_start();
		}
		if (!isset($_SESSION['adminuid'])) {
			$this->redirect(GROUP_NAME . '/Login/index');
		}
	}

	/**
	 * 排序
	 */
	public function sort () {
		$table = array_pop($_POST);
		$db = M($table);
		foreach($_POST as $k => $v) {
			$db->save(array(
				'id' => $k,
				'sort' => $v
				));
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
}