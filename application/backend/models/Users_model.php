<?

class users_model extends MY_Model{
	protected $table = 'users';
	protected $table_child = 'users';
	protected $table_parent = 'users_group';
	protected $controller= 'users';
	protected $pages=20;
	protected $order_field="login";
	protected $order_type="asc";
	protected $name="Пользователи";
	protected $module_id=2;
	
	var $fields=array(
		'login'=>array('text','Логин*',true,'show_td', 'text_like','','Логин'),
		'name'=>array('text','Имя*',true, 'show_td', 'text_like','','Имя'),
		'second_name'=>array('text','Отчество'),
		'third_name'=>array('text','Фамилия',false,'show_td', 'text_like','','Фамилия',),
		'phone'=>array('text','Телефон',false,'show_td','text_like','','Телефон',),
		'email'=>array('text','Email',false,'show_td','text_like','','Email',),
		'address'=>array('text','Адрес'),		
		'pid'=>array('select','Группа'),
		'password'=>array('password','Пароль'),
		'confirm'=>array('text','Строка-подтверждение'),
	);
	
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
	);
	
	public function get_after_add_fields($pid){
		$this->load->model("modules_model");
		$permission_set=$this->modules_model->get_full_set();
		return $this->load->view('users/get_after_edit_fields', array(
			'permission_set'=>$permission_set,
		),true);
	}
	
	public function get_after_edit_fields($edit_id){
		$this->load->model("modules_model");
		$permission_set=$this->modules_model->get_full_set($edit_id);
		return $this->load->view('users/get_after_edit_fields', array(
			'permission_set'=>$permission_set,
		),true);
	}
	
	private $rools;
	public function before_insert_item($post){
		$post=parent::before_insert_item($post);
		$this->rools=$post['module'];
		unset($post['module']);
		return $post;
	}
	
	public function before_update_item($post){
		$post=parent::before_update_item($post);
		$this->load->model("modules_model");
		$this->modules_model->update_rools($this->current_id, 0, $post['module']);
		unset($post['module']);
		if(!$post['password']){
			unset($post['password']);
		}
		return $post;
	}
	
	public function after_insert_item(){
		$this->after_action_common();
		$this->modules_model->update_rools($this->current_id, 0, $this->rools);
	}
}
?>