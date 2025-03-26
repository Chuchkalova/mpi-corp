<?
class blocks_model extends MY_Model{
	protected $table = 'blocks';
	
	public function show_strip_text($parametrs){
		$item=$this->get_by_id($parametrs->block_id);
		if(isset($item['text'])){
			return trim(strip_tags($item['text'],$parametrs->tags));
		}
		return "";
	}
	
	public function show_text($parametrs){
		$item=$this->get_by_id($parametrs->block_id);
		if(isset($item['text'])){
			return $item['text'];
		}
		return "";
	}	
	
}
?>