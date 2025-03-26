<?
class types_group_model extends MY_Model{
	protected $table = 'types_group';
	
	public function get_category_types($type_id){
		$items=$this->get_page(array('pid'=>$type_id,),null,null,"id");
		$return=array();
		foreach($items as $item){
			$return[$item['name']]=$item['id'];
		}
		return $return;
	}
	
	public function get_type_variants($type_id){
		$items=$this->types_model->get_page(array('pid'=>$type_id,'is_block'=>0,),null,null,"name");
		return $items;
	}
	
	public function get_types_groups($main_group_id){
		$sql="
			select tg.id, tg.name, t.id as type_id
			from types t
			inner join types_group tg on t.pid=tg.id
			inner join types_group tg2 on tg.pid=tg2.id
			where t.is_block=0 and tg.is_block=0 and tg2.is_block=0 and tg2.id='$main_group_id'
			and tg.show_filter=1
			order by tg.id
			";
		$items=$this->sql_query_array($sql);
		$return=array();
		foreach($items as $item){
			$return[$item['type_id']]=$item;
		}
		return $return;
	}
	
	private function get_price($category){
		$sql="
			select min(c.price_from) as min, max(c.price_to) as max
			from catalog c 
			where c.is_block=0 and c.is_show=1 and c.pid='{$category['id']}'
		";	
		$variant=$this->sql_query_one($sql);
		
		$attrs=array();
		if($variant['min']!=$variant['max']){
			$attrs[0]=array(
				'name'=>'Цена',
				'values'=>array(
					'min'=>$variant['min'],
					'max'=>$variant['max'],
				),
				'type'=>'value',
			);
		}
		return $attrs;
	}

	public function get_types_set($category){
		$this->load->model('catalog_types_model');
		$this->load->model("types_model");
		//$attrs=$this->get_price($category);
		$attrs=array();
		
		if($category['type_id']){
			$main_item=$this->get_by_id($category['type_id']);
			$items=array();
			$children=$this->get_page(array('is_block'=>0,'pid'=>$category['type_id'],));
			foreach($children as $child){
				$items=array_merge($items,$this->get_page(array('is_block'=>0,'pid'=>$child['id'],'show_filter'=>1),null,null,'id'));
			}
			
			if(count($items)){
				foreach($items as $item){
					$values=$this->get_line($category, $item);
					if(count($this->get_line($category, $item))>1){
						$attrs[$item['id']]=array(
							'name'=>$item['name'],
							'values'=>$values,
							'type'=>$item['type'],
						);
					}
				}
			}
		}
		return $attrs;
	}
	
	private function get_line($category, $item){
		$vars=array();
		if($item['type']!='value'){
			$sql="
				select t.* 
				from types t
				left join catalog_types ct on ct.type_id=t.id
				inner join catalog c on c.id=ct.item_id
				inner join catalog_group cg on c.pid=cg.id
				where t.is_block=0 and t.pid='{$item['id']}' and c.is_show=1 and c.is_block=0
				group by t.id
				order by t.name
			";	
			$variants=$this->sql_query_array($sql);
			$vars=array();
			foreach($variants as $variant){
				$vars[$variant['name']]=$variant['id'];
			}
		}
		else{	
			$sql="
				select min(CAST(ct.value AS SIGNED)) as min, max(CAST(ct.value AS SIGNED)) as max
				from types_group tg
				left join catalog_types ct on ct.type_id=-tg.id
				inner join catalog c on c.id=ct.item_id
				inner join catalog_group cg on c.pid=cg.id
				where tg.is_block=0 and tg.id='{$item['id']}' and c.is_show=1 and c.is_block=0
			";	
			$variant=$this->sql_query_one($sql);
			if($variant['min']!=$variant['max']){
				$vars=array(
					'min'=>$variant['min'],
					'max'=>$variant['max'],
				);
			}
			
		}
		
		return $vars;
	}
}

?>