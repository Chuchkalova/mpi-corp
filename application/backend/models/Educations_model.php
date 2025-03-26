<?
class educations_model extends MY_Model{
	protected $table = 'educations';
	protected $table_child = 'educations';
	protected $table_parent = 'educations_group';
	protected $controller= 'educations';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Учебный центр";
	protected $module_id=31;
	protected $gallerys_group_id=2;

	var $fields=array(
		'id'=>array('','ID',false,'show_td','text_like', '', 'ID'),
		'name'=>array('long_text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'pid'=>array('select','Предок'),
		'short_text'=>array('ckeditor','Краткое содержимое'),
		'text2'=>array('ckeditor','Текст на синем фоне'),
		'text'=>array('ckeditor','Полное содержимое'),
		
		'price'=>array('text','Цена'),
		'hours'=>array('text','Часов'),
		'days'=>array('text','Дней'),
		'similar_ids'=>array('text','ID похожих (через ,)'),
		
		'is_show'=>array('checkbox','Показать',false, 'checkbox_td','','','Показ'),
		'order'=>array('text','Порядок', false, 'input_td','','','Порядок'),
		//'date'=>array('date','Дата', false, 'date_td','','','Дата'),
		
		'file'=>array('file','Изображение (170x120)'),
		'file2'=>array('file','Программа',false,'','','','','200;150;fixed;jpg|png|gif|jpeg|doc|docx|pdf|xls|xlsx|pdf',),
		'gallerys_id'=>array('gallery','Галерея'),
		
		'url'=>array('text','URL'),
		'h1'=>array('text','h1'),
		'meta_title'=>array('long_text','meta-title'),
		'meta_description'=>array('long_text','meta-description'),
		'meta_keywords'=>array('long_text','meta-keywords'),
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
	
	public function get_after_edit_fields($edit_id){
		$this->load->model('programs_model');
		$programs=$this->programs_model->get_page(array('pid'=>$edit_id,'is_block'=>0,),null,null,'order');
		
		return $this->load->view($this->controller.'/get_after_edit_fields', array(
			'programs'=>$programs,
			'item_id'=>$edit_id,
			'controller'=>$this->controller,
		),true);
	}

	public function before_update_item($post){
		$post=parent::before_update_item($post);
		
		$this->load->model('programs_model');
		if(!empty($post['programs'])){
			foreach($post['programs'] as $program_id=>$data){
				$this->programs_model->update($program_id,array(
					'name'=>$data['name'],
					'order'=>$data['order'],
				));
			}
			unset($post['programs']);
		}
		
		return $post;
	}

	
	
}

?>