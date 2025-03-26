<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page404 extends MY_ControllerTmpl {
	var $table="mains";
	var $table_top="mains";
	
	public function index(){	
		header("HTTP/1.1 404 Not Found");
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(2);	
		$this->mains_model->load_meta($item);
		
		$this->template->write_view('content_main', 'mains/page404', array(
			'item'=>$item,
		));
		
		echo $this->template->render('', TRUE);
	}

}
?>