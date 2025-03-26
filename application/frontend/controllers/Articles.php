<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends MY_ControllerTmpl {
	var $table="articles";
	var $table_top="articles_group";
	
	public function show($url){
		$item=$this->articles_model->get_by_fields(array("url"=>$url,'is_show'=>1,'is_block'=>0,));
		if(empty($item['id'])||$this->uri->segment(2)=='show'){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->articles_model->load_meta($item);		
		
		$this->template->write_view('content_main', 'articles/show', array(
			'item'=>$item,
			'parent'=>$this->articles_group_model->get_by_id($item['pid']),
			'breads'=>$this->articles_model->get_breads($item['id']),
		));
		$this->template->render();
	}
	
	public function show_group($url, $page_num=1){
		$item=$this->articles_group_model->get_by_fields(array("url"=>$url,'is_show'=>1,'is_block'=>0,));
		if(empty($item['id'])||$this->uri->segment(2)=='show_group'){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->articles_group_model->load_meta($item);

		$groups=$this->articles_group_model->get_page(array('is_block'=>0,'is_show'=>1,));
		$count=$this->articles_model->get_count(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],));
		
		$items=$this->articles_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],),($page_num-1)*10,10,'date desc');
		foreach($items as &$item_one){
			$item_one['unit']=$item['unit'];
		}
		$pager=$this->articles_model->get_pager(site_url($url), $count, 2, 10);
		
		$this->template->write_view('content_main', 'articles/show_items', array(
			'item'=>$item,
			'items'=>$items,
			'groups'=>$groups,
			'page_num'=>$page_num,
			'pager'=>$pager,
			'breads'=>$this->articles_group_model->get_breads($item['id']),
			'pid'=>$item['id'],
		));		
		
		$this->template->render();
	}
	
	public function show_all($page_num=1){
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(109);
		$this->articles_group_model->load_meta($item);

		$units=$this->articles_group_model->get_list(array('is_block'=>0,'is_show'=>1,),'id','unit');
		$groups=$this->articles_group_model->get_page(array('is_block'=>0,'is_show'=>1,));
		$count=$this->articles_model->get_count(array('is_block'=>0,'is_show'=>1,));
		
		$items=$this->articles_model->get_page(array('is_block'=>0,'is_show'=>1,),($page_num-1)*10,10,'date desc');
		foreach($items as &$item_one){
			$item_one['unit']=isset($units[$item_one['pid']])?$units[$item_one['pid']]:'';
		}
		$pager=$this->articles_model->get_pager(site_url('events'), $count, 2, 10);
		
		$this->template->write_view('content_main', 'articles/show_items', array(
			'item'=>$item,
			'items'=>$items,
			'groups'=>$groups,
			'page_num'=>$page_num,
			'pager'=>$pager,
			'breads'=>$this->articles_group_model->get_breads(0),
			'pid'=>0,
		));		
		
		$this->template->render();
	}
	
	
}
?>