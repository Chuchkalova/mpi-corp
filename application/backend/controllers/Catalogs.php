<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogs extends MY_Table {
	protected $table='catalogs';
	protected $table_top='catalogs_group';
	protected $controller="catalogs";
	
	public function delete_from_group($group_id, $item_id){
		$this->load->model("catalogs_extra_group_model");
		$this->catalogs_extra_group_model->delete_where(array('group_id'=>$group_id,'item_id'=>$item_id,));
		redirect("catalogs/edit/$item_id");
	}
	
	public function delete_subitem($item_id){
		$element=$this->catalogs_model->get_by_id($item_id);
		$this->catalogs_model->delete($item_id);
		redirect("catalog/edit/{$element['item_parent']}");
	}
	
	public function edit_subitem($pid=0){
		$this->edit_abstract($pid, "edit");
	}
	
	public function add_subitem($pid=0){
		$this->add_abstract($pid, "add");
	}	
	
	public function get_add_buttons($pid=0){
		$extra='';
		if(!$this->catalogs_group_model->get_count(array('is_block'=>0,'pid'=>$pid,))){
			$extra='<a href="'.site_url('/catalogs/csv/'.$pid.'/').'" title="Выгрузить товары"><img src="/site_img/admin/csv.png"></a>';
		}
		return parent::get_add_buttons($pid).$extra;
	}
	
	public function csv($pid){
		$this->variant_model=null;
		if($this->{$this->top_model}->check_variant($pid)){
			$this->variant_model=$this->top_model;
		}
		else if($this->{$this->model}->check_variant($pid)){
			$this->variant_model=$this->model;
		}
		
		if(!$this->check_permissions('show')){
			redirect('permission/');
			return;
		}

		$this->generate_template_top();
		
		$this->template->write_view('content', 'catalogs/csv', array(
			'pid'=>$pid,
		));
		
		$this->template->render();
	}

	public function csv_do($pid){
		if($this->catalogs_group_model->load_file_abstract("file", "/dir_images/", "upload.xlsx", "*", 0, 0, "", "fixed")){
			$old_items=$this->catalogs_model->get_list(array('is_block'=>0,'pid'=>$pid,),'name','id');
			$group=$this->catalogs_group_model->get_by_id($pid);
			$types=array();
			if($group['type_id']>0){
				$this->load->model('types_group_model');
				$types_group=$this->types_group_model->get_by_fields(array('name'=>'Параметры','pid'=>$group['type_id'],));
				if(!empty($types_group)){
					$this->load->model('types_model');
					$types=$this->types_model->get_list(array('is_block'=>0,'pid'=>$types_group['id'],),'name','id');
				}
			}

			$this->load->model('catalog_types_model');
			
			$exts=array('jpg','png','jpeg','gif');
			
			include($_SERVER['DOCUMENT_ROOT']."/application/backend/third_party/SimpleXLSX.php");
			if ( $xlsx = Shuchkin\SimpleXLSX::parse($_SERVER['DOCUMENT_ROOT'].'/dir_images/upload.xlsx') ) {			
				$rows = $xlsx->rows();
				$types_translate=array();
				for($i=10;$i<count($rows[0]);++$i){
					if(isset($types[$rows[0][$i]])){
						$types_translate[$i]=$types[$rows[0][$i]];
					}
				}			
				
				for($i=1;$i<count($rows);++$i){
					if(trim($rows[$i][0])){
						$new_item=array(
							'name'=>$rows[$i][0],
							'short_text'=>$rows[$i][2],
							'text'=>$rows[$i][3],
							'price'=>(int)$rows[$i][4],
							'order'=>(int)$rows[$i][5],
							'h1'=>$rows[$i][6],
							'meta_title'=>$rows[$i][7],
							'meta_description'=>$rows[$i][8],
							'meta_keywords'=>$rows[$i][9],
						);
						foreach($new_item as $field=>$value){
							if(!trim($value)){
								unset($new_item[$field]);
							}
						}
						foreach(array('text','short_text',) as $field){
							if(isset($new_item[$field])){
								$new_item[$field]="<p>".str_replace("\n",'<br>',$new_item[$field])."</p>";
							}
						}
						
						if(isset($old_items[$new_item['name']])){
							$item_id=$old_items[$new_item['name']];
							$this->catalogs_model->update($item_id,$new_item);
						}
						else{
							$new_item['pid']=$pid;
							$new_item['url']=$this->catalogs_model->build_unique_url('', $new_item['name']);
							$item_id=$this->catalogs_model->insert($new_item);
						}
						
						$sqls=array();
						foreach($types_translate as $index=>$type_id){
							if(isset($rows[$i][$index])&&(int)trim($rows[$i][$index])==1){
								$sqls[]="($item_id, $type_id)";
							}
						}
						
						if(count($sqls)){
							$this->catalogs_model->sql_non_query('INSERT INTO `catalog_types` (`item_id`, `type_id`) VALUES '.implode(',', $sqls));
						}
						
						if(trim($rows[$i][1])){
							$filename=str_replace('https://mpi.ru.com','',$rows[$i][1]);
							if(file_exists($_SERVER['DOCUMENT_ROOT'].$filename)){
								foreach($exts as $ext){
									@unlink($_SERVER['DOCUMENT_ROOT']."/dir_images/catalogs_file1_{$item_id}_l.{$ext}");
									@unlink($_SERVER['DOCUMENT_ROOT']."/dir_images/50x50/catalogs_file1_{$item_id}_l.{$ext}");
								}
								$parts=explode('.',$filename);
								$real_ext=strtolower(end($parts));
								@copy(
									$_SERVER['DOCUMENT_ROOT'].$filename,
									$_SERVER['DOCUMENT_ROOT']."/dir_images/catalogs_file1_{$item_id}_l.{$real_ext}"
								);
							}
						}
					}
				}
			}
		}
		redirect("catalogs/show/$pid");
	}
}
?>