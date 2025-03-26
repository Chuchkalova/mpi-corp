<?
class settings_model extends MY_Model{
	protected $table = 'settings';
	protected $table_child = 'settings';
	protected $table_parent = 'settings';
	protected $controller= 'settings';
	protected $pages=20;
	protected $order_field="id";
	protected $order_type="asc";
	protected $name="Настройки";
	protected $module_id=25;
	
	/* 'Имя_в_БД' => array('тип_поля','русское_название', 'вывод_в_таблице', 'фильтр_в_таблице', 'фильтр_вверху', 'имя_колонки', 'мета_данные', 'права'),*/

	var $fields=array(
		'name'=>array('text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'value'=>array('textarea','Значение',true,'show_td','text_like', '', 'Значение'),
	);
	
	var $add_fields=array(
		'edit_echo'
	);	
	
	public function get_edit_fields($pid){
		$item=$this->get_by_fields(array('id'=>$pid,));
		$fields=array();
		foreach($this->fields_array as $db_name=>$type){
			$rus_name=(isset($this->fields_names_array[$db_name]))?$this->fields_names_array[$db_name]:"";
			$value=(isset($item[$db_name]))?$item[$db_name]:"";
			$content="";
		}
		
		foreach($this->fields_array as $db_name=>$type){
			$rus_name=(isset($this->fields_names_array[$db_name]))?$this->fields_names_array[$db_name]:"";
			$value=(isset($item[$db_name]))?$item[$db_name]:"";
			$content="";
			switch($type){
				case('text'):
					$content=form_input(array(
						'name'        => $db_name,
						'id'          => "field_".$db_name,
						'class'		  => 'form-control',
						'value'		  => $value,
					));
					break;
				case('hidden'):
					$content=form_hidden($db_name, $value);
					break;
				case('textarea'):
					if($item['type']=="string"){
						$content=form_textarea(array(
							'name'        => $db_name,
							'id'          => $db_name,
							'value' 	  => $value,
							'class'		  => 'form-control',
						));
					}
					else{
						if(isset($item['value'])&&$item['value']&&file_exists($_SERVER['DOCUMENT_ROOT'].$item['value'])){
							$file_path=$item['value'];
							if(strpos($file_path,"jpg")!==false||strpos($file_path,"jpeg")!==false||strpos($file_path,"png")!==false||strpos($file_path,"gif")!==false){
								$del_url=site_url("{$this->controller}/delete_file/{$item['id']}/".base64_encode($file_path));
								$content="<img width='100' src='$file_path'> <a href='$del_url'>Удалить</a>";
							}
							else{
								$del_url=site_url("{$this->controller}/delete_file/{$item['id']}/".base64_encode($file_path));
								$content="<a href='$file_path' target='_blank'>Посмотреть</a> <a href='$del_url'>Удалить</a>";
							}
						}
						else{
							$content=form_upload(array(
								   'name'        => $db_name,
								   'id'          => $db_name,
								   'maxlength'   => '100'
							));
						}
					}
					break;
			}
			$fields[$rus_name]=$content;
		}
		return $fields;
	}
	
	protected function load_file($from, $meta){
		$to_path="/dir_images/";
		$types="*";
		$to_name="{$this->table}_{$this->current_id}";
		return $this->load_file_abstract($from, $to_path, $to_name, $types, 0, 0, "", "fixed");
	}
	
	protected function after_action_common(){
		$item=$this->get_by_id($this->current_id);
		if($item['type']=="file"){
			foreach($this->fields_array as $db_name=>$type){
				switch($type){
					case 'textarea':
						$meta=isset($this->meta_array[$db_name])?$this->meta_array[$db_name]:"";
						$this->update($this->current_id,array("value"=>"/dir_images/settings_{$this->current_id}".$this->load_file($db_name, $meta)));
					break;
				}
			}
		}
	}
	
}
?>