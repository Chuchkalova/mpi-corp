<?
class block_positions_model extends MY_Model{
	protected $table = 'block_positions';
	protected $table_child = 'block_positions';
	protected $table_parent = 'block_positions';
	protected $controller= 'block_positions';
	protected $pages=100;
	protected $order_field="position";
	protected $order_type="asc";
	protected $name="Позиции модулей";
	protected $module_id=1;
	
	var $fields=array(
		'model'=>array('select','Модель',true,'show_td','', '', 'Модель'),
		'method'=>array('select','Метод',true,'show_method','', '', 'Метод'),
		'position'=>array('select','Позиция',true,'show_td','', '', 'Позиция'),
		'order'=>array('text','Порядок',false,'show_td','','','Порядок'),
		'url_filter'=>array('text','Фильтр по URL',false,'show_td','','','Фильтр по URL'),
		'is_url_full'=>array('checkbox','Точное совпадение'),
		'is_url_exept'=>array('checkbox','Исключать URL'),
		'parametrs'=>array('','Параметры',),			
	);
	
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
		'hide_id_echo'
	);
	
	private $positions=array(
		'top1','top2','top3','top4','top5','top6','top7','top8','top9','top10',
		'menu1','menu2','menu3','menu4','menu5',
		'bottom1','bottom2','bottom3','bottom4','bottom5','bottom6','bottom7','bottom8','bottom9','bottom10',
		'left1','left2','left3','left4','left5',
		'right1','right2','right3','right4','right5',
		'content1','content2','content3','content4','content5',
	);
	
	public function show_method($value, $item_id, $db_field){
		$item=$this->get_by_id($item_id);
		$model_name=$item['model']."_model";
		if($this->model_exists($model_name)){
			$this->load->model($model_name);
			$config=$this->$model_name->config();
			if(isset($config['functions'][$value])){
				return $config['functions'][$value]['name'];
			}
		}
		return "";
	}
	
	public function select_model($db_name){
		$ret=array("0"=>"---",);
		
		$dir = opendir($_SERVER['DOCUMENT_ROOT']."/application/backend/modules_config/"); 
		@mkdir($dst); 
		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' ) && strpos($file, "php")!==false) { 
				$file=str_replace(".php","",$file);
				$ret[$file]=$file;
			} 
		} 
		return $ret;
	}
	
	public function select_method($db_method){
		return array(0=>"---");
	}
	
	public function select_position($db_method){
		return array(0=>'---')+array_combine($this->positions, $this->positions);
	}
	
	
	public function get_after_add_fields($pid){
		return $this->load->view('block_positions/get_after_edit_fields', array(
			'parametrs'=>array(),
		),true);
	}
	
	public function get_after_edit_fields($edit_id){
		return $this->load->view('block_positions/get_after_edit_fields', array(
			'parametrs'=>array(),
		),true);
	}
	
	public function get_methods($model){
		$ret=$this->empty_select();
		$model_name=$model."_model";

		if($this->model_exists($model_name)){
			$this->load->model($model_name);
			$config=$this->$model_name->config();
			if(isset($config['functions'])){
				$ret=array();
				$ret[-1]='---';
				foreach($config['functions'] as $name=>$description){
					$ret[$name]=$description['name'];
				}
			}
		}
		return $ret;
	}
	
	public function get_parametrs($model, $method, $item_id){
		$ret="";
		$model_name=$model."_model";
		
		$item=array();
		if($item_id){
			$item_one=$this->get_by_id($item_id);
			$item=json_decode($item_one['parametrs']);
		}

		if($this->model_exists($model_name)){
			$this->load->model($model_name);
			$config=$this->$model_name->config();
			if(isset($config['functions'][$method])){
				$ret=$this->load->view('block_positions/get_after_edit_fields', array(
					'parametrs'=>$config['functions'][$method]['params'],
					'item'=>$item,
				),true);
			}			
		}
		return $ret;
	}

	public function before_insert_item($post){
		$post=parent::before_insert_item($post);
		$post['parametrs']=$this->make_parametrs($post);
		return $post;
	}
	
	public function before_update_item($post){
		$post=parent::before_update_item($post);
		$post['parametrs']=$this->make_parametrs($post);
		return $post;
	}
	
	private function make_parametrs($post){
		$parametrs="";
		
		$model_name=$post['model']."_model";
		if($this->model_exists($model_name)){
			$this->load->model($model_name);
			$config=$this->$model_name->config();
			if(isset($config['functions'][$post['method']])){
				$result=array();
				foreach($config['functions'][$post['method']]['params'] as $name=>$data){
					if($data['type']=="checkbox"){
						$result[$name]=isset($post['parametrs'][$name]);
					}
					else{
						$result[$name]=trim($post['parametrs'][$name]);
					}
				}
				$parametrs=json_encode($result);
			}
		}
		return $parametrs;
	}
	
}

?>