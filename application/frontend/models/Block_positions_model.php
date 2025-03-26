<?
class block_positions_model extends MY_Model{
	protected $table = 'block_positions';
	
	public function init($tmpl_name){
		$blocks=$this->get_page(array('is_block'=>0,),null,null,"order");
		foreach($blocks as $block){
			if($block['url_filter']){
				if($block['is_url_full']){
					if(current_url()!=site_url($block['url_filter'])){
						continue;
					}
				}
				else{
					if(strpos(current_url(),$block['url_filter'])===false){
						continue;
					}
				}
			}
			$this->load->model($block['model']."_model");
			$parametrs=json_decode($block['parametrs']);
			$text=$this->{$block['model']."_model"}->{$block['method']}($parametrs);
			$this->template->write($block['position'], $text);
		}
	}
	
}

?>