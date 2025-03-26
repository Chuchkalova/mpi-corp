<?
class block_pages_group_model extends MY_Model{
	protected $table = 'block_pages_group';
	protected $table_child = 'block_pages';
	protected $table_parent = 'block_pages_group';
	protected $controller= 'block_pages';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Блочные страницы";
	protected $module_id=34;

	var $fields=array(
		'name'=>array('long_text','Наименование',true,'subitem_td','text_like', '', 'Наименование'),
		'pid'=>array('select','Предок'),
		'type'=>array('select','Тип блока'),
		'text'=>array('ckeditor','Текст'),
		'is_show'=>array('checkbox','Показать',false, 'checkbox_td','','','Показ'),
		'order'=>array('text','Порядок', false, 'input_td','','','Порядок'),		
		'url'=>array('text','URL'),
		'h1'=>array('text','h1'),
		'meta_title'=>array('long_text','meta-title'),
		'meta_description'=>array('long_text','meta-description'),
		'meta_keywords'=>array('long_text','meta-keywords'),
	);
	
	var $add_fields=array(
		'edit_group_echo',
		'delete_group_echo',
		'hide_id_echo'
	);

	public function submit_table($pid){
		return "Обновить";
	}
	
	protected function update_table($pid, $post){
		if(isset($post['hide_id'])&&count($post['hide_id'])){
			foreach($post['hide_id'] as $item_id=>$value){
				$update=array();
				if(isset($post['table_order'][$item_id])){
					$update['order']=$post['table_order'][$item_id];
				}
				$update['is_show']=isset($post['table_is_show'][$item_id]);
				if(count($update)){
					$this->update($item_id, $update);
				}
			}
		}
	}
	
	public function select_type($db_field){
		return array(
			'item'=>'Блочная страница',
			'blue_bg'=>'Текст на синем фоне',
			'directions'=>'Направления деятельности',			
			'developers'=>'Разработчики',
			'personal'=>'Персонал',
		);
	}
	
	
	var $actual_fields=array(	
		''=>array('name','pid','is_show','order','type','url','meta_title','meta_description','meta_keywords','h1',),
		'item'=>array('name','pid','is_show','order','type','url','meta_title','meta_description','meta_keywords','h1',),		
		'blue_bg'=>array('name','pid','is_show','order','type','text',),		
		'text'=>array('name','pid','is_show','order','type','text',),
		'directions'=>array('name','pid','is_show','order','type','text',),
		'developers'=>array('name','pid','is_show','order','type','text',),
		'personal'=>array('name','pid','is_show','order','type',),		
	);
	
	public function prepare_fields_array($fields_array, $item_id, $is_insert){
		$new_array=array();
		if($is_insert){
			$group['type']='';
		}
		else{
			$group=$this->get_by_id($item_id);
		}
		$filter=$this->actual_fields[$group['type']];
		foreach($fields_array as $name=>$value){
			if(in_array($name,$filter)){
				$new_array[$name]=$value;
			}
		}
		
		return $new_array;
	}
}

?>