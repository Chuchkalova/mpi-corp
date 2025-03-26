<?
class texts_model extends MY_Model{
	protected $table = 'texts';
	protected $module_id = 1;
	
	public function popup_level2_menu($parametrs){
		$this->load->model('texts_group_model');
		$menus=array();
		$items=$this->texts_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$parametrs->root_id,),null,null,"order");
		if(count($items)){
			foreach($items as $item_one){
				$children=array();
				$items2=$this->texts_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item_one['id'],),null,null,"order");
				if(count($items2)){
					foreach($items2 as $item_one2){
						$children[]=array(
							'name'=>$item_one2['name'],
							'url'=>site_url("texts/show_group/{$item_one2['url']}"),
						);
					}
				}
				else{
					$items2=$this->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$item_one['id'],),null,null,"order");
					foreach($items2 as $item_one2){
						$children[]=array(
							'name'=>$item_one2['name'],
							'url'=>site_url("texts/show/{$item_one2['url']}"),
						);
					}
				}
				
				$menus[]=array(
					'name'=>$item_one['name'],
					'url'=>site_url("texts/show_group/{$item_one['url']}"),
					'children'=>$children,
				);
			}
		}
		else{
			$items=$this->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$parametrs->root_id,),null,null,"order");
			if(count($items)){
				foreach($items as $item_one){
					$menus[]=array(
						'name'=>$item_one['name'],
						'url'=>site_url("texts/show/{$item_one['url']}"),
						'children'=>array(),
					);
				}
			}
		}
		
		return $this->load->view('texts/popup_level2_menu',array(
			'items'=>$menus,
			'name'=>$parametrs->name,
		),true);
	}
	
	public function get_search_fields(){
		return array('text','name','short_text','h1');
	}
	public function get_search_element($item){
		$this->load->model('text_group_model');
		$item['parent']=$this->text_group_model->get_by_id($item['pid']);
		
		return $this->load->view("text/text_model_search",array(
			'item_one'=>$item,
			'config'=>$config['search'],
		),true);
	}
	
	public function get_breads($item_id){
		$this->load->model('texts_group_model');
		$item=$this->get_by_id($item_id);
		$breads=array();
		
		if(isset($item['id'])){
			$breads=array('#'=>$item['name']);
			$item=$this->texts_group_model->get_by_fields(array('id'=>$item['pid'],));
			$breads[site_url("texts/show_group/{$item['url']}")]=$item['name'];
			$break=10;
			while($item['pid']!=0&&$break){
				--$break;
				$item=$this->texts_group_model->get_by_id($item['pid']);
				$breads[site_url("texts/show_group/{$item['url']}")]=$item['name'];
			}
		}
		
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(101);		
		$breads[site_url("texts/show_all")]=$item['name'];
		
		return $this->load->view('tmpl/breads',array(
			'items'=>array_reverse($breads, true),
		),true);
	}
	
}

?>