<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class texts extends MY_ControllerTmpl {
	var $table="texts";
	var $table_top="texts_group";
	var $pages=10;
	
	public function show($url){
		$item=$this->texts_model->get_by_fields(array("url"=>$url,'is_show'=>1,'is_block'=>0,));
		if(!$item['id']){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->texts_model->load_meta($item);

		$config=$this->texts_group_model->config();
		$item['gallery']="";
		if($config['fields']['gallery_id']['is_active']){
			$this->load->model('gallerys_group_model');
			$item['gallery']=$this->gallerys_group_model->get_page(array('is_block'=>0,'pid'=>$item['gallery_id'],'is_show'=>1,),null,null,'order');
		}
		
		$this->template->write_view('content_main', 'texts/show', array(
			'item'=>$item,
		));
		$this->template->write('breads', $this->texts_model->get_breads($item['id']));
		
		$this->template->render();
	}
	
	public function show_group($url, $page_num=1){
		$this->load->model('texts_group_model');
		$item=$this->texts_group_model->get_by_fields(array('url'=>$url,'is_show'=>1,'is_block'=>0,));
		if(!$item['id']){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->texts_group_model->load_meta($item);
		
		$config=$this->texts_group_model->config();
		$item['gallery']="";
		if($config['fields']['gallery_id']['is_active']){
			$this->load->model('gallerys_group_model');
			$item['gallery']=$this->gallerys_group_model->get_page(array('is_block'=>0,'pid'=>$item['gallery_id'],'is_show'=>1,),null,null,'order');
		}
		
		$count=$this->texts_group_model->get_count(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],));
		if($count){
			$items=$this->texts_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],),null,null,"order");
			$this->template->write_view('content_main', 'texts/show_groups', array(
				'items'=>$items,
				'item'=>$item,
			));
		}
		else{
			$count=$this->texts_model->get_count(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],));
			$pager=$this->texts_model->get_pager(site_url("/texts/show_group/{$item['url']}/"), $count, 4, $this->pages);
			$items=$this->texts_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],), null, null, "order");
			
			$this->template->write_view('content_main', 'texts/show_items', array(
				'items'=>$items,
				'pager'=>$pager,
				'item'=>$item,				
			));
		}
		
		$this->template->write('breads', $this->texts_group_model->get_breads($item['id']));
		$this->template->render();
	}	
	
	public function show_all($page_num=1){
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(101);
		$this->mains_model->load_meta($item);
	
		$count=$this->texts_group_model->get_count(array('is_block'=>0,'is_show'=>1,'pid'=>0,));
		if($count){
			$items=$this->texts_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>0,),null,null,"order");
			$this->template->write_view('content_main', 'texts/show_groups', array(
				'items'=>$items,
				'item'=>$item,
			));
		}
		else{
			$count=$this->texts_model->get_count(array('is_block'=>0,'is_show'=>1,'pid'=>0,));
			$pager=$this->texts_model->get_pager(site_url("/texts/show_all/"), $count, 3, $this->pages);
			$items=$this->texts_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],), null, null, "order");
			
			$this->template->write_view('content_main', 'texts/show_items', array(
				'items'=>$items,
				'pager'=>$pager,
				'item'=>$item,				
			));
		}

		$this->template->write('breads', $this->texts_group_model->get_breads(0));
		$this->template->render();
	}
}
?>