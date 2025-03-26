<?
class educations_model extends MY_Model{
	protected $table = 'educations';
	protected $table_child = 'educations';
	protected $table_parent = 'educations_group';	
	
	public function get_breads($item_id){
		$item=$this->get_by_id($item_id);
		$breads=array('#'=>$item['name']);
		
		$parent=$this->educations_group_model->get_by_id($item['pid']);
		$parent2=$this->educations_group_model->get_by_id($parent['pid']);
		
		$breads[site_url($parent2['url'])]=$parent2['name'];
		
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(200);
		$breads[site_url('center')]=$item['name'];
		
		return $this->load->view('tmpl/breads',array(
			'items'=>array_reverse($breads, true),
		),true);
	}
}

?>