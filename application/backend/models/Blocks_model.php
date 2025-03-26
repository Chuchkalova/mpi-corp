<?
class blocks_model extends MY_Model{
	protected $table = 'blocks';
	protected $table_child = 'blocks';
	protected $table_parent = 'blocks';
	protected $controller= 'blocks';
	protected $pages=20;
	protected $order_field="id";
	protected $order_type="asc";
	protected $name="Блоки";
	protected $module_id=6;
	
	var $fields=array(
		'id'=>array('','ID',false,'show_td','text_like', '', 'ID'),
		'name'=>array('text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'text'=>array('ckeditor','Текст'),
	);

	var $add_fields=array(
		'edit_echo',
		'delete_echo',
	);
	
}
?>