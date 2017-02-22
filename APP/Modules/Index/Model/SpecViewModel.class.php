<?php
/**
 * 商品规格视图模型
 */
class SpecViewModel extends ViewModel {
	protected $viewFields = array(
		'goods_attr' => array(
			'id', 'value',
			'_type' => 'INNER'
			),
		'type_attr' => array(
			'name',
			'_on' => 'goods_attr.aid = type_attr.id'
			)
		);
}