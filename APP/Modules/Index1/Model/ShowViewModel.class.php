<?php
/**
 * 商品展示视图模型
 */
class ShowViewModel extends ViewModel
{
	protected $viewFields = array(
		'goods' => array(
			'id', 'name', 'unit', 'market', 'price', 'click', 'time',
			'_type' => 'LEFT'
			),
		'detail' => array(
			'mini', 'medium', 'max', 'intro',
			'_on' => 'goods.id = detail.gid',
			'_type' => 'LEFT'
			)
		);
}