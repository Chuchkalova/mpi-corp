<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class blocks extends MY_ControllerTmpl {
	var $table="blocks";
	var $table_top="blocks";
	
	public function search(){
		$search=trim($this->input->post('search'));
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(106);
		$this->blocks_model->load_meta($item);
		$items=array();
		$models=array('mains_model',);
		foreach($models as $model){
			$model=trim($model);
			$this->load->model($model);
			$items+=$this->{$model}->sql_search($search);
		}
		$this->template->write_view('content_main', 'blocks/search', array(
			'items'=>$items,
			'item'=>$item,
		));

		$this->template->render();
	}
	
}
?>