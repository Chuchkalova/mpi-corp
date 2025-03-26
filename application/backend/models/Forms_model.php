<?
class forms_model extends MY_Model{
	protected $table = 'forms';
	protected $table_child = 'forms';
	protected $table_parent = 'forms';
	protected $controller= 'forms';
	protected $pages=20;
	protected $order_field="date";
	protected $order_type="desc";
	protected $name="Формы";
	protected $module_id=33;

	var $fields=array(
		'name'=>array('long_text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'text'=>array('ckeditor','Содержимое'),
		'state'=>array('select','Статус',false,'status_td','', '', 'Статус'),		
		'date'=>array('','Дата', false, 'date_td','','','Дата'),		
	);
	
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
		'hide_id_echo'
	);
	
	var $status=array(
		0=>'Получена',
		1=>'Обработана',
	);

	public function select_state($db_field){
		return $this->status;
	}
	
	public function status_td($value, $item_id, $db_field){
		return $this->status[$value];
	}
	

}

?>