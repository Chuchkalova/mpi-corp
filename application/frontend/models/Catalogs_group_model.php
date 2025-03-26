<?
class catalogs_group_model extends MY_Model{
	protected $table = 'catalogs_group';
	
	public function get_breads($item_id){
		$item=$this->get_by_id($item_id);
		$breads=array();
		
		if(isset($item['id'])){
			$breads=array('#'=>$item['name']);
			$break=10;
			while($item['pid']!=0&&$break){
				--$break;
				$item=$this->get_by_id($item['pid']);
				$breads[site_url($item['url'])]=$item['name'];
			}
		}
		
		return $this->load->view('tmpl/breads',array(
			'items'=>array_reverse($breads, true),
		),true);
	}

	public function level1_group($parametrs){
		$items=$this->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>0,),null,null,$parametrs->order);
		
		return $this->load->view('catalogs/level1_group',array(
			'items'=>$items,
			'parametrs'=>$parametrs,
		),true);
	}
	
	public function groups_by_parent($parametrs){
		$items=$this->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$parametrs->parent_id,),null,null,$parametrs->order);
		
		return $this->load->view('catalogs/groups_by_parent',array(
			'items'=>$items,
			'parametrs'=>$parametrs,
		),true);
	}
	
	public function items_by_parent($parametrs){
		$this->load->model('catalogs_model');
		$items=$this->catalogs_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$parametrs->parent_id,),0,$parametrs->count,$parametrs->order);
		$real_items=$this->prepare_items_to_view($items);
		return $this->load->view('catalogs/items_by_parent',array(
			'raw_items'=>$items,
			'items'=>$real_items,
			'parametrs'=>$parametrs,
		),true);
	}
	
	public function level2_group($parametrs){
		$items=$this->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>0,),null,null,$parametrs->order);
		
		foreach($items as &$item_one){
			$item_one['subitems']=$this->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item_one['id'],),null,null,$parametrs->order);
		}
		
		return $this->load->view('catalogs/level2_group',array(
			'items'=>$items,
			'parametrs'=>$parametrs,
		),true);
	}
	
	public function hits($parametrs){
		$this->load->model('catalogs_model');
		$items=$this->catalogs_model->get_page(array('is_block'=>0, 'is_show'=>1, 'is_hit'=>1,),0,$parametrs->count,$parametrs->order);
		$real_items=$this->prepare_items_to_view($items);
		return $this->load->view('catalogs/hits', array(
			'items'=>$real_items,
			'parametrs'=>$parametrs,
		),true);
	}
	
	public function sales($parametrs){
		$this->load->model('catalogs_model');
		$items=$this->catalogs_model->get_page(array('is_block'=>0, 'is_show'=>1, 'is_sale'=>1,),0,$parametrs->count,$parametrs->order);
		$real_items=$this->prepare_items_to_view($items);
		return $this->load->view('catalogs/sales', array(
			'items'=>$real_items,
			'parametrs'=>$parametrs,
		),true);
	}

	public function popup_order($parametrs){

		return $this->load->view('catalogs/popup_order',array(
			'parametrs'=>$parametrs,
		),true);
	}
	
	public function get_count_items($item){
		$this->load->model('catalogs_model');
		return $this->catalogs_model->get_count(array('is_block'=>0, 'is_show'=>1, 'pid'=>$item['id'],));
	}
	
	public function get_hit_count(){
		$this->load->model('catalogs_model');
		return $this->catalogs_model->get_count(array('is_block'=>0, 'is_show'=>1, 'is_hit'=>1,));
	}
	
	public function get_items($item, $page_num, $count, $order){
		$items=$this->catalogs_model->get_page(array('is_block'=>0, 'is_show'=>1, 'pid'=>$item['id'],),($page_num-1)*$count,$count,$order);
		return $items;
	}
	
	public function get_hit_items($page_num, $count, $order){
		$items=$this->catalogs_model->get_page(array('is_block'=>0, 'is_show'=>1, 'is_hit'=>1,),($page_num-1)*$count,$count,$order);
		return $items;
	}
	
	public function prepare_items_to_view($items){
		$real_items=array();
		foreach($items as $item_one){
			$item_one['subitems']=$this->catalogs_model->get_page(array('is_block'=>0, 'is_show'=>1, 'item_parent'=>$item_one['id']));
			if(count($item_one['subitems'])){
				$item_one['min_price']=9999999;
				foreach($item_one['subitems'] as $subitem){
					if($item_one['min_price']>$subitem['price']){
						$item_one['min_price']=$subitem['price'];
					}
				}
			}
			$real_items[]=$this->load->view('catalogs/element', array(
				'item'=>$item_one,
			),true);
		}
		return $real_items;
	}
	
	public function get_recoursive_children($pid){
		$categories_list=array();
		$this->category_get_childs($pid, $categories_list);
		return $categories_list;
	}
	
	protected function category_get_childs($category_id, &$categories_list){
		$children=$this->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$category_id));
		if(count($children)){
			foreach($children as $item_one){
				$this->category_get_childs($item_one['id'], $categories_list);
			}
		}
		else{
			$categories_list[]= $category_id;
		}
	}
	
}

?>