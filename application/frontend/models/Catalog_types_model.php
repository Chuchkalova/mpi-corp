<?
class catalog_types_model extends MY_Model{
	var $table = 'catalog_types';
	var $fields=array();
	
	public function get_item_attrs($item_id){
		$sql="
			(select tg.name, t.name as value, tg2.name as `group`
			from catalog_types ct
			inner join types t on ct.type_id=t.id
			inner join types_group tg on t.pid=tg.id
			inner join types_group tg2 on tg.pid=tg2.id
			where ct.item_id='$item_id' and t.is_block=0 and tg.is_block=0
			order by tg.id)			
			union
			(select tg.name, ct.value as value, tg2.name as `group`
			from catalog_types ct
			inner join types_group tg on -1*ct.type_id=tg.id
			inner join types_group tg2 on tg.pid=tg2.id
			where ct.item_id='$item_id' and tg.is_block=0)
		";
		$variants=$this->sql_query_array($sql);
		$result=array();
		foreach($variants as $variant){
			if(!isset($result[$variant['group']])){
				$result[$variant['group']]=array();
			}
			if($variant['value']){
				$result[$variant['group']][]=array(
					'name'=>$variant['name'],
					'value'=>$variant['value'],
				);
			}
		}
		return $result;
	}
}
?>