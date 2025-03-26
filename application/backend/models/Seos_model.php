<?
class seos_model extends MY_Model{
	protected $table = 'seos';
	protected $table_child = 'seos';
	protected $table_parent = 'seos';
	protected $controller= 'seos';
	protected $pages=20;
	protected $order_field="name";
	protected $order_type="asc";
	protected $name="SEO-фильтры";
	protected $module_id=36;

	var $fields=array(
		'name'=>array('long_text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'text'=>array('ckeditor','Описание'),
		'catalogs_group_id'=>array('select','Категория'),
		'types_id'=>array('select','Тип товара',),
		
		'url'=>array('text','URL'),
		'h1'=>array('text','h1'),
		'meta_title'=>array('long_text','meta-title'),
		'meta_description'=>array('long_text','meta-description'),
		'meta_keywords'=>array('long_text','meta-keywords'),
	);
	
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
		'hide_id_echo'
	);
	
	public function select_catalogs_group_id($db_field){
		$this->load->model('catalogs_group_model');
		return $this->catalogs_group_model->select_pid($db_field);
	}
	
	public function select_types_id($db_field){
		$result=array();
		$items=$this->sql_query_array("
			select tg.name as group_name, t.id, t.name
			from types t
			inner join types_group tg on tg.id=t.pid
			where t.is_block=0 and tg.is_block=0
			order by tg.name, t.name
		");
		foreach($items as $item_one){
			$result[$item_one['id']]=$item_one['group_name']." / ".$item_one['name'];
		}
		return $result;
	}

}

?>