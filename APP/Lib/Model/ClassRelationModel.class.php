<?php

class ClassRelationModel extends RelationModel {
	//定义主表名称
	protected $tableName = 'class';
	//定义关联关系
	protected $_link = array(
		'stu' => array(
			//关联关系 HAS_ONE , HAS_MANY
			'mapping_type' => HAS_MANY,
			'foreign_key' => 'cid'
			)
		);
}