<?
class programs_model extends MY_Model{
	protected $table = 'programs';
	protected $table_child = 'programs';
	protected $table_parent = 'programs';
	protected $controller= 'programs';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Программы курсов";
	protected $module_id=32;

	var $fields=array(
		'name'=>array('long_text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'pid'=>array('hidden','Предок'),
		'hours'=>array('text','Время'),
		'text'=>array('ckeditor','Описание'),		
		
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
	
	public function get_ref($pid){
		$refs=array();
		$this->load->model('educations_model');
		
		if($this->uri->segment(2)=='add'){
			$item=$this->educations_model->get_by_id($pid);
			$refs[site_url("educations/edit/$pid")]=$item['name'];
		}
		else{
			$item=$this->get_by_id($pid);
			$item=$this->educations_model->get_by_id($item['pid']);
			$refs[site_url("educations/edit/$pid")]=$item['name'];
		}
		
		$refs[site_url("educations")]='Учебный центр';
		
		return array_reverse($refs);
	}
	
	protected function after_action_redirect($post){
		if($this->redirect=="save"){
			redirect($this->controller."/edit/".$this->current_id);
		}
		else{
			$pid=isset($post['pid'])?intval($post['pid']):0;
			redirect("educations/edit/".$pid);
		}
	}

}

?>