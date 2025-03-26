<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class products_types extends MY_ControllerTmpl {
	var $table="products_types";
	var $table_top="products_types";
	
	public function show_group($url="",$page_num=1){
		$item=$this->products_types_model->get_by_fields(array("url"=>$url, 'is_block'=>0, 'is_show'=>1,));
		if(!$item['id']){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->products_types_model->load_meta($item);
		
		$data=array(
			'item'=>$item,
			'breads'=>$this->products_types_model->get_breads($item['id']),
		);
			
		$this->load->model('texts_model');
		$this->load->model('texts_group_model');
		$texts=$this->texts_group_model->get_by_id(2);
		$texts['items']=$this->texts_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>2,),null,null,'order');
		$data['texts']=$texts;

		$data['products_types']=$this->products_types_model->get_page(array('is_show'=>1,'is_block'=>0,),null,null,'order');
		
		$data['types']=array();
		
		$types=$this->products_types_model->sql_query_array("
			select t.name, t.id, tg.name as group_name, tg.id as group_id
			from catalogs c
			inner join catalogs_products_types cpt on cpt.catalogs_id = c.id and cpt.products_types_id = '{$item['id']}'
			inner join catalogs_group cg on c.pid=cg.id
			inner join catalog_types ct on ct.item_id=c.id
			inner join types t on t.id=ct.type_id
			inner join types_group tg on tg.id=t.pid			
			where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and tg.is_block=0 and t.is_block=0
			group by t.id
			order by tg.order, tg.id,t.order, t.name					
		");
		$prev_type_id=0;
		foreach($types as $item_one){
			if($prev_type_id!=$item_one['group_id']){
				$prev_type_id=$item_one['group_id'];
				$data['types'][$item_one['group_id']]=array(
					'name'=>$item_one['group_name'],
					'items'=>array(),
				);
			}
			$data['types'][$item_one['group_id']]['items'][]=array(
				'name'=>$item_one['name'],
				'id'=>$item_one['id'],
			);
		}
		
		$data['min_max']=$this->products_types_model->sql_query_one("
			select min(c.price) as min, max(c.price) as max
			from catalogs c
			inner join catalogs_products_types cpt on cpt.catalogs_id = c.id and cpt.products_types_id = '{$item['id']}'
			inner join catalogs_group cg on c.pid=cg.id
			where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1
		");
		
		
		$filters=array();
		if($this->session->userdata('catalogs_filters')){
			$filters=unserialize($this->session->userdata('catalogs_filters'));
			if(empty($filters)||!isset($filters['product_types_id'])||$filters['product_types_id']!=$item['id']){
				$filters=array();
			}
		}
		$this->session->set_userdata('catalogs_filters',serialize($filters));
		$data['filters']=$filters;
		
		$sql="";				
		if(isset($filters['price_from'])){
			$sql.=" and c.price>=".intval($filters['price_from']);
		}
		if(isset($filters['price_to'])){
			$sql.=" and c.price<=".intval($filters['price_to']);
		}
		if(!empty($filters['filters'])){
			foreach($filters['filters'] as $types_group_id=>$values){
				$real_values=array();
				foreach($values as $value){
					if(intval($value)>0){
						$real_values[]=intval($value);
					}
				}
				if(count($real_values)){
					$sql.=" and exists(select 1 from catalog_types where item_id=c.id and type_id IN(".implode(',',$real_values)."))";
				}
			}
		}
		
		$on_page=5;
		$catalogs_count=$this->products_types_model->sql_query_one("
			select count(distinct(cg.id)) as counter
			from catalogs c
			inner join catalogs_products_types cpt on cpt.catalogs_id = c.id and cpt.products_types_id = '{$item['id']}'
			inner join catalogs_group cg on c.pid=cg.id
			where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 $sql
		");
		$start=($page_num-1)*$on_page;
		$data['items']=$this->products_types_model->sql_query_array("
			select cg.* 
			from catalogs c 
			inner join catalogs_products_types cpt on cpt.catalogs_id = c.id and cpt.products_types_id = '{$item['id']}'
			inner join catalogs_group cg on c.pid=cg.id
			where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 $sql
			group by cg.id
			order by cg.`order`
			limit $start, $on_page
		");
		foreach($data['items'] as &$item_one){
			$item_one['items']=$this->products_types_model->sql_query_array("
				select c.*
				from catalogs c
				inner join catalogs_products_types cpt on cpt.catalogs_id = c.id and cpt.products_types_id = '{$item['id']}'
				where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
				order by c.order
			");
		}
		$data['pager']=$this->products_types_model->get_pager(site_url($item['url']), $catalogs_count['counter'], 2, $on_page);
		
		$this->template->write('js','<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js"></script><script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>');
		$this->template->write('css','<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css"><link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>'); 				
			
		$this->template->write_view('content_main', 'product_types/show_group', $data);

		$this->template->render();
	}
	
	public function show_all($page_num=1){
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(202);
		$this->mains_model->load_meta($item);
		
		$data=array(
			'item'=>$item,
			'breads'=>$this->products_types_model->get_breads(0),
		);
		
		$data['groups']=$this->products_types_model->get_page(array('is_show'=>1,'is_block'=>0,),null,null,'order');

		$on_page=9;
		$sql=$search="";
		if($this->input->post('search')!==null){
			$search=trim($this->input->post('search'));
			$this->session->set_userdata('types_search',$search);
		}
		/*else if($this->session->userdata('types_search')){
			$search=trim($this->session->userdata('types_search'));
		}*/
		
		if($search){
			$sql.=" and cg2.name like ".$this->db->escape('%'.$search.'%');
		}
		
		$count=$this->products_types_model->sql_query_one("
			select count(distinct(cg2.id)) as counter 
			from catalogs c 
			inner join catalogs_products_types cpt on cpt.catalogs_id = c.id
			inner join catalogs_group cg on c.pid=cg.id	
			inner join catalogs_group cg2 on cg.pid=cg2.id				
			where cg.is_show=1 and cg.is_block=0 $sql			
		");
		$start=($page_num-1)*$on_page;
		$data['items']=$this->products_types_model->sql_query_array("
			select cg2.* 
			from catalogs c 
			inner join catalogs_products_types cpt on cpt.catalogs_id = c.id
			inner join catalogs_group cg on c.pid=cg.id		
			inner join catalogs_group cg2 on cg.pid=cg2.id						
			where cg.is_show=1 and cg.is_block=0 $sql
			group by cg2.id
			order by cg.`order`
			limit $start, $on_page
		");
		if($page_num!=1&&!count($data['items'])){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		
		$data['pager']=$this->products_types_model->get_pager(site_url('types_all'), $count['counter'], 2, $on_page);
		$data['search']=$search;
		$this->template->write_view('content_main', 'product_types/show_all', $data);
		$this->template->render();
	}
	

}
?>