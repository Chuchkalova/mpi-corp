<?
class articles_group_model extends MY_Model{
	protected $table = 'articles_group';
	
	public function get_breads($item_id){	
		$item=$this->get_by_id($item_id);
		$breads=array();
		if(isset($item['id'])){
			$breads=array('#'=>$item['name']);
		}	
		
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(109);
		if($item_id){
			$breads[site_url("events")]=$item['name'];
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