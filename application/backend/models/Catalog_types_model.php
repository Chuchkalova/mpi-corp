<?
class catalog_types_model extends MY_Model{
	var $table = 'catalog_types';
	var $fields=array();
	
	public function get_actual_values($item_id, $type_group, $is_value=false){
		if(!$is_value){
			$items=$this->sql_query_array("
				select ct.type_id, ct.value from
				catalog_types ct 
				inner join types t on t.id=ct.type_id
				where item_id='$item_id' and t.pid='$type_group'
			");
			$return=array();
			foreach($items as $item){
				$return[]=$item['type_id'];
			}
			return $return;
		}
		else{
			$type_group*=-1;
			$item=$this->sql_query_one("
				select ct.value from
				catalog_types ct
				where item_id='$item_id' and type_id='$type_group'
			");
			return isset($item['value'])?$item['value']:"";
		}
	}
}
?>