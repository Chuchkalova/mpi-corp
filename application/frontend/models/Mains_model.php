<?
class mains_model extends MY_Model{
	protected $table = 'mains';
	protected $module_id=3;
	
	public function get_breads($item_id){
		$item=$this->get_by_id($item_id);
		$breads=array('#'=>$item['name']);		
		return $this->load->view('tmpl/breads',array(
			'items'=>array_reverse($breads, true),
		),true);
	}
}

?>