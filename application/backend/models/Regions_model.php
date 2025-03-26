<?
class regions_model extends MY_Model{
	protected $table = 'regions';
	protected $table_child = 'regions';
	protected $table_parent = 'regions';	
	
	public function clone_me($prefix){
		ini_set('memory_limit', '2048M');
		if(!file_exists($_SERVER['DOCUMENT_ROOT']."/{$prefix}/index.php")){
			$commands = file_get_contents($_SERVER['DOCUMENT_ROOT']."/regions/one.sql");
			file_put_contents($_SERVER['DOCUMENT_ROOT']."/regions/two.sql",str_replace("prefix_",$prefix."_",$commands));
			
			$this->run_sql_file($_SERVER['DOCUMENT_ROOT']."/regions/two.sql");
			unlink($_SERVER['DOCUMENT_ROOT']."/regions/two.sql");	
			
			mkdir($_SERVER['DOCUMENT_ROOT'].$prefix);
			
			copy($_SERVER['DOCUMENT_ROOT']."/regions/index.php",$_SERVER['DOCUMENT_ROOT']."/{$prefix}/index.php");
			
			copy($_SERVER['DOCUMENT_ROOT']."/regions/.htaccess",$_SERVER['DOCUMENT_ROOT']."/{$prefix}/.htaccess");
			$htaccess = file_get_contents($_SERVER['DOCUMENT_ROOT']."/{$prefix}/.htaccess");
			file_put_contents($_SERVER['DOCUMENT_ROOT']."/{$prefix}/.htaccess",str_replace("prefix",$prefix,$htaccess));
			return 1;
		}
		return 0;
	}
	
	public function init(){
		$init="Белоярский
Бердюжье";
		$inits=explode("\n",$init);
		foreach($inits as $init_one){
			$en=$this->transliterate($init_one);
			$this->insert(array(
				'en'=>$en,
				'rus'=>$init_one,
			));
		}
	}
	
	public function get_regions(){
		$regions=$this->get_page(array(),null,null,"rus");
		$result=array();
		foreach($regions as $item_one){
			$result[$item_one['en']]=$item_one['rus'];
		}
		return $result;
	}
		
		
}

?>