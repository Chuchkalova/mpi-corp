<?
class catalogs_model extends MY_Model{
	protected $table = 'catalogs';
	protected $table_child = 'catalogs';
	protected $table_parent = 'catalogs_group';
	protected $controller= 'catalogs';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Товары";
	protected $module_id=11;
	//protected $gallerys_group_id=3;
	
	var $fields=array(
		'name'=>array('text','Наименование',true,'show_td','text_like','','Наименование'),
		'articul'=>array('text','Артикул',),
		'pid'=>array('select','Предок'),
		'short_text'=>array('ckeditor','Краткое содержимое'),
		'text'=>array('ckeditor','Полное содержимое'),
		//'marer_id'=>array('select','Производитель',false,'','','','','maders_model;id;name'),
		//'products_types'=>array('select','Вид продукта',false,'','','','','products_types_model;id;name'),
		
		'price'=>array('text','Цена',false,'input_td','','','Цена'),
		'discount'=>array('text','Скидка',false,'input_td','','','Скидка'),
		'currency'=>array('select','Валюта'),
		'count'=>array('text','Наличие'),
		
		'order'=>array('text','Порядок',false,'input_td','','','Порядок'),
		'is_show'=>array('checkbox','Показать',false,'checkbox_td','','','Показ'),
		'date'=>array('date','Дата',false,'date_td','','','Дата'),
		
		'file1'=>array('file','Изображение (170x120)'),
		'file2'=>array('file','Изображение 2'),
		'file3'=>array('file','Изображение 3'),
		'file4'=>array('file','Изображение 4'),
		'gallery_id'=>array('gallery','Галерея'),
		
		'url'=>array('text','URL'),
		'h1'=>array('text','h1'),
		'meta_title'=>array('long_text','meta-title'),
		'meta_description'=>array('long_text','meta-description'),
		'meta_keywords'=>array('long_text','meta-keywords'),
	
		'is_new'=>array('checkbox','Новинка','checkbox_td','','','Новинка'),
		'is_hit'=>array('checkbox','Хит','checkbox_td','','','Хит'),
		'is_sale'=>array('checkbox','Распродажа','checkbox_td','','','Распродажа'),
	);
	
