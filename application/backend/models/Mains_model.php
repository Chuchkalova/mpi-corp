<?
class mains_model extends MY_Model{
	protected $table = 'mains';
	protected $table_child = 'mains';
	protected $table_parent = 'mains';
	protected $controller= 'mains';
	protected $pages=20;
	protected $order_field="id";
	protected $order_type="asc";
	protected $name="Специальные";
	protected $module_id=3;
	protected $is_region=false;
	
	/* 'Имя_в_БД' => array('тип_поля','русское_название', 'вывод_в_таблице', 'фильтр_в_таблице', 'фильтр_вверху', 'имя_колонки', 'мета_данные', 'права'),*/

	var $fields=array(
		'name'=>array('text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'short_text'=>array('ckeditor','Краткий текст'),
		'text'=>array('ckeditor','Текст'),
		
		'file'=>array('file','Изображение'),
		
		'url'=>array('text','URL'),
		'h1'=>array('text','h1'),
		'meta_title'=>array('long_text','meta-title'),
		'meta_description'=>array('long_text','meta-description'),
		'meta_keywords'=>array('long_text','meta-keywords'),
		
		'region_rewrite'=>array('checkbox','Разрешить перезапись',),
	);
	
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
	);
}

?>