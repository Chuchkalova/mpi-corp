<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class settings extends MY_Table {
	protected $table='settings';
	protected $table_top='settings';
	protected $controller="settings";
	
	public function set_region(){
		$this->session->set_userdata('region',$this->input->post('regions'));
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function delete_file($item_id, $file){
		if(!$this->check_permissions('edit')){
			redirect('login/');
			return;
		}
		$file=base64_decode($file);
		$file_s=str_replace("_l.","_s.",$file);
		@unlink($_SERVER['DOCUMENT_ROOT'].$file);
		
		$file_pattern=str_replace("dir_images/","dir_images/*",$_SERVER['DOCUMENT_ROOT'].$file);
		foreach (glob($file_pattern) as $filename) {
			@unlink($filename);
		}
		
		if(strpos($file, "group")!==false){
			$module="edit_group";
		}
		else{
			$module="edit";
		}
		
		$this->settings_model->update($item_id,array('value'=>'',));
		
		redirect($this->controller."/$module/$item_id/");
	}
}
?>