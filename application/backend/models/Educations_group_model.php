<?
class educations_group_model extends MY_Model{
	protected $table = 'educations_group';
	protected $table_child = 'educations';
	protected $table_parent = 'educations_group';
	protected $controller= 'educations';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Учебный центр";
	protected $module_id=31;
	//protected $gallerys_group_id=1;

	var $fields=array(
		'name'=>array('text','Наименование',true,'subitem_td','text_like', '', 'Наименование'),
		'menu_name'=>array('text','Имя в меню'),	
		'pid'=>array('select','Предок'),
		'short_text'=>array('ckeditor','Краткое содержимое'),
		'text'=>array('ckeditor','Полное содержимое'),
		
		'is_show'=>array('checkbox','Показать',false,'checkbox_td','','','Показ'),
		'order'=>array('text','Порядок',false,'input_td','','','Порядок'),
		//'date'=>array('date','Дата',false,'date_td','','','Дата'),
		
		'file'=>array('file','Изображение (488x320)'),
		'file2'=>array('file','Изображение внутри (620x226)'),
		//'gallery_id'=>array('gallery','Галерея'),
		
		'url'=>array('text','URL'),		
		'h1'=>array('text','h1'),
		'h2'=>array('text','h2'),
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

}

?>