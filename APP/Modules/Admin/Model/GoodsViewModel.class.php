<?php
/**
 * 商品订单视图模型
 */
class GoodsViewModel extends ViewModel {
	protected $viewFields = array(
		'goods' => array(
			'id', 'name', '`unit`','price','pic','click','time','bid','cid','tid','uid',
			'_type' => 'LEFT'
			),
		'goods_attr' => array(
			'value','added','aid',
			'_on' => 'goods.id = goods_list.gid',
			'_type' => 'LEFT'
			),
		'detail' => array(
			'mini','medium','max','intro',
			'_on' => 'detail.gid = goods.id'
			)
		);
}