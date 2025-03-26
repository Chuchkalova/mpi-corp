<?
class settings_model extends MY_Model{
	protected $table = 'settings';
	
	public function get_settings(){
		$settings=$this->settings_model->get_list(array(),'id','value');
		return $settings;
	}
	
}
?>