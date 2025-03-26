<?
class products_types_model extends MY_Model{
	protected $table = 'products_types';
	protected $table_child = 'products_types';
	protected $table_parent = 'products_types';
	
	public function get_breads($item_id){
		$item=$this->get_by_id($item_id);
		$breads=array();
		if(!empty($item['id'])){
			$breads=array('#'=>$item['name']);
		}
		
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(202);
		if($item_id){
			$breads[site_url('types_all')]=$item['name'];
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