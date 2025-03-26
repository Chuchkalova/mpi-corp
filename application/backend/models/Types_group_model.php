<?
class types_group_model extends MY_Model{
	protected $table = 'types_group';
	protected $table_child = 'types';
	protected $table_parent = 'types_group';
	protected $controller= 'types';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Типы товаров";
	protected $module_id=13;
	
	/* 'Имя_в_БД' => array('тип_поля','русское_название', 'вывод_в_таблице', 'фильтр_в_таблице', 'фильтр_вверху', 'имя_колонки', 'мета_данные', 'права'),*/
	
	var $fields=array(
		'name'=>array('text','Наименование',true,'subitem_td','text_like','','Наименование'),
		'pid'=>array('select','Предок'),
		'type'=>array('select','Тип'),
		//'is_filter'=>array('checkbox','Показывать в фильтре'),
		'order'=>array('text','Порядок', false, 'input_td','','','Порядок'),
		//'is_table'=>array('checkbox','Показывать в таблице'),
	);
	
	var $add_fields=array(
		'edit_group_echo',
		'delete_group_echo',
		'hide_id_echo',
	);
	
	public function select_type(){
		return array(
			'type'=>'Тип товара',
			//'group'=>'Вкладка товара',
			'select'=>'Один из списка',
			'checkbox'=>'Множественный выбор',
			//'value'=>'Текстовое поле',
		);
	}
	
	public function submit_table($pid){
		return "Обновить";
	}

	public function get_types_set($type_id, $item_id=0){
		$this->load->model('catalog_types_model');
		$this->load->model($this->table_child."_model");
		$attrs=array();
		if($type_id>0){
			$attrs[]=$this->get_trs($type_id, $item_id);
		}
		return $attrs;
	}
	
	private function get_trs($type_id, $item_id){
		$main_item=$this->get_by_fields(array('id'=>$type_id,));
		$attr=array(
			'name'=>$main_item['name'],
			'groups'=>array(),
		);
		$attributes=array();
		$items=$this->get_page(array('is_block'=>0,'pid'=>$type_id,'type'=>'group',),null,null,'order');
		if(!count($items)){
			$items=$this->get_page(array('is_block'=>0,'pid'=>$type_id,),null,null,'order');
			foreach($items as $item2){
				if($item2['type']=='select'||$item2['type']=='checkbox'||$item2['type']=='value'){
					$variants=$this->get_line($item2, $item_id);
					if(count($variants)){
						$attributes[$item2['id']]=array(
							'values'=>$variants,
							'name'=>$item2['name'],
						);
					}
				}
			}
			
			if(!isset($item['name'])) $item['name']="";
			
			$attr['groups'][]=array(
				'name'=>$item['name'],
				'attributes'=>$attributes,
			);
		}
		else{
			foreach($items as $item){
				$attributes=array();
				$items2=$this->get_page(array('is_block'=>0,'pid'=>$item['id'],),null,null,'order');
				foreach($items2 as $item2){
					if($item2['type']=='select'||$item2['type']=='checkbox'||$item2['type']=='value'){
						$variants=$this->get_line($item2, $item_id);
						if(count($variants)){
							$attributes[$item2['id']]=array(
								'values'=>$variants,
								'name'=>$item2['name'],
							);
						}
					}
				}
				$attr['groups'][]=array(
					'name'=>$item['name'],
					'attributes'=>$attributes,
				);
			}
		}
		
		return $attr;
	}
	
	private function get_line($item, $item_id){
		$return=array();
		$variants=$this->{$this->table_child."_model"}->get_page(array('is_block'=>0,'pid'=>$item['id'],),null,null,'name');
		if(count($variants)||$item['type']=='value'){
			if($item['type']=='select'){
				$vars=array('0'=>'Не установлено',);
				foreach($variants as $variant){
					$vars[$variant['id']]=$variant['name'];
				}
				$value=0;
				if($item_id){
					$value_active=$this->catalog_types_model->get_actual_values($item_id, $item['id']);
					if(isset($value_active[0])) $value=$value_active[0];
				}
				$return['name']=$item['name'];
				$return['content'][]=array(
					'name'=>$item['name'],
					'value'=>form_dropdown("add_fields[{$item['id']}][]", $vars, $value),
				);
			}
			else if($item['type']=='checkbox'){
				$value_active=array();
				if($item_id){
					$value_active=$this->catalog_types_model->get_actual_values($item_id, $item['id']);
				}
				foreach($variants as $variant){
					$return['name']=$item['name'];
					$return['content'][]=array(
						'name'=>$variant['name'],
						'value'=>form_checkbox("add_fields[{$item['id']}][]", $variant['id'], in_array($variant['id'], $value_active)),
					);
				}
			}
			else if($item['type']=='value'){
				$value_active=array();
				if($item_id){
					$value_active=$this->catalog_types_model->get_actual_values($item_id, $item['id'], true);
				}
				else{
					$value_active="";
				}
				$return['name']=$item['name'];
				$return['content'][]=array(
					   'name'=>$item['name'],
					   'value'=>form_input(array(
					   'name'        => "add_fields[{$item['id']}][]",
					   'maxlength'   => '200',
					   'value' 		 => $value_active,
					)),
				);
				
			}
		}
		return $return;
	}
	
	public function update_catalog_item($item_id, $attrs){
		$this->load->model('catalog_types_model');
		$this->catalog_types_model->delete_where(array('item_id'=>$item_id,));
		if(count($attrs)){
			foreach($attrs as $attr_name=>$attr_array){
				$attr_header=$this->get_by_id($attr_name);
				if(count($attr_array)){
					foreach($attr_array as $attr_c=>$attr_v){
						if(isset($attr_header)&&$attr_header['type']=='value'){
							$this->catalog_types_model->insert(array('item_id'=>$item_id,'type_id'=>-1*$attr_name,'value'=>$attr_v));
						}
						else if($attr_v){
							$this->catalog_types_model->insert(array('item_id'=>$item_id,'type_id'=>$attr_v,));
						}
					}
				}
			}
		}
	}
	
	protected function update_table($pid, $post){
		if(isset($post['hide_id'])&&count($post['hide_id'])){
			foreach($post['hide_id'] as $item_id=>$value){
				$update=array();
				if(isset($post['table_order'][$item_id])){
					$update['order']=$post['table_order'][$item_id];
				}
				if(count($update)){
					$this->update($item_id, $update);
				}
			}
		}
	}
}

?>