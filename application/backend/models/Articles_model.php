<?
class articles_model extends MY_Model{
	protected $table = 'articles';
	protected $table_child = 'articles';
	protected $table_parent = 'articles_group';
	protected $controller= 'articles';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Статьи";
	protected $module_id=4;
	//protected $gallerys_group_id=5;

	var $fields=array(
		'name'=>array('long_text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'pid'=>array('select','Предок'),
		'address'=>array('text','Адрес'),
		'short_text'=>array('ckeditor','Краткое содержимое'),
		'text2'=>array('ckeditor','Текст на синем фоне'),
		'text3'=>array('ckeditor','Аннотация'),		
		'text'=>array('ckeditor','Полное содержимое'),
		
		'is_show'=>array('checkbox','Показать',false, 'checkbox_td','','','Показ'),
		'order'=>array('text','Порядок', false, 'input_td','','','Порядок'),
		'date'=>array('date','Дата', false, 'date_td','','','Дата'),
		'time'=>array('text','Время'),	
		
		'file'=>array('file','Изображение (200x144)'),
		'gallery_id'=>array('gallery','Галерея'),
		
		'text4'=>array('ckeditor','Описание связанного товара'),
		'file2'=>array('file','Изображение связанного товара (230x176)'),
		'href'=>array('text','Ссылка на связанный товар'),	
		
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
		if($this->config['settings']['module']['data']['is_extra']['value']){
			$item=$this->get_by_id($edit_id);
			$parent=$this->{$this->table_parent."_model"}->get_by_id($item['pid']);
			$this->load->model($this->table_parent."_extra_model");
			$groups_set=$this->{$this->table_parent."_extra_model"}->get_groups($edit_id);
			$groups_new_set=$this->{$this->table_parent."_extra_model"}->get_new_groups($edit_id);
			
			return $this->load->view($this->controller.'/get_after_edit_fields', array(
				'groups_set'=>$groups_set,
				'groups_new_set'=>$groups_new_set,
				'item_id'=>$edit_id,
				'controller'=>$this->controller,
			),true);
		}
	}

	public function before_update_item($post){
		$post=parent::before_update_item($post);
		
		if(isset($post['add_extra'])&&$post['add_extra']){
			$this->load->model($this->table_parent."_extra_model");
			if(!$this->{$this->table_parent."_model"}->get_count(array('is_block'=>0,'pid'=>$post['add_extra'],))){
				$this->{$this->table_parent."_extra_model"}->insert_or_update(
					array('item_id'=>$this->current_id,'group_id'=>$post['add_extra'],),
					array('item_id'=>$this->current_id,'group_id'=>$post['add_extra'],)
				);
			}
		}
		unset($post['add_extra']);
		
		return $post;
	}
	
	protected function get_show_list($condition, $start, $kol){
		if($this->config['settings']['module']['data']['is_extra']['value']){
			if(!is_array($condition)){
				$pattern = "/{$this->table_child}.pid='(\d+)'/i";
				$replacement = "({$this->table_child}.pid='$1' or exists(select 1 from {$this->table_parent}_extra where item_id={$this->table_child}.id and group_id=$1))";
				$condition=preg_replace($pattern, $replacement, $condition);
			}
			$items=$this->get_page($condition, $start, $kol, $this->order_field." ".$this->order_type);
			return $items;	
		}
		else{
			return parent::get_show_list($condition, $start, $kol);
		}
	}
	
	public function get_count_table($condition){
		if($this->config['settings']['module']['data']['is_extra']['value']){
			$pattern = "/{$this->table_child}.pid='(\d+)'/i";
			$replacement = "({$this->table_child}.pid='$1' or exists(select 1 from {$this->table_parent}_extra where item_id={$this->table_child}.id and group_id=$1))";
			$condition=preg_replace($pattern, $replacement, $condition);
			return $this->get_count($condition);
		}
		else{
			return parent::get_count_table($condition);
		}
	}
	
	public function check_variant($pid){
		if($this->config['settings']['module']['data']['is_extra']['value']){
			if($this->get_count(array("pid"=>$pid, "is_block"=>0,))){
				return true;
			}
			$this->load->model($this->table_parent."_extra_model");
			if($this->{$this->table_parent."_extra_model"}->get_count(array("group_id"=>$pid,))){
				return true;
			}
			return false;
		}
		else{
			return parent::check_variant($pid);
		}
	}
}

?>