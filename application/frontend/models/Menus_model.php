<?
class menus_model extends MY_Model{
	protected $table = 'menus';
	
	public function level1($parametrs){
		$this->load->model('menus_group_model');
		return $this->menus_group_model->get_menu_tmpl($parametrs->menu_id, 'menus/level1');
	}
	
	public function level1_inline($parametrs){
		$this->load->model('menus_group_model');
		return $this->menus_group_model->get_menu_tmpl($parametrs->menu_id, 'menus/level1_inline');
	}
	
	public function level2($parametrs){
		$this->load->model('menus_group_model');
		return $this->menus_group_model->get_menu_tmpl($parametrs->menu_id, 'menus/level2');
	}
	
	public function level3($parametrs){
		$this->load->model('menus_group_model');
		return $this->menus_group_model->get_menu_tmpl($parametrs->menu_id, 'menus/level3');
	}
	
	public function footer_menu($parametrs){
		$this->load->model('menus_group_model');
		return $this->menus_group_model->get_menu_tmpl($parametrs->menu_id, 'menus/footer_menu');
	}
	
	public function politic_menu($parametrs){
		$this->load->model('menus_group_model');
		return $this->menus_group_model->get_menu_tmpl($parametrs->menu_id, 'menus/politic_menu');
	}
	
	public function get_menu_url($item){
		$this->load->model('menus_group_model');
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