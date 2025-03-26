<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class programs extends MY_Table {
	protected $table='programs';
	protected $table_top='programs';
	protected $controller="programs";
	
	public function delete($item_id, $is_referer=0){
		$this->variant_model=$this->model;
		if(!$this->check_permissions('delete')){
			redirect("/permission/");
			return;
		}
		
		$item=$this->{$this->model}->get_by_fields(array('id' => $item_id));
		$this->{$this->model}->block($item_id);
		redirect("educations/edit/{$item['pid']}/");
	}
}
?>