	//дополнительные функции в отдельном столбце
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
		'hide_id_echo'
	);
		
	public function submit_table($pid){
		return "Обновить";
	}
	
	public function select_currency($db_field){
		return array('rub'=>'Рубль', 'usd'=>'Доллар', 'eur'=>'Евро');
	}
	
	protected function get_abstract_fields($item_id, $is_insert=false){
		$fields=parent::get_abstract_fields($item_id, $is_insert);
		
		if($this->uri->segment(2)=="add_subitem"||$this->uri->segment(2)=="edit_subitem"){
			$real_fields=array();
			foreach($fields as $field_name=>$field_content){
				if($field_name=="Предок"){
					$field_content="";
					$field_content.=form_hidden("pid", -1);
					if($is_insert){
						$field_content.=form_hidden("item_parent", $item_id);
					}
					else{
						$item=$this->get_by_id($item_id);
						$field_content.=form_hidden("item_parent", $item['item_parent']);
					}
				}
				$real_fields[$field_name]=$field_content;	
			}
			return $real_fields;
		}
		else{
			return $fields;
		}
	}
	
	public function get_ref($pid){
		$refs=parent::get_ref($pid);
		if($this->uri->segment(2)=="edit_subitem"){
			$item=$this->get_by_id($pid);
			$parent=$this->get_by_id($item['item_parent']);
			$refs=parent::get_ref($parent['id']);
			$refs[site_url("catalogs/edit/{$parent['id']}")]=$parent['name'];
			return $refs;
		}
		else{
			return $refs;
		}
	}
	
	protected function after_action_redirect($post){
		if($this->redirect=="save"){
			$pid=isset($post['pid'])?intval($post['pid']):0;
			
			if($pid==-1){
				redirect($this->controller."/edit_subitem/".$this->current_id);
			}
			else if($this->table==$this->table_parent&&$this->table!=$this->table_child){
				redirect($this->controller."/edit_group/".$this->current_id);
			}
			else{
				redirect($this->controller."/edit/".$this->current_id);
			}
		}
		else{
			$pid=isset($post['pid'])?intval($post['pid']):0;
			if($pid==-1){
				redirect($this->controller."/edit/".$post['item_parent']);
			}
			else{
				redirect($this->controller."/show/".$pid);
			}
		}
	}
	
	protected function update_table($pid, $post){
		$fields=array('order','price','discount','is_show','is_new','is_hit','is_sale');
		if(isset($post['hide_id'])&&count($post['hide_id'])){
			foreach($post['hide_id'] as $item_id=>$value){
				$update=array();
				foreach($fields as $field){
					if($this->can_rools($field)){
						if(strpos($field,"is_")===false){
							if(isset($post['table_'.$field][$item_id])){
								$update[$field]=$post['table_'.$field][$item_id];
							}
						}
						else{
							$update[$field]=isset($post['table_'.$field][$item_id])?true:false;
						}
					}
				}
				if(count($update)){
					$this->update($item_id, $update);
				}
			}
		}
	}
		
	public function get_after_add_fields($pid){
		if($this->config['settings']['module']['data']['is_type']['value']){
			if($this->uri->segment(2)=="add_subitem"){
				$item=$this->get_by_id($pid);
				$real_pid=$item['pid'];
			}
			else{
				$real_pid=$pid;
			}

			$parent=$this->{$this->table_parent."_model"}->get_by_fields(array('id'=>$real_pid,));
			
			$this->load->model("types_group_model");
			$types_set=$this->types_group_model->get_types_set($parent['type_id']);
			
			return $this->load->view('catalogs/get_after_edit_fields', array(
				'types_set'=>$types_set,
				'subitems'=>array(),
				'categories_set'=>array(),
				'categories_new_set'=>array(),
				'settings'=>array(),
			),true);
		}
		else{
			return "";
		}
	}
	
	public function get_after_edit_fields($edit_id){	
		if($this->uri->segment(2)=="edit_subitem"){
			$item=$this->get_by_id($edit_id);
			$item=$this->get_by_id($item['item_parent']);
			$real_pid=$item['pid'];
			
		}
		else{
			$item=$this->get_by_id($edit_id);
			$real_pid=$item['pid'];
		}
		
		$parent=$this->{$this->table_parent."_model"}->get_by_fields(array('id'=>$real_pid,));
		
		if($this->config['settings']['module']['data']['is_type']['value']){
			$this->load->model("types_group_model");
			$types_set=$this->types_group_model->get_types_set($parent['type_id'],$edit_id);
		}
		else{
			$types_set=array();
		}
		
		if($this->config['settings']['module']['data']['is_extra']['value']){
			$this->load->model("catalogs_extra_group_model");
			$categories_set=$this->catalogs_extra_group_model->get_categories($edit_id);
			$categories_new_set=$this->catalogs_extra_group_model->get_new_categories($edit_id);
		}
		else{
			$categories_set=array();
			$categories_new_set=array();
		}
		
		if($this->config['settings']['module']['data']['is_variants']['value']){
			$subitems=$this->get_page(array('is_block'=>0,'item_parent'=>$edit_id,),null,null,"order");
		}
		else{
			$subitems=array();
		}
		
		$this->load->model('catalogs_products_types_model');
		$this->load->model('products_types_model');
		$products_types=$this->products_types_model->get_list(array('is_block'=>0,),'id','name');
		$active_products_types=$this->catalogs_products_types_model->get_list(array('catalogs_id'=>$edit_id,),'products_types_id','products_types_id');
		
		return $this->load->view('catalogs/get_after_edit_fields', array(
			'subitems'=>$subitems,
			'types_set'=>$types_set,
			'categories_set'=>$categories_set,
			'categories_new_set'=>$categories_new_set,
			'settings'=>$this->config['settings']['module']['data'],
			'item_id'=>$edit_id,
			'products_types'=>$products_types,
			'active_products_types'=>$active_products_types,
		),true);
	}
	
	private $additional_fields;
	public function before_insert_item($post){
		$post=parent::before_insert_item($post);
		if(isset($post['add_fields'])){
			$this->additional_fields=$post['add_fields'];
			unset($post['add_fields']);
		}
		return $post;
	}
	
	public function before_update_item($post){
		$post=parent::before_update_item($post);

		if($this->config['settings']['module']['data']['is_type']['value']){
			if(!isset($post['add_fields'])){
				$post['add_fields']=array();
			}
			$this->load->model("types_group_model");
			$this->types_group_model->update_catalog_item($this->current_id, $post['add_fields']);
			unset($post['add_fields']);
		}
		
		if($this->config['settings']['module']['data']['is_extra']['value']){
			if($post['add_catalog_group']){
				$this->load->model("catalogs_extra_group_model");
				$this->load->model("catalogs_group_model");
				if(!$this->catalogs_group_model->get_count(array('is_block'=>0,'pid'=>$post['add_catalog_group'],))){
					$this->catalogs_extra_group_model->insert_or_update(
						array('item_id'=>$this->current_id,'group_id'=>$post['add_catalog_group'],),
						array('item_id'=>$this->current_id,'group_id'=>$post['add_catalog_group'],)
					);
				}
			}
			unset($post['add_catalog_group']);
		}
		
		if($this->config['settings']['module']['data']['is_variants']['value']){
			if(isset($post['subitems'])){
				foreach($post['subitems'] as $element_id=>$element){
					$this->update($element_id, array(
						'name'=>$element['name'],
						'price'=>$element['price'],
						'count'=>$element['count'],
						'order'=>$element['order'],
						'is_show'=>isset($element['is_show']),
					));
				}
				unset($post['subitems']);
			}
		}
		
		$this->load->model('catalogs_products_types_model');
		$this->catalogs_products_types_model->delete_where(array(
			'catalogs_id'=>$this->current_id,
		));
		if(isset($post['products_types'])){	
			foreach($post['products_types'] as $element_id){
				$this->catalogs_products_types_model->insert(array(
					'catalogs_id'=>$this->current_id,
					'products_types_id'=>$element_id,
				));
			}
			unset($post['products_types']);
		}
		
		
		return $post;
	}
	
	public function after_insert_item(){
		if($this->config['settings']['module']['data']['is_type']['value']){
			$this->load->model("types_group_model");
			$this->after_action_common();
			if($this->additional_fields&&count($this->additional_fields)){
				$this->types_group_model->update_catalog_item($this->current_id, $this->additional_fields);
			}
		}
		else{
			return parent::after_insert_item();
		}
	}
	
	protected function get_show_list($condition, $start, $kol){
		if(!is_array($condition)){
			$pattern = '/catalog.pid=\'(\d+)\'/i';
			$replacement = '(catalog.pid=\'$1\' or exists(select 1 from catalog_extra_group where item_id=catalog.id and group_id=$1))';
			$condition=preg_replace($pattern, $replacement, $condition);
		}
		$items=$this->get_page($condition, $start, $kol, $this->order_field." ".$this->order_type);
		return $items;	
	}
	
	public function get_count_table($condition){
		$pattern = '/catalog.pid=\'(\d+)\'/i';
		$replacement = '(catalog.pid=\'$1\' or exists(select 1 from catalog_extra_group where item_id=catalog.id and group_id=$1))';
		$condition=preg_replace($pattern, $replacement, $condition);
		return $this->get_count($condition);
	}
	
	public function check_variant($pid){
		if($this->get_count(array("pid"=>$pid, "is_block"=>"0"))){
			return true;
		}
		$this->load->model('catalogs_extra_group_model');
		if($this->catalogs_extra_group_model->get_count(array("group_id"=>$pid))){
			return true;
		}
		return false;
	}
	
	
	
}

?>