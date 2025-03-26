<?
class orders_model extends MY_Model{
	protected $table = 'orders';
	protected $table_child = 'orders';
	protected $table_parent = 'orders_group';
	protected $controller= 'orders';
	protected $pages=20;
	protected $order_field="id";
	protected $order_type="desc";
	protected $name="Заказы";
	protected $module_id=12;
	
	/* 'Имя_в_БД' => array('тип_поля','русское_название', 'вывод_в_таблице', 'фильтр_в_таблице', 'фильтр_вверху', 'имя_колонки', 'мета_данные', 'права'),*/
	
	var $fields=array(
		'pid'=>array('text','Номер заказа',),
		'name'=>array('','','articul_td',false,'','','Наименование'),
		'count'=>array('text','Число',true,'show_td','','','Число'),
		'price'=>array('text','Цена',true,'show_td','','','Цена'),
		'summa'=>array('','',true,'show_td','','','Сумма'),
	);
	
	//дополнительные функции в отдельном столбце
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
	);
	
	private $string_item;
	protected function articul_td($value, $item_id, $db_field){
		$item=$this->orders_model->get_by_id($item_id);
		return "<a href='".site_url("catalogs/edit/{$item['catalogs_id']}")."' target='_blank'>{$value}</a>";
	}
	
	protected function get_show_list($condition, $start, $kol){
		$this->db->select('(orders.count*orders.price) AS summa, catalogs.name, orders.*', FALSE); 
		if($this->order_field." ".$this->order_type){
			$this->db->order_by($this->order_field." ".$this->order_type);
		}
		
		$this->db->join('catalogs', 'catalogs.id = orders.catalogs_id');
		
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
	
}

?>