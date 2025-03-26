<?
class types_model extends MY_Model{
	protected $table = 'types';
	protected $table_child = 'types';
	protected $table_parent = 'types_group';
	protected $controller= 'types';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Атрибуты товаров";
	protected $module_id=13;
	
	/* 'Имя_в_БД' => array('тип_поля','русское_название', 'вывод_в_таблице', 'фильтр_в_таблице', 'фильтр_вверху', 'имя_колонки', 'мета_данные', 'права'),*/
	
	var $fields=array(
		'name'=>array('text','Наименование',true,'show_td','text_like','','Наименование'),
		'pid'=>array('select','Группа'),
		'order'=>array('text','Порядок', false, 'input_td','','','Порядок'),
	);
	
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
		'hide_id_echo',
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
				if(count($update)){
					$this->update($item_id, $update);
				}
			}
		}
	}
	
}

?>