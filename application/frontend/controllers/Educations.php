<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class educations extends MY_ControllerTmpl {
	var $table="educations";
	var $table_top="educations_group";
	
	public function show_all(){		
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(200);
		
		$this->educations_group_model->load_meta($item);		
		$items=$this->educations_group_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>0,),null,null,'order');

		$this->load->model('gallerys_model');
		$gallerys=$this->gallerys_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>6,),null,null,'order');
		
		$this->load->model('texts_model');
		$this->load->model('texts_group_model');
		$texts=$this->texts_group_model->get_by_id(4);
		$texts['items']=$this->texts_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>4,),null,null,'order');
		
		$this->template->write_view('content_main', 'educations/show_all', array(
			'item'=>$item,
			'items'=>$items,
			'texts'=>$texts,			
			'gallerys'=>$gallerys,
			'breads'=>$this->educations_group_model->get_breads(0),
		));
		$this->template->write('top10','second-page-template');
		$this->template->write('top9', 'second-page-header');
		$this->template->write('js','<script src="/js/slick.min.js"></script>');
		$this->template->write('css','<link rel="stylesheet" href="/css/slick.css">'); 
		$this->template->render();
	}
	
	public function show_group($url){
		$item=$this->educations_group_model->get_by_fields(array("url"=>$url,'is_show'=>1,'is_block'=>0,));
		if(empty($item['id'])){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->educations_group_model->load_meta($item);

		$items=$this->educations_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],),null,null,'order');
		foreach($items as &$item_one){
			$item_one['items']=$this->educations_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item_one['id'],),null,null,'order');
		}

		$this->template->write_view('content_main', 'educations/show_group', array(
			'item'=>$item,
			'items'=>$items,
			'breads'=>$this->educations_group_model->get_breads($item['id']),
		));		
		
		$this->template->render();
	}
	
	public function show($url){
		$item=$this->educations_model->get_by_fields(array("url"=>$url,'is_show'=>1,'is_block'=>0,));
		if(empty($item['id'])){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->educations_model->load_meta($item);

		$this->load->model('programs_model');
		$programs=$this->programs_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item['id'],),null,null,'order');
		
		$this->load->model('gallerys_model');
		$gallerys=$this->gallerys_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item['gallerys_id'],),null,null,'order');

		$similars=array();
		$ids=explode(',',$item['similar_ids']);
		foreach($ids as $id){
			$similar=$this->educations_model->get_by_fields(array("id"=>$id,'is_show'=>1,'is_block'=>0,));
			if(!empty($similar)){
				$similars[$similar['id']]=$similar;
			}			
		}
		

		$this->template->write_view('content_main', 'educations/show', array(
			'item'=>$item,
			'programs'=>$programs,
			'gallerys'=>$gallerys,
			'breads'=>$this->educations_model->get_breads($item['id']),
			'similars'=>array_values($similars),
		));		
		
		$this->template->write('js','<script src="/js/slick.min.js"></script><script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>');
		$this->template->write('css','<link rel="stylesheet" href="/css/slick.css"><link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>'); 
		
		
		$this->template->render();
	}
}
?>