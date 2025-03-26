<?
class catalogs_group_model extends MY_Model{
	protected $table = 'catalogs_group';
	protected $table_child = 'catalogs';
	protected $table_parent = 'catalogs_group';
	protected $controller= 'catalogs';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Категории";
	protected $module_id=11;
	protected $gallerys_group_id=10;
	
	var $fields=array(
		'name'=>array('text','Наименование',true,'subitem_td','text_like','','Наименование'),
		'search_tags'=>array('long_text','Теги поиска'),
		'pid'=>array('select','Предок'),
		'short_text'=>array('ckeditor','Краткое содержимое'),
		'text'=>array('ckeditor','Описание'),
		'text2_name'=>array('text','Заголовок второго блока описания'),
		'text2'=>array('ckeditor','Второй блок описания'),
		'text3'=>array('ckeditor','Третий блок описания'),
		'text4'=>array('ckeditor','Четвертый блок описания'),
		
		'order'=>array('text','Порядок',false,'input_td','','','Порядок'),
		'is_show'=>array('checkbox','Показать',false,'checkbox_td','','','Показ'),
		'is_level2'=>array('checkbox','Отображать в 1 уровень',),
		'date'=>array('date','Дата',false,'date_td','','','Дата'),
		
		'file'=>array('file','Изображение (230x100)'),
		'file2'=>array('file','Изображение внутри (620x500)'),
		'gallerys_id'=>array('gallery','Галерея'),
		'type_id'=>array('select','Тип товаров',false,'','','','','types_group_model;id;name'),
		
		'url'=>array('text','URL'),
		'h1'=>array('text','h1'),
		'meta_title'=>array('long_text','meta-title'),
		'meta_description'=>array('long_text','meta-description'),
		'meta_keywords'=>array('long_text','meta-keywords'),
	);
	
	//дополнительные функции в отдельном столбце
	var $add_fields=array(
		'edit_group_echo',
		'delete_group_echo',
	);
	
	public function submit_table($pid){
		return "Обновить";
	}
	
	protected function update_table($pid, $post){
		if(isset($post['table_order'])&&count($post['table_order'])){
			foreach($post['table_order'] as $item_id=>$value){
				$this->update($item_id, array(
					'order'=>$post['table_order'][$item_id],
					'is_show'=>isset($post['table_is_show'][$item_id]),
				));
			}
		}
	}
	
	protected function meta_select_values($db_name){
		if($db_name!='type_id'){
			return parent::meta_select_values($db_name);
		}
		
		$params=explode(";",$this->meta_array[$db_name]);
		if(count($params)==3&&$this->model_exists($params[0])){
			$this->load->model($params[0]);
			return $this->{$params[0]}->get_list(array('is_block'=>0,'type'=>'type',),$params[1],$params[2],true);
		}
		return $this->empty_select($db_name);
	}
	

}

?>