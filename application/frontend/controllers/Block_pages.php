<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class block_pages extends MY_ControllerTmpl {
	var $table="block_pages";
	var $table_top="block_pages_group";
	
	public function show($url){
		$item=$this->block_pages_group_model->get_by_fields(array("url"=>$url,'is_show'=>1,'is_block'=>0,'type'=>'item',));
		if(empty($item['id'])){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		
		$this->load->model('catalogs_group_model');
		$catalog=$this->catalogs_group_model->get_by_id(1);
		
		$this->block_pages_group_model->load_meta($item);		
		$items=$this->block_pages_group_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item['id'],),null,null,'order');
		foreach($items as &$item_one){
			$items2=$this->block_pages_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item_one['id'],),null,null,'order');
			$item_one['renreded']=$this->load->view('block_pages/blocks/'.$item_one['type'], array(
				'item'=>$item_one,
				'items'=>$items2,
				'catalog'=>$catalog,
			),true);
		}
		
		$this->template->write_view('content_main', 'block_pages/show', array(
			'item'=>$item,
			'items'=>$items,
			'breads'=>$this->block_pages_group_model->get_breads($item['id']),
		));
		$this->template->write('js','<script src="/js/slick.min.js"></script>');
		$this->template->write('css','<link rel="stylesheet" href="/css/slick.css">'); 
		$this->template->render();
	}
	
}
?>