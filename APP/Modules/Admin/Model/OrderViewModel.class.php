<?php
/**
 * 商品订单视图模型
 */
class OrderViewModel extends ViewModel {
	protected $viewFields = array(
		'order_list' => array(
			'quantity', 'subtotal', '`explain`','gid','artnumber',
			'_type' => 'LEFT'
			),
		'goods' => array(
			'name','pic','price',
			'_on' => 'goods.id = order_list.gid'
			)
		);
}