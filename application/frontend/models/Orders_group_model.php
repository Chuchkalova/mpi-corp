<?
class orders_group_model extends MY_Model{
	protected $table = 'orders_group';
	protected $table_child = 'orders';
		
	public function cart($parametrs){
		$cart_content=$this->load->view('orders/cart_content', array(
			'parametrs'=>$parametrs,
		),true);
		return $this->load->view('orders/cart', array(
			'cart_content'=>$cart_content,
		),true);
	}
	
	public function ajax_cart(){
		return array(
			'count'=>$this->cart->total_items_qty(),
			'summa'=>$this->cart->total()
		);
	}
	
	public function add_cart($item_id, $count, $is_matras=0){
		$this->load->model('catalog_model');
		if($result=$this->cart->get_by_id($item_id, $is_matras)){
			$data = array(
			   'rowid' => $result['rowid'],
			   'qty'   => $result['qty']+$count,
			);
			$this->cart->update($data);
		}
		else{
			$this->load->model('brands_model');
			$this->load->model('matras_model');
			$this->load->model('matras_brands_model');
			if(!$is_matras){
				$item=$this->catalog_model->get_by_id($item_id);
				if($item['mader_id']){
					$mader=$this->brands_model->get_by_id($item['mader_id']);
				}		
			}
			else{
				$this->load->database('matras', TRUE);
				$item=$this->matras_model->get_by_id($item_id);
				if($item['mader_id']){
					$mader=$this->matras_brands_model->get_by_id($item['mader_id']);
				}	
				$this->load->database('default', TRUE);
			}
			if(isset($mader['name'])){
				$item['mader']=$mader['name'];
				$item['price']=$mader['margin_plus']+intval(($item['price']*(100+$mader['margin']))/1000)*10;
			}
			
			$cart_item = array(
				'id'      => $item_id,
				'qty'     => $count,
				'price'   => ceil($item['price']*1),
				'name'    => time().rand(0, 100),
				'is_matras'=>$is_matras,
            );
			$this->cart->insert($cart_item);
		}
	}
	
	public function update_cart($post){
		$this->load->model('catalog_model');
		if($this->cart->total_items() > 0){
			foreach($this->cart->contents() as $item_one){
				$count=(isset($post[$item_one['rowid']]))?(int)$post[$item_one['rowid']]:0;
				$data = array(
				   'rowid' => $item_one['rowid'],
				   'qty'   => $count,
				);
				$this->cart->update($data);
			}
		}
		
		return array(
			'count'=>$this->cart->total_items_qty(),
			'summa'=>$this->cart->total()
		);
	}
	
	public function get_cart_content(){
		$this->load->model('catalog_model');
		$this->load->model('matras_model');
		$this->load->model('brands_model');
		$this->load->model('matras_brands_model');
		$cart_content=array();
		if($this->cart->total_items()>0){
			foreach($this->cart->contents() as $item){
				if($item['is_matras']==0){
					$product = $this->catalog_model->get_by_id($item['id']);
					if($product['mader_id']){
						$mader=$this->brands_model->get_by_id($product['mader_id']);
						if(isset($mader['name'])){
							$product['mader']=$mader['name'];
							$product['price']=$mader['margin_plus']+intval(($product['price']*(100+$mader['margin']))/1000)*10;
						}
					}
					if($product['item_parent']){
						$parent=$this->catalog_model->get_by_id($product['item_parent']);
					}
				}
				else{
					$this->load->database('matras', TRUE);
					$product=$this->matras_model->get_by_id($item['id']);
					if($product['mader_id']){
						$mader=$this->matras_brands_model->get_by_id($product['mader_id']);
						if(isset($mader['name'])){
							$product['mader']=$mader['name'];
							if(!isset($mader['margin_plus']))$mader['margin_plus']=0;
							$product['price']=$mader['margin_plus']+intval(($product['price']*(100+$mader['margin']))/1000)*10;
						}
					}
					if($product['item_parent']){
						$parent=$this->matras_model->get_by_id($product['item_parent']);
					}
					$this->load->database('default', TRUE);
				}
				
				if(!empty($product)){
					if($product['item_parent']){
						$product['image_id']=$parent['id'];
						$product['url']=$parent['url'];
						$product['name']=$parent['name']." ({$product['name']})";
					}
					else{
						$product['image_id']=$product['id'];
					}
					$product['rowid']=$item['rowid'];
					$product['qty']=$item['qty'];
					$product['is_matras']=$item['is_matras'];
					$cart_content[]=$product;
				}
				else{
					$data = array(
					   'rowid' => $item['rowid'],
					   'qty'   => 0
					);
					$this->cart->update($data);
				}
			}
		}
		return $cart_content;
	}
	
