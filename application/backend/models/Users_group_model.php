<?

class users_group_model extends MY_Model{
	protected $table = 'users_group';
	protected $table_child = 'users';
	protected $table_parent = 'users_group';
	protected $controller= 'users';
	protected $pages=20;
	protected $order_field="name";
	protected $order_type="asc";
	protected $name="Группы пользователей";
	protected $module_id=2;
	
	protected $fields=array(
		'name'=>array('text','Наименование',true,'subitem_td', 'text_like','','Наименование',),
		'pid'=>array('select','Группа',),
	);
	protected $add_fields=array(
		'edit_group_echo',
		'delete_group_echo'
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
		$permission_set=$this->modules_model->get_full_set(0, $edit_id);
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
		$this->modules_model->update_rools($this->current_id, 1, $post['module']);
		unset($post['module']);
		return $post;
	}
	
	public function after_insert_item(){
		$this->after_action_common();
		$this->modules_model->update_rools($this->current_id, 1, $this->rools);
	}	
}

?>