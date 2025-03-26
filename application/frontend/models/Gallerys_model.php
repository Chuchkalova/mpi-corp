<?
class gallerys_model extends MY_Model{
	protected $table = 'gallerys';
	protected $module_id = 10;	
	
	public function bxslider($parametrs){
		$this->load->model('gallerys_group_model');
		$items=$this->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$parametrs->pid,),null,null,"order");
		$parent=$this->gallerys_group_model->get_by_id($parametrs->pid);
		
		return $this->load->view('gallerys/slider',array(
			'items'=>$items,
			'parent'=>$parent,
		),true);
	}
	
	public function bxcarousel($parametrs){
		$this->load->model('catalogs_group_model');
		$items=$this->catalogs_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$parametrs->pid,),null,null,"order");
		$parent=$this->gallerys_group_model->get_by_id($parametrs->pid);
		
		return $this->load->view('gallerys/carousel',array(
			'items'=>$items,
			'parent'=>$parent,
			'count'=>$parametrs->pid,			
		),true);
	}
	
	
}

?>