	public function delete_cart($item_id, $count){
		$this->cart->delete_by_id($item_id, $count);
		return array(
			'count'=>$this->cart->total_items_qty(),
			'summa'=>$this->cart->total()
		);
	}
	
	public function insert_order($data){
		$order_id=$this->insert($data);
		$this->load->model('orders_model');
		$this->load->model('brands_model');
		$this->load->model('catalog_model');
		$this->load->model('matras_model');
		$this->load->model('matras_brands_model');
		foreach($this->cart->contents() as $item){
			if(!$item['is_matras']){
				$item_data = $this->catalog_model->get_by_id($item['id']);
				if($item_data['mader_id']){
					$mader=$this->brands_model->get_by_id($item_data['mader_id']);
					if(isset($mader['name'])){
						$item_data['mader']=$mader['name'];
						$item_data['price']=$mader['margin_plus']+intval(($item_data['price']*(100+$mader['margin']))/1000)*10;
					}
				}	
			}
			else{
				$this->load->database('matras', TRUE);
				$item_data = $this->matras_model->get_by_id($item['id']);
				if($item_data['mader_id']){
					$mader=$this->matras_brands_model->get_by_id($item_data['mader_id']);
					if(isset($mader['name'])){
						$item_data['mader']=$mader['name'];
						$item_data['price']=$mader['margin_plus']+intval(($item_data['price']*(100+$mader['margin']))/1000)*10;
					}
				}	
				$this->load->database('default', TRUE);
			}
			$this->orders_model->insert(array(
				'pid'=>$order_id,
				'item_id'=>$item['id'],
				'price'=>ceil($item_data['price']*1),
				'count'=>$item['qty'],
				'is_matras'=>$item['is_matras'],
			));
		}
		
		return $this->email_text($data);
	}
	
	public function email_text($data){
		$this->load->model('catalog_model');
		$this->load->model('orders_model');
		$this->load->model('brands_model');
		$this->load->model('matras_model');
		$this->load->model('matras_brands_model');
		
		$this->load->library('table', '', 'my_table');
		
		$this->my_table->set_heading(array('ID', 'Наименование', 'Количество', 'Цена'));
		$price_all = 0;
		if($this->cart->total_items() > 0) {
			foreach($this->cart->contents() as $item){
				if(!$item['is_matras']){
					$item_data = $this->catalog_model->get_by_id($item['id']);
					if($item_data['item_parent']){
						$item_parent=$this->catalog_model->get_by_id($item_data['item_parent']);
						$item_data['name']=$item_parent['name']." ({$item_data['name']})";
					}
					if($item_data['mader_id']){
						$mader=$this->brands_model->get_by_id($item_data['mader_id']);
						if(isset($mader['name'])){
							$item_data['mader']=$mader['name'];
							$item_data['price']=$mader['margin_plus']+intval(($item_data['price']*(100+$mader['margin']))/1000)*10;
						}
					}
				}
				else{
					$this->load->database('matras', TRUE);
					$item_data = $this->matras_model->get_by_id($item['id']);
					if($item_data['item_parent']){
						$item_parent=$this->matras_model->get_by_id($item_data['item_parent']);
						$item_data['name']=$item_parent['name']." ({$item_data['name']})";
					}
					if($item_data['mader_id']){
						$mader=$this->matras_brands_model->get_by_id($item_data['mader_id']);
						if(isset($mader['name'])){
							$item_data['mader']=$mader['name'];
							$item_data['price']=$mader['margin_plus']+intval(($item_data['price']*(100+$mader['margin']))/1000)*10;
						}
					}
					$this->load->database('default', TRUE);
				}
					
				$item_data['name']="<a href='".site_url("content/{$item_data['url']}")."'>".$item_data['name']."</a>";
				$price_all += ceil($item_data['price'] * 1 * $item['qty']);

				$this->my_table->add_row(array(
					$item_data['id'],
					$item_data['name'],
					$item['qty'],
					$item_data['price'],
				));
			}
		}
		
		$tmpl = array('table_open' => '<table border="0" cellspacing="0" cellpadding="7" style="border-collapse: collapse; font-size: 12px; margin: 0px 0px 20px 0px; padding: 0px;">');
		$this->my_table->set_template($tmpl);
		$table_generated=$this->my_table->generate();
		$data['table_generated']=$table_generated;
		$data['price_all']=$price_all;
		
		$this->my_table->clear();
		
		$email_body = $this->load->view('orders/email', $data, true);
		
		return $email_body;
	}
	
	
	
	public function get_summa($order_id){
		$items=$this->orders_model->get_page(array('is_block'=>0,'pid'=>$order_id));
		$summa=0;
		foreach($items as $item){
			$summa+=$item['count']*$item['price'];
		}
		return $summa;
	}
}

?>