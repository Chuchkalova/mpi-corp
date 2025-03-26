<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class gallerys extends MY_ControllerTmpl {
	var $table="gallerys";
	var $table_top="gallerys_group";
	
	public function show_group($url, $page_num=1){
		$this->load->model('gallerys_group_model');
		$item=$this->gallerys_group_model->get_by_fields(array('url'=>$url,'is_show'=>1,'is_block'=>0,));
		if(empty($item['id'])){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->gallerys_group_model->load_meta($item);
			
		$items=$this->gallerys_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],), null, null, "order");
		foreach($items as &$item_one){
			$item_one['items']=$this->gallerys_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item_one['id'],), 0, 4, "order");
		}
		
		$this->template->write_view('content_main', 'gallerys/show_items', array(
			'items'=>$items,
			'item'=>$item,	
			'breads'=> $this->gallerys_group_model->get_breads($item['id']),
		));
		
		$this->template->render();
	}
	
	
}
?>