<?
class catalogs_model extends MY_Model{
	protected $table = 'catalogs';
	
	public function menu_level1($parametrs){
		$this->load->model('catalogs_group_model');
		$items=$this->catalogs_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$parametrs->pid,),null,null,"order");
		if($parametrs->is_count){
			foreach($items as &$item_one){
				$item_one['count']=$this->get_items_count($item_one['id']);
			}
		}		
		
		return $this->load->view('catalogs/menu_level1',array(
			'items'=>$items,
		),true);
	}
	
	public function subcats_level1($parametrs){
		$this->load->model('catalogs_group_model');
		$items=$this->catalogs_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$parametrs->pid,),null,null,"order");
		if($parametrs->is_count){
			foreach($items as &$item_one){
				$item_one['count']=$this->get_items_count($item_one['id']);
			}
		}	
		
		return $this->load->view('catalogs/subcats_level1',array(
			'items'=>$items,
		),true);
	}
	
	public function get_items_count($item_id){
		return $this->get_count(array('is_show'=>1,'is_block'=>0,'pid'=>$item_id,));
	}
	
	public function get_level1($item_id){
		$item=$this->get_by_id($item_id);
		$item=$this->catalogs_group_model->get_by_fields(array('id'=>$item['pid'],));
		$break=10;
		while($item['pid']!=0&&$break){
			--$break;
			$item=$this->catalogs_group_model->get_by_id($item['pid']);
		}
		return $item['id'];
	}
	
	public function get_breads($item_id){
		$this->load->model('catalogs_group_model');
		$item=$this->get_by_id($item_id);
		$breads=array();
		
		if(isset($item['id'])){
			$breads=array(site_url("catalog/show_one/{$item['url']}")=>$item['name']);
			$item=$this->catalogs_group_model->get_by_fields(array('id'=>$item['pid'],));
			$breads[site_url("catalog/show_group/{$item['url']}")]=$item['name'];
			$break=10;
			while($item['pid']!=0&&$break){
				--$break;
				$item=$this->catalogs_group_model->get_by_id($item['pid']);
				$breads[site_url("catalog/show_group/{$item['url']}")]=$item['name'];
			}
		}
		
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(111);
		
		$breads[site_url("catalog/show_all")]=$item['name'];
		
		return $this->load->view('tmpl/breads',array(
			'items'=>array_reverse($breads, true),
		),true);
	}
	
	public function get_item_full($url){
		$item=$this->get_by_fields(array("url"=>$url, 'is_block'=>0, 'is_show'=>1,));
		
		if($this->model_exists('catalog_types_model')){
			$this->load->model('catalog_types_model');
			$item['attrs']=(isset($item['id']))?$this->catalog_types_model->get_item_attrs($item['id']):array();
		}
		return $item;
	}
	
	public function get_search_fields(){
		return array('text','name','short_text','h1');
	}
	public function get_search_filter_fields(){
		return array(
			"item_parent"=>0,
		);
	}
	public function get_search_element($item){	
		return $this->load->view("catalog/catalogs_model_search",array(
			'item_one'=>$this->catalogs_group_model->prepare_items_to_view(array($item)),
		),true);
	}
	
	
}

?>