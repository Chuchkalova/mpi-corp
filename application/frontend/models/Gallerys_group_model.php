<?
class gallerys_group_model extends MY_Model{
	protected $table = 'gallerys_group';
	protected $module_id = 10;

	
	public function get_breads($item_id){
		$item=$this->get_by_id($item_id);
		$breads=array();
		
		if(isset($item['id'])){
			$breads=array('#'=>$item['name']);
			$break=10;
			while($item['pid']!=0&&$break){
				--$break;
				$item=$this->get_by_id($item['pid']);
				$breads[site_url("gallerys/show_group/{$item['url']}")]=$item['name'];
			}
		}
		
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(110);
		
		if($item_id){
			$breads[site_url("gallerys/show_all")]=$item['name'];
		}
		else{
			$breads['#']=$item['name'];
		}
		
		return $this->load->view('tmpl/breads',array(
			'items'=>array_reverse($breads, true),
		),true);
	}

}

?>