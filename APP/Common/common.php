<?php

function p ($arr) {
	echo '<pre>' . print_r($arr,true) . '</pre>';
}
/**
 * 递归组合一维数组的分类栏目
 */
function level($cate, $html = '->', $pid = 0, $level = 0) {
	$arr = array();
	foreach($cate as $v) {
		if ($v['pid'] == $pid) {
			$v['html'] = str_repeat($html, $level);
			$v['level'] = $level + 1;
			$arr[] = $v;
			$arr = array_merge($arr, level($cate, $html, $v['id'], $level + 1));
		}
	}
	return $arr;
}
/**
 * 传递一个分类ID返回所有子级分类ID
 * @param  [type] $cate [description]
 * @param  [type] $pid  [description]
 * @return [type]       [description]
 */
function getChildId($cate, $pid) {
	$arr = array();
	foreach ($cate as $v) {
		if ($v['pid'] == $pid) {
			$arr[] = $v['id'];
			$arr = array_merge($arr, getChildId($cate, $v['id']));
		}
	}
	return $arr;
}