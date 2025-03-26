<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menus extends MY_Table {
	protected $table='menus';
	protected $table_top='menus_group';
	protected $controller="menus";
	
	public function ajax(){
		$post=$this->input->post();
		
		if(isset($post['item_id'])){
			$menu_item=$this->{$post['type']."_model"}->get_by_id($post['item_id']);
			if(isset($menu_item['element_id'])){
				$post['item_id']=$menu_item['element_id'];
				$post['url_this']=$menu_item['url_this'];
				if(isset($post['is_init'])&&$post['is_init']=="true"){
					$post['is_module_top']=$menu_item['is_module_top'];
				}
			}
		}
		
		if($post['module_id']==0){
			$is_module_top=$this->menus_model->empty_select();
		}
		else{
			$is_module_top=$this->menus_model->get_is_module_top_by_module($post['module_id']);
			if(count($is_module_top)==1){
				$post['is_module_top']=key($is_module_top);
			}
		}
		
		if($post['is_module_top']==0||$post['module_id']==0){
			$ret=$this->menus_model->empty_select();
			$special=$this->menus_model->empty_select();
		}
		else{
			$ret=$this->menus_model->get_names_by_module($post['module_id'], 2-$post['is_module_top']);
			$special=$this->menus_model->get_special_by_module($post['module_id'], 2-$post['is_module_top']);
		}
		
		$return="";
		foreach($ret as $opt=>$val){
			$selected="";
			if($post['item_id']==$opt){
				$selected=" selected='selected' ";
			}
			$return.="<option value='$opt' $selected>$val</option>";
		}
		
		$special_return="";
		foreach($special as $opt=>$val){
			$selected="";
			if($post['url_this']==$opt){
				$selected=" selected='selected' ";
			}
			$special_return.="<option value='$opt' $selected>$val</option>";
		}
		
		$is_module_top_return="";
		foreach($is_module_top as $opt=>$val){
			$selected="";
			if($post['is_module_top']==$opt){
				$selected=" selected='selected' ";
			}
			$is_module_top_return.="<option value='$opt' $selected>$val</option>";
		}
		
		echo json_encode((object)array(
			'elements' => $return,
			'special' => $special_return,
			'is_module_top' => $is_module_top_return,
		));
	}
}
?>