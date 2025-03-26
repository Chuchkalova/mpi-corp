<?
class articles_model extends MY_Model{
	protected $table = 'articles';
	
	public function short($parametrs){
		$items=$this->get_page(array('is_block'=>0,'is_show'=>1,),0,$parametrs->count,$parametrs->order);
		
		return $this->load->view('articles/short',array(
			'items'=>$items,
			'parametrs'=>$parametrs,
		),true);
	}
	
	public function get_breads($item_id){	
		$item=$this->get_by_id($item_id);
		$breads=array();
		if(isset($item['id'])){
			$breads=array('#'=>$item['name']);
		}
	
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(109);
		if($item_id){
			$breads[site_url("articles/show_all")]=$item['name'];
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