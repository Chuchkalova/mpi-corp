<?
class menus_group_model extends MY_Model{
	protected $table = 'menus_group';

	
	public function get_menu_tmpl($menu_id, $menu_tpl){
		$menu_array=$this->get_menu($menu_id);
		return $this->load->view($menu_tpl, array(
			'items'=>$menu_array,
		), true);
	}
	
	public function get_menu($menu_id){
		$this->load->model('menus_model');
		$menu=$this->get_by_fields(array("id"=>$menu_id,"is_block"=>0,'is_show'=>1,));
		$menu_one=array();
		$menu_one['name']=$menu['name'];
		$menu_one['url']="";
		$menu_one['children']=$this->recoursive_menu_generator($menu_id);
		
		$menu_array=array();
		$menu_array[]=$menu_one;
		return $menu_array;
	}
	
	private function recoursive_menu_generator($menu_id){
		$count=$this->get_count(array("pid"=>$menu_id,"is_block"=>0,'is_show'=>1,));
		$return_array=array();
		
		if($count==0){
			$items=$this->menus_model->get_page(array("pid"=>$menu_id,"is_block"=>0,"is_show"=>1,),null,null,"order");
			foreach($items as &$item){
				$menu_one=array();
				$menu_one['name']=$item['name'];
				$menu_one['class']=$item['class'];
				$menu_one['url']=$this->menus_model->get_menu_url($item);
				$return_array[]=$menu_one;
			}
		}
		else{
			$items=$this->get_page(array("pid"=>$menu_id,"is_block"=>0,"is_show"=>1,),null,null,"order");
			foreach($items as &$item){
				$menu_one=array();
				$menu_one['name']=$item['name'];
				$menu_one['url']=$this->get_menu_url($item);
				$menu_one['children']=$this->recoursive_menu_generator($item['id']);
				$return_array[]=$menu_one;			
			}
		}
		return $return_array;
	}
	
	public function get_menu_url($item){
		$this->load->model('modules_model');
		
		$url="#";
		if(!isset($item['id'])) return $url;
		
		if($item['url_this']!=""&&$item['url_this']!="-1"){
			$url=site_url($item['url_this']);
		}
		else{
			$module=$this->modules_model->get_by_id($item['module_id']);
			if(isset($module['name'])&&$module['name']){
				if($item['is_module_top']==1){
					$model=$module['name']."_group_model";
					$url_fragment="show_group";
				}
				else{
					$model=$module['name']."_model";
					$url_fragment="show";
				}
					
				$this->load->model($model);
				$item_new=$this->$model->get_by_id($item['element_id']);
				$url=site_url($item_new['url']);
			}
		}
		return $url;
	}
	
}

?>