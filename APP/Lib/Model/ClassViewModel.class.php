<?php

class ClassViewModel extends ViewModel {

	protected $viewFields = array(
		'class' => array(
			'id','name',
			'_type' => 'LEFT'
			),
		'stu' => array(
			'id' => 'cid','username',
			'_on' => 'class.id = stu.cid'
			)
		);
}