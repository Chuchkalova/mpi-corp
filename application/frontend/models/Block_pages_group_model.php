<?
class block_pages_group_model extends MY_Model{
	protected $table = 'block_pages_group';
	protected $table_child = 'block_pages';
	protected $table_parent = 'block_pages_group';
	
	public function get_breads($item_id){
		$item=$this->get_by_id($item_id);
		$breads=array('#'=>$item['name']);

		return $this->load->view('tmpl/breads',array(
			'items'=>array_reverse($breads, true),
		),true);
	}
}

?>