<?
class gallerys_model extends MY_Model{
	protected $table = 'gallerys';
	protected $table_child = 'gallerys';
	protected $table_parent = 'gallerys_group';
	protected $controller= 'gallerys';
	protected $pages=20;
	protected $order_field="order";
	protected $order_type="asc";
	protected $name="Галереи";
	protected $module_id=10;

	var $fields=array(
		'name'=>array('text','Наименование',true,'show_td','text_like', '', 'Наименование'),
		'pid'=>array('select','Предок'),
		'short_text'=>array('ckeditor','Краткое описание'),
		'text'=>array('ckeditor','Полное описание'),
		
		'href'=>array('text','Ссылка'),
		
		'order'=>array('text','Порядок',false,'input_td','','','Порядок'),
		'is_show'=>array('checkbox','Показать',false,'checkbox_td','','','Показ'),
		'date'=>array('date','Дата',false,'date_td','','','Дата'),
		
		'file'=>array('file','Изображение'),
	);
	
	var $add_fields=array(
		'edit_echo',
		'delete_echo',
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
	
	public function save_to_gallery($gallery_id, $file_name){
		$new_id=$this->insert(array('pid'=>$gallery_id,));
		$this->update($new_id, array('name'=>$new_id,));
				
		$ext=substr(strrchr($file_name, '.'), 1);
		$file_path="/dir_images/gallerys_file_{$new_id}_l.".$ext;
		copy($_SERVER['DOCUMENT_ROOT']."/js/fileUpload/server/php/files/".$file_name, $_SERVER['DOCUMENT_ROOT'].$file_path);
		@unlink($_SERVER['DOCUMENT_ROOT']."/js/fileUpload/server/php/files/thumbnail/".$file_name); 
		@unlink($_SERVER['DOCUMENT_ROOT']."/js/fileUpload/server/php/files/".$file_name);
				
		$image=$this->get_by_id($new_id);
		$image['image']=$file_path;
		
		return $this->load->view('gallerys/string',array(
			'del_url'=>site_url("gallerys/delete/{$image['id']}/".base64_encode($image['image'])),
			'image'=>$image,
		),true);
	}
	
}

?>