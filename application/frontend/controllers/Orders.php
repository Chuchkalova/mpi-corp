<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class orders extends MY_ControllerTmpl {
	var $table="orders";
	var $table_top="orders_group";

	public function add_cart_ajax($item_id, $count=1){	
		$this->orders_model->add_cart($item_id, $count);
		echo json_encode((object)$this->orders_model->cart_info());
	}
	
	public function update_cart_ajax(){
		$this->orders_model->update_cart($this->input->post('items'));
		echo json_encode((object)$this->orders_model->cart_info());
	}
	
	public function delete_cart_ajax($item_id, $count=0){
		$this->orders_model->delete_cart($item_id, $count);
		echo json_encode((object)$this->orders_model->cart_info());
	}
	
	public function delete_cart_ajax_block($pid){
		$items=$this->orders_model->get_cart_items();
		foreach($items as $item_one){
			if($item_one['parent_id']==$pid){
				$this->orders_model->delete_cart($item_one['rowid'], 0);
			}
		}
		echo json_encode((object)$this->orders_model->cart_info());
	}

	public function cart(){
		$this->load->model('mains_model');
		$item=$this->mains_model->get_by_id(90);
		$this->orders_group_model->load_meta($item);
		
		$items=$this->orders_model->get_cart_items();
		
		if(count($items)>0){
			$items_po=$items_oborud=array();
			foreach($items as $item_one){
				if($item_one['parent_id']==1){
					$items_po[]=$item_one;
				}
				else if($item_one['parent_id']==5){
					$items_oborud[]=$item_one;
				}
			}
			$this->template->write_view('content_main', 'orders/cart', array(
				'items_po'=>$items_po,
				'items_oborud'=>$items_oborud,				
				'item'=>$item,
			));
		}
		else{
			$item=$this->mains_model->get_by_id(201);
			$this->template->write_view('content_main', 'orders/cart_empty', array(
				'item'=>$item,
			));
		}
		
		$this->template->render();
	}
	
	function update(){
		$qty = $this->input->post('qty');
		$this->orders_group_model->update_cart($qty);
	}
	
	function send_order(){
		if($this->cart->total_items()<=0||!$this->input->post('name')||!$this->input->post('phone')){
			redirect('/orders/cart');
			exit;
		}
		
		$fields=array('name','phone','email','comment','city','street','org',);
		$order=array();
		foreach($fields as $item_one){
			$order[$item_one]=($this->input->post($item_one))?$this->input->post($item_one):"";
		}
		
		$order_id=$this->orders_model->insert_order($order);
		$email_text=$this->orders_model->email_text($order_id);
		
		$this->load->model('forms_model');
		$this->forms_model->email('Заказ на сайте '.$_SERVER["SERVER_NAME"], $this->settings[1], $email_text);
		if($this->input->post('email')){
			$this->forms_model->email('Заказ на сайте '.$_SERVER["SERVER_NAME"], $this->input->post('email'), $email_text);
		}
		$this->cart->destroy();
		
		redirect("/mains/show/orders_success");
	}
	
}
?>