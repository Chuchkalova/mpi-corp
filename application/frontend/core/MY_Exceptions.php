<?php
class MY_Exceptions extends CI_Exceptions {
	public function show_404($page = '', $log_error = TRUE){
		$CI =& get_instance();
		
		header("HTTP/1.1 404 Not Found");
		$CI->load->model('mains_model');
		$item=$CI->mains_model->get_by_id(2);	
		$CI->mains_model->load_meta($item);
		
		$CI->template->write_view('content_main', 'mains/page404', array(
			'item'=>$item,
		));
		
		echo $CI->template->render('', TRUE);
	}
}
?>