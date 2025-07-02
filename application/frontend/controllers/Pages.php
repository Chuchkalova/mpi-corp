<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pages extends MY_ControllerTmpl {
	var $table="pages";
	var $table_top="pages";
	
	public function show($url){
		$item=$this->pages_model->get_by_fields(array("url"=>$url,'is_block'=>0,'is_show'=>1,));
		if(!$item['id']){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->pages_model->load_meta($item);
		
		$data=array(
			'item'=>$item,
			'breads'=>$this->pages_model->get_breads($item['id']),
		);
		
		$template='show';
		if($item['id']==3){
			$template='contacts';
			$this->load->model('contacts_model');
			$data['contacts']=$this->contacts_model->get_page(array('is_block'=>0,'is_show'=>1,),null,null,'order');
			$this->template->write_view('js', 'pages/contacts_js', array());
			
			$this->load->model('blocks_model');
			$data['block']=$this->blocks_model->get_by_id(2);
		}
		else if($item['id']==2){
			$template='sitemap';
			$data['items']=$this->sitemap();
		}
		$this->template->write_view('content_main', 'pages/'.$template, $data);
		
		$this->template->render();
	}
	
	private function sitemap(){		
		$maps=array();
		$maps[]=array(
			'url'=>site_url('/'),
			'name'=>'Главная страница',
		);
		
		$this->load->model('pages_model');
		$items=$this->pages_model->get_page(array('is_show'=>1,'is_block'=>0,));
		foreach($items as $item_one){
			$maps[]=array(
				'url'=>site_url($item_one['url']),
				'name'=>$item_one['name'],
			);
		}
		
		$this->load->model('block_pages_group_model');
		$items=$this->block_pages_group_model->get_page(array('is_show'=>1,'is_block'=>0,'type'=>'item',));
		foreach($items as $item_one){
			$maps[]=array(
				'url'=>site_url($item_one['url']),
				'name'=>$item_one['name'],
			);
		}
		
		$this->load->model('gallerys_group_model');
		$items=$this->gallerys_group_model->get_page(array('is_show'=>1,'is_block'=>0,'id'=>3,));
		foreach($items as $item_one){
			$maps[]=array(
				'url'=>site_url($item_one['url']),
				'name'=>$item_one['name'],
			);
		}
		
		$this->load->model('articles_group_model');
		$this->load->model('articles_model');
		$items=$this->articles_group_model->get_page(array('is_show'=>1,'is_block'=>0,));
		$articles=array();
		foreach($items as $item_one){
			$subitems=array();
			$items2=$this->articles_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item_one['id'],));
			foreach($items2 as $item_one2){
				$subitems[]=array(
					'url'=>site_url("articles/".$item_one2['url']),
					'name'=>$item_one2['name'],
				);
			}
			
			$articles[]=array(
				'url'=>site_url($item_one['url']),
				'name'=>$item_one['name'],
				'subitems'=>$subitems,
			);
		}	
		$maps[]=array(
			'url'=>site_url('/events'),
			'name'=>'События',
			'subitems'=>$articles,
		);
		
		$this->load->model('educations_group_model');
		$this->load->model('educations_model');
		$items=$this->educations_group_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>0,));
		$educations=array();
		foreach($items as $item_one){
			$subitems=array();
			$items3=$this->educations_group_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item_one['id'],));
			foreach($items3 as $item_one3){
				$items2=$this->educations_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item_one3['id'],));
				foreach($items2 as $item_one2){
					$subitems[]=array(
						'url'=>site_url($item_one2['url']),
						'name'=>$item_one2['name'],
					);
				}
			}
			
			$educations[]=array(
				'url'=>site_url($item_one['url']),
				'name'=>$item_one['name'],
				'subitems'=>$subitems,
			);
		}	
		$maps[]=array(
			'url'=>site_url('/center'),
			'name'=>'Учебный центр',
			'subitems'=>$educations,
		);
		

		$this->load->model('seos_model');
		$seos=$this->seos_model->get_page(array('is_block'=>0,));
		$seos_real=array();
		foreach($seos as $item_one){
			if(!isset($seos_real[$item_one['catalogs_group_id']])){
				$seos_real[$item_one['catalogs_group_id']]=array();
			}
			$seos_real[$item_one['catalogs_group_id']][]=$item_one;
		}

		$this->load->model('catalogs_group_model');
		$items=$this->catalogs_group_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>0,));
		
		foreach($items as $item_one){
			$subitems=array();
			$items2=$this->catalogs_group_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item_one['id'],));
			if(count($items2)){							
				foreach($items2 as $item_one2){
					$subitems2=array();	
					$items3=$this->catalogs_group_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item_one2['id'],));
					if(count($items3)){
						$subitems3=array();						
						foreach($items3 as $item_one3){	
							if(isset($seos_real[$item_one3['id']])){
								$subitems3=$seos_real[$item_one3['id']];
							}
							else{
								$subitems3=array();
							}
							$subitems2[]=array(
								'url'=>site_url($item_one3['url']),
								'name'=>$item_one3['name'],
								'subitems'=>$subitems3,
							);
						}
					}
					
					if($item_one2['id']==151){
						$subitems2=array();
					}
					
					if(isset($seos_real[$item_one2['id']])){
						$subitems2=array_merge($subitems2, $seos_real[$item_one2['id']]);
					}
					
					
					$subitems[]=array(
						'url'=>site_url($item_one2['url']),
						'name'=>$item_one2['name'],
						'subitems'=>$subitems2,
					);
				}
			}	
			
			$maps[]=array(
				'url'=>site_url($item_one['url']),
				'name'=>$item_one['name'],
				'subitems'=>$subitems,
			);
		}
		
		return $maps;
	}

}
?>