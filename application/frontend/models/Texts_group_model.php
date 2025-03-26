<?
class texts_group_model extends MY_Model{
	protected $table = 'texts_group';
	protected $module_id = 1;
	
	public function get_breads($item_id){
		$item=$this->get_by_id($item_id);
		$breads=array();
		
		if(isset($item['id'])){
			$breads=array('#'=>$item['name']);
			$break=10;
			while($item['pid']!=0&&$break){
				--$break;
				$item=$this->get_by_id($item['pid']);
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
	
	public function short($parametrs){
		$item=$this->get_by_id($parametrs->pid);
		$this->load->model('text_model');
		$items=$this->text_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$parametrs->pid,),0,$parametrs->count,$parametrs->order);
		
		return $this->load->view('text/short',array(
			'items'=>$items,
			'item'=>$item,
			'parametrs'=>$parametrs,
		),true);
	}

}

?>