<?
class orders_model extends MY_Model{
	protected $table = 'orders';
	
	public function short_cart($params){
		return $this->load->view('orders/short_cart',array(
			'items'=>$this->get_cart_items()
		),true);
	}
	
	public function get_cart_items(){
		$items=array();
		$this->load->model('catalogs_model');
		if($this->cart->total_items()>0){
			foreach($this->cart->contents() as $item_one){
				$item=$this->catalogs_model->get_by_id($item_one['id']);
				$item['qty']=$item_one['qty'];
				$item['rowid']=$item_one['rowid'];
				$item['parent_id']=$this->catalogs_model->get_level1($item_one['id']);
				$items[]=$item;
			}
		}
		return $items;
	}
	
	public function add_cart($item_id, $count){
		$this->load->model('catalogs_model');
		$item=$this->catalogs_model->get_by_id($item_id);
		if(isset($item['id'])){
			$cart_item=$this->cart->get_by_id($item_id);
			if(isset($cart_item['rowid'])){
				$this->cart->update(array(
				   'rowid' => $cart_item['rowid'],
				   'qty'   => $cart_item['qty']+$count,

				));
			}
			else{
				$this->cart->insert(array(
					'id'      => $item['id'],
					'qty'     => $count,
					'price'   => $item['price'],
					'name'    => time().rand(0, 100),

				));
			}
		}
	}
	
	public function cart_info($item_id=null, $count = 1){
		$items=$this->get_cart_items();
		$count_po=$summa_po=$count_oborud=$summa_oborud=0;
		foreach($items as $item_one){
			if($item_one['parent_id']==1){
				$count_po+=$item_one['qty'];
				$summa_po+=$item_one['qty']*$item_one['price'];
			}
			else if($item_one['parent_id']==5){
				$count_oborud+=$item_one['qty'];
				$summa_oborud+=$item_one['qty']*$item_one['price'];
			}
		}
		if($item_id != null){
            $this->load->model('catalogs_model');
            $item=$this->catalogs_model->get_by_id($item_id);
        }
        else{
            $item=array('name'=>'','id'=>'','price'=>'');
        }
		return array(
			'count'=>$this->cart->total_items_qty(),
			'summa'=>$this->cart->total(),
			'count_po'=>$count_po,
			'summa_po'=>number_format($summa_po,0,'.',' '),
			'count_oborud'=>$count_oborud,
			'summa_oborud'=>number_format($summa_oborud,0,'.',' '),
			'summa_formatted'=>number_format($this->cart->total(),0,'.',' '),
            'add_name' => $item['name'],
            'add_id' => $item['id'],
            'add_price' => $item['price'],
            'add_count' => $count,
		);
	}
	
	public function update_cart($items){
		$this->load->model('catalogs_model');
		if($this->cart->total_items() > 0){
			foreach($this->cart->contents() as $item_one){
				$count=(isset($items[$item_one['rowid']]))?(int)$items[$item_one['rowid']]:0;
				$this->cart->update(array(
				   'rowid' => $item_one['rowid'],
				   'qty'   => $count,
				));
			}
		}
	}
	
	public function delete_cart($item_id, $count){
		$this->cart->delete_by_id($item_id, $count);
	}
	
	public function insert_order($order){
		$this->load->model('orders_group_model');
		$order_id=$this->orders_group_model->insert($order);
		
		$items=$this->get_cart_items();
		foreach($items as $item_one){
			$this->insert(array(
				'pid'=>$order_id,
				'catalogs_id'=>$item_one['id'],
				'price'=>$item_one['price'],
				'count'=>$item_one['qty'],
			));
		}
		
		return $order_id;
	}
	
	public function email_text($order_id){
		$items=$this->get_cart_items();
		$this->load->model('orders_group_model');
		$item=$this->orders_group_model->get_by_id($order_id);
		return $this->load->view('orders/email', array(
			'item'=>$item,
			'items'=>$items,
		), true);
	}
}

?>