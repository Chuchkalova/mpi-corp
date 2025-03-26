<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class gallerys extends MY_Table {
	protected $table='gallerys';
	protected $table_top='gallerys_group';
	protected $controller="gallerys";
	
	public function save_to_gallery(){
		$data=$this->input->post();
		if(isset($data['gallery_id'])&&isset($data['file_name'])){
			if($data['gallery_id']!=-1){
				echo $this->gallerys_model->save_to_gallery($data['gallery_id'],$data['file_name']);
			}
		}
		else{
			echo "-1";
		}
	}
}
?>