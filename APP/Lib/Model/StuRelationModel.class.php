<?php

class StuRelationModel extends RelationModel {
	//定义主表名称
	protected $tableName = 'stu';

	protected $_link = array(
		'stuinfo' => array(
			'mapping_type' => HAS_ONE,
			'foreign_key' => 'uid'
			)
		);
}