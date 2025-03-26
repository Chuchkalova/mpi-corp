<?
class pages_model extends MY_Model{
	protected $table = 'pages';
	protected $table_child = 'pages';
	protected $table_parent = 'pages';
	protected $controller= 'pages';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Страницы";
	protected $module_id=29;
	protected $is_region=false;
	//protected $gallerys_group_id=2;

	var $fields=array(
		'name'=>array('long_text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'pid'=>array('select','Предок'),
		'short_text'=>array('ckeditor','Краткое содержимое'),
		'text'=>array('ckeditor','Полное содержимое'),
		
		'is_show'=>array('checkbox','Показать',false, 'checkbox_td','','','Показ'),
		'order'=>array('text','Порядок', false, 'input_td','','','Порядок'),
		'date'=>array('date','Дата', false, 'date_td','','','Дата'),
		
		'file'=>array('file','Изображение'),
		'gallery_id'=>array('gallery','Галерея'),
		
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