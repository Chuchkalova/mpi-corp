<?
class regions_model extends MY_Model{
	protected $table = 'regions';
	protected $table_child = 'regions';
	protected $table_parent = 'regions';		
		
	public function get_regions(){
		$regions=$this->get_page(array(),null,null,"rus");
		$result=array();
		foreach($regions as $item_one){
			$result[$item_one['en']]=$item_one['rus'];
		}
		return $result;
	}
	
	public function init(){
		$this->template->write_view('regions','tmpl/regions',array(
			'regions'=>$this->get_regions(),
		));
	}
	
}

?>