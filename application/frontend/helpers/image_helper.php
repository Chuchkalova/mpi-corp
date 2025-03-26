<?php

function crop_image($filename, $move_x=0, $move_y=0, $move_width=0,$move_height=0){
	if(!is_dir($_SERVER['DOCUMENT_ROOT']."/dir_images/crop_images/{$move_x}x{$move_y}x{$move_width}x{$move_height}")){
		mkdir($_SERVER['DOCUMENT_ROOT']."/dir_images/crop_images/{$move_x}x{$move_y}x{$move_width}x{$move_height}");
	}
	$CI = get_instance();
	$CI->load->library('image_moo');
		
	$form=$_SERVER['DOCUMENT_ROOT']."/dir_images/".$filename;
	$to=$_SERVER['DOCUMENT_ROOT']."/dir_images/crop_images/{$move_x}x{$move_y}x{$move_width}x{$move_height}/".$filename;
	if(!file_exists($to)){
		@copy($form,$to);
		$CI->image_moo
			->load($to)
			->crop($move_x,$move_y,$move_x+$move_width,$move_y+$move_height)
			->save($to, true);
	}
}

function get_image($module, $field_name, $item_id, $resize_x=0, $resize_y=0, $method="fixed", $move_x=0, $move_y=0, $move_width=0, $move_height=0){
	$extensions=array("jpg","png","jpeg","gif","svg");
	if($move_width&&$move_height){
		$file_prefix="{$module}_{$field_name}_{$item_id}_l.";
		foreach($extensions as $extension_one){
			if(file_exists($_SERVER['DOCUMENT_ROOT']."/dir_images/".$file_prefix.$extension_one)){
				crop_image($file_prefix.$extension_one, $move_x, $move_y, $move_width,$move_height);
			}
		}
	}
	
	if(!$resize_x||!$resize_y){
		$file_prefix="/dir_images/{$module}_{$field_name}_{$item_id}_l.";
		foreach($extensions as $extension_one){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$file_prefix.$extension_one)){
				return $file_prefix.$extension_one;
			}
		}
	}
	else{
		if(!is_dir($_SERVER['DOCUMENT_ROOT']."/dir_images/{$resize_x}x{$resize_y}")){
			mkdir($_SERVER['DOCUMENT_ROOT']."/dir_images/{$resize_x}x{$resize_y}");
		}
		$ext="";
		$file_prefix="/dir_images/{$module}_{$field_name}_{$item_id}_l.";
		foreach($extensions as $extension_one){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$file_prefix.$extension_one)){
				$ext=$extension_one;
				break;
			}
		}
		
		$from_filename="/dir_images/{$module}_{$field_name}_{$item_id}_l.".$ext;
		$to_filename="/dir_images/{$resize_x}x{$resize_y}/{$module}_{$field_name}_{$item_id}_l.".$ext;		
		if($move_width&&$move_height){
			$from_filename="/dir_images/crop_images/{$move_x}x{$move_y}x{$move_width}x{$move_height}/{$module}_{$field_name}_{$item_id}_l.".$ext;
			$to_filename="/dir_images/crop_images/{$move_x}x{$move_y}x{$move_width}x{$move_height}/{$resize_x}x{$resize_y}/{$module}_{$field_name}_{$item_id}_l.".$ext;
			if(!is_dir($_SERVER['DOCUMENT_ROOT']."/dir_images/crop_images/{$move_x}x{$move_y}x{$move_width}x{$move_height}/{$resize_x}x{$resize_y}")){
				mkdir($_SERVER['DOCUMENT_ROOT']."/dir_images/crop_images/{$move_x}x{$move_y}x{$move_width}x{$move_height}/{$resize_x}x{$resize_y}");
			}
		}
		
		if($ext){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$to_filename)){
				return $to_filename;
			}
			else{
				$CI = get_instance();
				$CI->load->library('image_moo');
				$form=$_SERVER['DOCUMENT_ROOT'].$from_filename;
				$to=$_SERVER['DOCUMENT_ROOT'].$to_filename;
				@copy($form,$to);
				if($method=="resize"){
					$CI->image_moo
						->load($form)
						->resize($resize_x,$resize_y)
						->save($to, true);
				}
				else if($method=="fixed"){
					$CI->image_moo
						->load($form)
						->set_background_colour("#ffffff")
						->resize($resize_x,$resize_y, true)
						->save($to, true);
				} 
				else if($method=="crop"){
					$CI->image_moo
						->load($form)
						->resize_crop($resize_x,$resize_y)
						->save($to, true);
				}
				return $to_filename;;
			}
		}
	}
	return "/site_img/null.png";
}

function get_file($module, $field_name, $item_id){
	$extensions=explode("|",'jpg|png|gif|jpeg|doc|docx|pdf|xls|xlsx|pdf');
	$file_prefix="{$module}_{$field_name}_{$item_id}_l.";
	foreach($extensions as $extension_one){
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/dir_images/".$file_prefix.$extension_one)){
			return "/dir_images/".$file_prefix.$extension_one;
		}
	}
	return '';
}


?>