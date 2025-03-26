<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class MY_Cart extends CI_Cart{

	function has_id($id){
		$result = false;
		if($this->total_items() > 0){
			foreach($this->contents() as $item){
				if($item['id'] == $id){
					$result = true;
					break;
				}
			}
		}
		return $result;
	}
	
	function get_by_id($id){
		$result = false;
		if($this->total_items() > 0){
			foreach($this->contents() as $item){
				if($item['id'] == $id){
					$result = $item;
					break;
				}
			}
		}
		return $result;
	}
	
	function total_items_qty(){
		$result = 0;
		if($this->total_items() > 0){
			foreach($this->contents() as $item){
				$result += $item['qty'];
			}
		}
		return $result;
	}
	
	function delete_by_id($id, $count){
		if($this->total_items() > 0){
			foreach($this->contents() as $item){
				if($item['rowid'] == $id){
					if($count==0) $count=$item['qty'];
					$this->update(array(
					   'rowid' => $item['rowid'],
					   'qty'   => $item['qty']-$count,
					));
					break;
				}
			}
		}
		return true;
	}
	
}

?>