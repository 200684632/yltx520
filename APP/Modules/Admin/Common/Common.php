<?php
function oneimg($imgname){
		$arr = array('jpg','png','gif','jpeg');
		$img = $_FILES[$imgname]['name'];
		$str = substr($img, strrpos($img, '.')+1);
		if(in_array($str, $arr) &&
		 $_FILES['photo']['size']<=200*1024)
		{
			$way = 'Uploads/author/'.uniqid().'.'.$str;
			move_uploaded_file($_FILES['photo']['tmp_name'],
			$way);
			return '/shop/'.$way; 
		}
	}