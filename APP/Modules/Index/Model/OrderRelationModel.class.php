<?php
/**
 * 商品添加关联模型
 */
class OrderRelationModel extends RelationModel
{
	//主表名称
	protected $tableName = 'order';

	//关联
	protected $_link = array(
		'order_list' => array(
			'mapping_type' => HAS_MANY,
			'foreign_key' => 'oid'
			)
		);
}