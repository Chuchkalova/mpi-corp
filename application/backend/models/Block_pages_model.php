<?
class block_pages_model extends MY_Model{
	protected $table = 'block_pages';
	protected $table_child = 'block_pages';
	protected $table_parent = 'block_pages_group';
	protected $controller= 'block_pages';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Блочные страницы";
	protected $module_id=34;

	var $fields=array(
		'name'=>array('long_text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'pid'=>array('select','Предок'),
		'short_text'=>array('ckeditor','Текст - кратко'),
		'text'=>array('ckeditor','Текст'),
		'file'=>array('file','Изображение'),
		'is_show'=>array('checkbox','Показать',false, 'checkbox_td','','','Показ'),		
		'order'=>array('text','Порядок', false, 'input_td','','','Порядок'),
		'is_bg'=>array('checkbox','Показать фон',),
		'href'=>array('long_text','Внешняя ссылка'),
	);
	
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
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
	
	var $actual_fields=array(	
		'blue_bg'=>array('name','pid','is_show','order','text',),
		'directions'=>array('name','pid','is_show','order','text','is_bg',),
		'developers'=>array('name','pid','is_show','order','href','file',),
		'personal'=>array('name','pid','is_show','order','text','file',),
	);
	
	public function prepare_fields_array($fields_array, $item_id, $is_insert){
		$this->load->model('block_pages_group_model');
		$new_array=array();
		if($is_insert){
			$group=$this->block_pages_group_model->get_by_id($item_id);
		}
		else{
			$item=$this->get_by_id($item_id);
			$group=$this->block_pages_group_model->get_by_id($item['pid']);
		}
		if(!isset($this->actual_fields[$group['type']])){
			unset($fields_array['href']);
			unset($fields_array['is_bg']);
			return $fields_array;
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