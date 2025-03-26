<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class block_positions extends MY_Table {
	protected $table='block_positions';
	protected $table_top='block_positions';
	protected $controller="block_positions";
	
	public function block_positions(){
		parent::__construct();
		
		if(!$this->session->userdata('super')){
			redirect('permission/');
			return;
		}		
    }
	
	public function ajax(){
		$post=$this->input->post();
		
		$methods=$this->block_positions_model->empty_select();
		$parametrs="";
		
		if($post['model']){
			$methods="";
			$methods_list=$this->block_positions_model->get_methods($post['model']);
			foreach($methods_list as $opt=>$val){
				$selected="";
				if(isset($post['method'])&&$post['method']==$opt){
					$selected=" selected='selected' ";
				}
				$methods.="<option value='$opt' $selected>$val</option>";
			}
			
			if(isset($post['method'])&&$post['method']){
				$item_id=isset($post['item_id'])?$post['item_id']:0;
				$parametrs=$this->block_positions_model->get_parametrs($post['model'],$post['method'],$item_id);
			}
		}
		
		echo json_encode((object)array(
			'methods' => $methods,
			'parametrs' => $parametrs,
		));
	}

	

}

?>