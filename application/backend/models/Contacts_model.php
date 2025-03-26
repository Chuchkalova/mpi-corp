<?
class contacts_model extends MY_Model{
	protected $table = 'contacts';
	protected $table_child = 'contacts';
	protected $table_parent = 'contacts';
	protected $controller= 'contacts';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Контакты";
	protected $module_id=30;

	var $fields=array(
		'name'=>array('long_text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		
		'address'=>array('text','Адрес'),
		'email'=>array('text','Email'),
		'phone1'=>array('text','Телефон 1'),
		'phone2'=>array('text','Телефон 2'),
		'coords'=>array('text','Координаты'),
		
		'is_show'=>array('checkbox','Показать',false, 'checkbox_td','','','Показ'),
		'order'=>array('text','Порядок', false, 'input_td','','','Порядок'),
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