<?
class gallerys_group_model extends MY_Model{
	protected $table = 'gallerys_group';
	protected $table_child = 'gallerys';
	protected $table_parent = 'gallerys_group';
	protected $controller= 'gallerys';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Галереи";
	protected $module_id=10;
	
	var $fields=array(
		'id'=>array('','ID','show_td','', '', 'ID'),
		'name'=>array('text','Наименование',true,'subitem_td','text_like', '', 'Наименование'),
		'pid'=>array('select','Предок'),
		'short_text'=>array('ckeditor','Краткое описание'),
		'text'=>array('ckeditor','Полное описание'),
		
		'order'=>array('text','Порядок',false,'input_td','','','Порядок'),
		'is_show'=>array('checkbox','Показать',false,'checkbox_td','','','Показ'),
		'date'=>array('date','Дата',false,'date_td','','','Дата'),
		
		'file'=>array('file','Изображение'),
		
		'url'=>array('text','URL'),
		
		'h1'=>array('text','h1'),
		'meta_title'=>array('long_text','meta-title'),
		'meta_description'=>array('long_text','meta-description'),
		'meta_keywords'=>array('long_text','meta-keywords'),
	);
	
	var $add_fields=array(
		'edit_group_echo',
		'delete_group_echo',
		'hide_id_echo'
	);

	public function submit_table($pid){
		return "Обновить";
	}
	
	protected function update_table($pid, $post){
		if(isset($post['hide_id'])&&count($post['hide_id'])){
			foreach($post['hide_id'] as $item_id=>$value){
				$update=array();
				if($this->can_rools('order')){
					$update['order']=$post['table_order'][$item_id];
				}
				$update['is_show']=isset($post['table_is_show'][$item_id]);
				if(count($update)){
					$this->update($item_id, $update);
				}
			}
		}
	}
	
	public function get_after_edit_fields($galery_id){
		$this->load->model("gallerys_model");
		if($this->get_count(array('is_block'=>0,'pid'=>$galery_id,))==0){
			$galery_pre=$this->gallerys_model->get_page(array('is_block'=>0,'pid'=>$galery_id,),null,null,"order");
			$gallery=array();
			foreach($galery_pre as $image){
				if($file_path = $this->gallerys_model->file_exists('file', $image['id'])){
					if(strpos($file_path,"jpg")!==false||strpos($file_path,"jpeg")!==false||strpos($file_path,"png")!==false||strpos($file_path,"gif")!==false){
						$image['image']=$file_path;
						$gallery[]=$image;
					}
				}
			}
			
			return $this->load->view('gallerys/gallery_list', array(
				'items'=>$gallery,
				'item_id'=>$galery_id,
				'gallery_id'=>$galery_id,
			),true);
		}
		return "";
	}
	
	public function before_update_item($post){
		$post=parent::before_update_item($post);

		if(isset($post['image'])){
			$this->load->model("gallerys_model");
			foreach($post['image'] as $image_id=>$image_name){
				$this->gallerys_model->update($image_id, array('name'=>$image_name,));
			}
			unset($post['image']);
		}
		
		return $post;
	}
	
}

?>