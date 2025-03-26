<?
class menus_model extends MY_Model{
	protected $table = 'menus';
	protected $table_child = 'menus';
	protected $table_parent = 'menus_group';
	protected $controller= 'menus';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Меню";
	protected $module_id=5;

	var $fields=array(
		'name'=>array('text','Наименование',true, 'show_td','text_like', '', 'Наименование'),
		'pid'=>array('select','Группа',),
		'module_id'=>array('select','Модуль',),
		'is_module_top'=>array('select','Тип страницы'),
		'element_id'=>array('select','Конкретная cтраница'),
		'url_this'=>array('select','ИЛИ специальная страница'),
		'order'=>array('text','Порядок',false,'input_td','','','Порядок'),
		'is_show'=>array('checkbox','Показать',false,'checkbox_td','','','Показ'),
		'class'=>array('text','Метка класса'),
	);
	
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
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
	
	public function select_module_id(){
		$this->load->model('modules_model');
		return $this->modules_model->get_list(array('is_menu'=>1,),'id','rus_name',true);
	}
	
	public function select_is_module_top(){
		return $this->empty_select();
	}
	
	public function select_element_id($db_field){
		return $this->empty_select();
	}
	
	public function select_url_this($db_field){
		return $this->empty_select();
	}
	
	public function get_names_by_module($module_id, $is_group){
		$this->load->model('modules_model');
		$module=$this->modules_model->get_by_fields(array('id'=>$module_id,));
		$model_name=$module['name'];
		if($is_group) $model_name.="_group";
		$model_name.="_model";
		$ret=$this->empty_select();

		if($this->model_exists($model_name)){
			$this->load->model($model_name);
			$select_values=$this->$model_name->get_list(array('is_block'=>0,),'id','name');
			
			$ret=$ret +$select_values;
		}
		return $ret;
	}
	
	public function get_is_module_top_by_module($module_id){
		$this->load->model('modules_model');
		$module=$this->modules_model->get_by_fields(array('id'=>$module_id,));
		$model_name=ucfirst($module['name']);
		
		$modules_top=array();
		if(file_exists(APPPATH."models/{$model_name}_model.php")){
			$modules_top[2]="Элемент";
		}
		if(file_exists(APPPATH."models/{$model_name}_group_model.php")){
			$modules_top[1]="Группа";
		}
		if(count($modules_top)!=1){
			$modules_top[0]="---";
		}
		ksort($modules_top);
		return $modules_top;
	}
	
	public function get_special_by_module($module_id, $is_group){
		$this->load->model('modules_model');
		$module=$this->modules_model->get_by_fields(array('id'=>$module_id,));
		$model_name=$module['name'];
		if($is_group) $model_name.="_group";
		$model_name.="_model";
		$ret=$this->empty_select();
		if($this->model_exists($model_name)){
			$this->load->model($model_name);
			$config=$this->$model_name->config();
			if(isset($config['special'])){
				$ret=array(-1=>'---')+$config['special'];
			}
		}
		return $ret;
	}
	
}

?>