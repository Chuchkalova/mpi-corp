<?
class orders_group_model extends MY_Model{
	protected $table = 'orders_group';
	protected $table_child = 'orders';
	protected $table_parent = 'orders_group';
	protected $controller= 'orders';
	protected $pages=20;
	protected $order_field="date";
	protected $order_type="desc";
	protected $name="Заказы";
	protected $module_id=12;
	
	private $states=array(
		0=>'---',
		'new'=>'Новый',
		'in_work'=>'В работе',
		'done'=>'Отработанный',
		'deny'=>'Отказ',
	);
	
	private $payment_types=array(
		0=>'---',
		'nal'=>'Оплата наличными',
		'bill'=>'Оплата безналичным расчётом',
		'cart'=>'Оплата банковской картой',
	);
		
	/* 'Имя_в_БД' => array('тип_поля','русское_название', 'вывод_в_таблице', 'фильтр_в_таблице', 'фильтр_вверху', 'имя_колонки', 'мета_данные', 'права'),*/
	
	var $fields=array(
		'state'=>array('select','Статус',false,'state_td','select','','Статус'),	
		'id'=>array('','',false,'edit_group_td','text_equal','','Номер'),
		'date'=>array('date','Дата',false,'date_td','date_interval','','Дата'),
		//'date_delivery'=>array('date','Дата доставки',false,'date_td','date_interval','','Дата доставки'),
		
		//'user_id'=>array('select','Пользователь',false,'','','','','users_model;id;name'),
		'name'=>array('text','ФИО',true,'show_td','text_like','','ФИО'),
		'phone'=>array('text','Телефон',false,'show_td','text_like','','Телефон'),
		'email'=>array('text','Email',),
		'org'=>array('text','Организация',),
		
		'city'=>array('text','Город'),
		//'street'=>array('text','Улица'),
		//'house'=>array('text','Дом'),
		//'flat'=>array('text','Квартира'),
		
		
		
		'comment'=>array('ckeditor','Комментарий клиента'),
		'manager_comment'=>array('ckeditor','Комментарий менеджера'),

		//'payment_type'=>array('select','Тип оплаты'),	
		//'is_pay'=>array('checkbox','Оплачен',false, 'yesno_td','','','Оплачен'),
		//'payment_sum'=>array('text','Предоплата',false, 'show_td','text_like','','Предоплата'),

		'summa'=>array('','','show_td','','','Сумма'),
	);
	

	
	//дополнительные функции в отдельном столбце
	var $add_fields=array(
		'edit_group_echo',
		'delete_group_echo',
	);
	
	protected function select_state($db_field){
		return $this->states;
	}
	
	public function select_payment_type($db_field){
		return $this->payment_types;
	}
	
	protected function state_td($value, $item_id, $db_field){
		return $this->states[$value];
	}
	
	protected function edit_group_td($value, $item_id){
		$url=site_url("{$this->controller}/edit_group/{$item_id}/");
		return "<a href='$url'>$value</a>";
	}
	
	protected function get_show_list($condition, $start, $kol){
		$this->db->select('
			(SELECT SUM(orders.count*orders.price) FROM orders WHERE orders.pid=orders_group.id and orders.is_block=0) AS summa,
			orders_group.*', FALSE); 
		if($this->order_field." ".$this->order_type){
			$this->db->order_by($this->order_field." ".$this->order_type);
		}
		
		if(is_array($condition)){
			$this->db->where($condition);
		}
		else{
			$this->db->where($condition, null, false);
		}
		
		if($kol!==null){
			$query = $this->db->get($this->table, $kol, $start);
		}
		else{
			$query = $this->db->get($this->table);
		}
		return $query->result_array();	
	}
	
	public function get_after_edit_fields($edit_id){	
		$items=$this->orders_model->get_page(array('pid'=>$edit_id,'is_block'=>0,));
		
		$this->load->model('catalogs_model');
		foreach($items as &$item_one){
			$catalog_item=$this->catalogs_model->get_by_id($item_one['catalogs_id']);
			if($catalog_item['item_parent']){
				$catalog_item['url_part']="edit_subitem";
				$parent=$this->catalogs_model->get_by_id($catalog_item['item_parent']);
				$catalog_item['name']=$parent['name']." ({$catalog_item['name']})";
			}
			else{
				$catalog_item['url_part']="edit";
			}

			$item_one['item']=$catalog_item;
			$item_one['item']['mader']='';			
		}
		
		$str=$this->load->view('orders/get_after_edit_fields', array(
			'items'=>$items,
			'item_id'=>$edit_id,
		),true);
		
		
		return $str.parent::get_after_edit_fields($edit_id);
	}
	
	public function before_update_item($post){
		$post=parent::before_update_item($post);

		$this->load->model('catalogs_model');
		
		if(isset($post['prices'])){
			foreach($post['prices'] as $item_id => $val){
				$this->orders_model->update($item_id, array(
					'price'=>$post['prices'][$item_id],
					'count'=>$post['counts'][$item_id],
				));
			}
			unset($post['prices']);
			unset($post['counts']);
		}
		
		if(isset($post['new_item'])){
			if(trim($post['new_item'])){
				$new=$this->catalogs_model->get_by_fields(array(
					'articul'=>trim($post['new_item']),
					'is_block'=>0,
				));
				if(isset($new['id'])){
					$count=$this->orders_model->get_by_fields(array('is_block'=>0,'catalogs_id'=>$new['id'],));
					if(!$count){
						$this->orders_model->insert(array(
							'pid'=>$this->current_id,
							'price'=>$new['price'],
							'count'=>1,
							'catalogs_id'=>$new['id'],
						));
					}
				}
			}
			unset($post['new_item']);
		}
		
		return $post;
	}
	
}

?>