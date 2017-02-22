<?php
/**
 * 商品添加关联模型
 */
class GoodsRelationModel extends RelationModel
{
	//主表名称
	protected $tableName = 'goods';

	//关联
	protected $_link = array(
		'detail' => array(
			'mapping_type' => HAS_ONE,
			'foreign_key' => 'gid'
			),
		'goods_attr' => array(
			'mapping_type' => HAS_MANY,
			'foreign_key' => 'gid'
			)
		);
}