<?php
return array(
	//'配置项'=>'配置值'
	//分类列表
	'APP_GROUP_LIST' => 'Index,Admin',
	//开启独立分组
	'APP_GROUP_MODE' => 1,
//	//默认分组
	'DEFAULT_GROUP' => 'Index',
	//分级文件夹名称
	'APP_GROUP_PATH' => 'Modules',
	'URL_MODEL'=>'2',
	'DB_HOST' => 'localhost',
	'DB_USER' => 'root',
	'DB_PWD' => '',
	'DB_NAME' => 'shop',
	'DB_PREFIX' => 'activity_',
	//开启显示调试信息
	// 'SHOW_PAGE_TRACE' => TRUE,
	//开启路由功能
	'URL_ROUTER_ON' => TRUE,
	//定义路由规则
	'URL_ROUTE_RULES' => array(
		'c/:cid\d' => 'Index/List/index',
		':id\d' => 'Index/Show/index'
		)
);
?>