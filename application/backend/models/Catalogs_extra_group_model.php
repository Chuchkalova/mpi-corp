<?
class catalogs_extra_group_model extends MY_Model{
	protected $table = 'catalogs_extra_group';
	protected $table_child = 'catalogs_extra_group';
	protected $table_parent = 'catalogs_extra_group';

	private $current_set;
	public function get_new_categories($item_id){
		$this->load->model('catalog_group_model');
		$this->load->model('catalog_model');
		$item=$this->catalog_model->get_by_id($item_id);
		$this->current_set=$this->get_list(array('item_id'=>$item_id,),'group_id','group_id');
		$this->current_set[$item['pid']]=$item['pid'];
		$ret=array("0"=>"Не добавлять",);
		$return=$this->select_pid_recoursive(0, "&nbsp;&nbsp;", $ret);
		
		return $return;
	}
	
	protected function select_pid_recoursive($root, $prefix, &$ret){
		$items=$this->catalog_group_model->get_page(array("pid"=>$root, "is_block"=>0,),null,null,$this->order_field);
			
		$item=$this->catalog_group_model->get_by_fields(array('id'=>$root,"is_block"=>0,));
		if($item['id']&&!isset($this->current_set[$item['id']])){
			$ret[$item['id']]=$prefix.$item['name'];
		}
			
		if(count($items)&&!isset($this->current_set[$item['id']])){
			foreach($items as $item){
				$this->select_pid_recoursive($item['id'], "&nbsp;&nbsp;".$prefix, $ret);
			}			
		}

		return $ret;
	}
	
	public function get_categories($item_id){
		$return=$this->sql_query_array("
			select cg.id, cg.name 
			from catalog_group cg
			inner join catalog_extra_group ceg on ceg.group_id=cg.id
			where ceg.item_id='$item_id'
		");
		
		return $return;
	}
	
}

?>