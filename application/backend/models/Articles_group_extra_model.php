<?
class articles_group_extra_model extends MY_Model{
	protected $table = 'articles_group_extra';
	protected $table_child = 'articles_group_extra';
	protected $table_parent = 'articles_group_extra';
	
	private $table_group='articles_group';
	private $table_one='articles';

	private $current_set;
	public function get_new_groups($item_id){
		$this->load->model($this->table_group.'_model');
		$this->load->model($this->table_one.'_model');
		$item=$this->{$this->table_one.'_model'}->get_by_id($item_id);
		$this->current_set=$this->get_list(array('item_id'=>$item_id,),'group_id','group_id');
		$this->current_set[$item['pid']]=$item['pid'];
		$ret=array("0"=>"Не добавлять",);
		$return=$this->select_pid_recoursive(0, "&nbsp;&nbsp;", $ret);
		
		return $return;
	}
	
	protected function select_pid_recoursive($root, $prefix, &$ret){
		$items=$this->{$this->table_group.'_model'}->get_page(array("pid"=>$root, "is_block"=>0,),null,null,$this->order_field);
			
		$item=$this->{$this->table_group.'_model'}->get_by_fields(array('id'=>$root,"is_block"=>0,));
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
	
	public function get_groups($item_id){
		$return=$this->sql_query_array("
			select g.id, g.name 
			from {$this->table_group} g
			inner join {$this->table_group}_extra eg on eg.group_id=g.id
			where eg.item_id='$item_id'
		");
		
		return $return;
	}
	
}

?>