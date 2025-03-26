<?
class extra_permissions_model extends MY_Model{
	var $table = 'extra_permissions';
	var $fields=array();
	
	public function check_permission($user_id, $module_id){
		$this->load->model("extra_permissions_variants_model");
		$variants=$this->extra_permissions_variants_model->get_page(array('module_id'=>$module_id,));
		$return=array();
		$this->load->model("users_model");
		$this->load->model("users_group_model");
		$user=$this->users_model->get_by_fields(array("id"=>$user_id));
		
		foreach($variants as $variant){
			$current=-1;
			if($item=$this->extra_permissions_model->get_by_fields(array("user_id"=>$user_id,"variant_id"=>$variant['id'],"is_group"=>0,))){
				if($item['value']!=2){
					$return[$variant['name']]=$item['value'];
					$current=$item['value'];
				}
			}
			if($current==-1){
				$pid=$user['pid'];
				while($pid!=0){
					if($item=$this->extra_permissions_model->get_by_fields(array("user_id"=>$pid,"variant_id"=>$variant['id'],"is_group"=>1,))){
						if($item['value']!=2){
							$return[$variant['name']]=$item['value'];
							$current=$item['value'];
							break;
						}
					}
					$group=$this->users_group_model->get_by_fields(array("id"=>$pid,));
					$pid=$group['pid'];
				}
			}
			if($current==-1){
				$return[$variant['name']]=0;
			}
		}
		return $return;
	}
}
?>