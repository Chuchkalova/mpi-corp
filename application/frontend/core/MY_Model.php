<?php

class  MY_Model  extends  CI_Model{	
	protected $table,$old_table;
	protected $is_region=false;
	protected $config=array();
	
	public function __construct(){
		parent::__construct();
		
		$this->old_table=$this->table;
		if($this->session->userdata('region')&&$this->is_region){
			$this->table=$this->session->userdata('region')."_".$this->table;
		}
		
		if(isset($this->module_id)&&$this->module_id){
			$this->load->model('modules_config_model');
			$config=$this->modules_config_model->get_by_fields(array('id'=>$this->module_id, 'module'=>$this->old_table,));
			if(isset($config['id'])){
				$this->config=unserialize($config['data']);
				$this->name=$this->config['name'];
			}
		}
	}
	
	public function get_search_fields(){
		return array();
	}
	public function get_search_filter_fields(){
		return array();
	}
	public function get_search_element($item){
		return null;
	}
	
	public function config(){
		return $this->config;
	}	
	
	public function load_meta($item, $parent=array(), $parent2=array()){
		$meta_title=(isset($item['meta_title']))?$item['meta_title']:"";
		$meta_description=(isset($item['meta_description']))?$item['meta_description']:"";
		$meta_keywords=(isset($item['meta_keywords']))?$item['meta_keywords']:"";
		
		if($this->model_exists('seo_templates_model')){
			$this->load->model('seo_templates_model');
			$controller=$this->uri->segment(1);
			$action=$this->uri->segment(2);
			if(!$meta_title){
				$filter=array(
					'controller'=>$controller,
					'field'=>'meta_title',
					'is_block'=>0,
				);
				$seos=$this->seo_templates_model->get_page($filter);
				$seo=array();
				foreach($seos as $seo_one){
					if($action==$seo_one['action']){
						$seo=$seo_one;
						break;
					}
					else if($seo_one['action']=='*'){
						$seo=$seo_one;
					}
				}
				if(isset($seo['value'])){
					@eval("\$meta_title = \"{$seo['value']}\";");
				}
				else{
					$meta_title=(isset($item['name']))?$item['name']:"";
				}
			}
			if(!$meta_description){
				$filter=array(
					'controller'=>$controller,
					'field'=>'meta_description',
				);
				$seos=$this->seo_templates_model->get_page($filter);
				$seo=array();
				foreach($seos as $seo_one){
					if($action==$seo_one['action']){
						$seo=$seo_one;
						break;
					}
					else if($seo_one['action']=='*'){
						$seo=$seo_one;
					}
				}
				if(isset($seo['value'])){
					eval("\$meta_description = \"{$seo['value']}\";");
				}
				else{
					$meta_description=(isset($item['name']))?$item['name']:"";
				}
			}
			if(!$meta_keywords){
				$filter=array(
					'controller'=>$controller,
					'field'=>'meta_keywords',
				);
				$seos=$this->seo_templates_model->get_page($filter);
				$seo=array();
				foreach($seos as $seo_one){
					if($action==$seo_one['action']){
						$seo=$seo_one;
						break;
					}
					else if($seo_one['action']=='*'){
						$seo=$seo_one;
					}
				}
				if(isset($seo['value'])){
					eval("\$meta_keywords = \"{$seo['value']}\";");
				}
				else{
					$meta_keywords=(isset($item['name']))?$item['name']:"";
				}
			}
		}
		else{
			if(!$meta_title){
				$meta_title=(isset($item['name']))?$item['name']:"";
			}
			if(!$meta_description){
				$meta_description=(isset($item['name']))?$item['name']:"";
			}
			if(!$meta_keywords){
				$meta_keywords=(isset($item['name']))?$item['name']:"";
			}
		}
		
		$this->template->write('meta_title', $meta_title);
		$this->template->write('meta_description', $meta_description);
		$this->template->write('meta_keywords', $meta_keywords);
	}
	
	public function sql_to_date($date){
		$date=date("d.m.Y", strtotime($date));
		return $date;
	}
	public function date_to_sql($date){
		$values=explode(" ",$date);
		$value=(isset($values[0]))?$values[0]:"";
		$value_d=explode(".",$value);
		if(count($value_d)==3){
			return $value_d[2]."-".$value_d[1]."-".$value_d[0];
		}
		return "";
	}
	public function datetime_to_sql($date){
		$values=explode(" ",$date);
		$value=(isset($values[0]))?$values[0]:"";
		$time=(isset($values[1]))?$values[1]:"00:00";
		$value_d=explode(".",$value);
		if(count($value_d)==3){
			$value_t=explode(":",$time);
			if(count($value_t)!=2){
				$value_t[0]=$value_t[1]='00';
			}
			return $value_d[2]."-".$value_d[1]."-".$value_d[0]." ".$value_t[0].":".$value_t[1];
		}
		return "";
	}
	
	public function set_cookie($name, $value, $expire=86500, $domain='', $path='/'){
		$cookie = array(
            'name'   => $name,
            'value'  => $value,
            'expire' => $expire,
            'domain' => $domain,
            'path'   => $path,
        );
		set_cookie($cookie);
	}
	
	public function get_list($where,$id_name,$value_name,$is_empty=false){
		$return=array();
		if($is_empty){
			$return=array('-1'=>'---',);
		}
		$items=$this->get_page($where,null,null,$value_name);
		foreach($items as $item){
			$return[$item[$id_name]]=$item[$value_name];
		}
		return $return;
	}
	
	public function get_pager($ref, $count_pages, $active_segment, $per_page){
		$pages="";		
		
		$page_num = $this->uri->segment($active_segment);
		if(!intval($page_num)){
			$page_num=1;
		}
		
		$num=ceil($count_pages/$per_page);
		
		if($num>1){
			$pages.="<ul>";
			
			$p=$page_num-1;
			if($page_num>1){
				$pages.="<li class='prev-page'><a href='$ref/{$p}'></a></li>";
			}
			
			if($num>7){				
				if($page_num<4){
					$plus=$page_num==1?2:1;
					for($i=1;$i<=$page_num+$plus;++$i){
						$class=($i==$page_num)?'class="active"':"";
						$pages.="<li {$class}><a href='$ref/{$i}'>$i</a></li>";
					}
					$pages.="<li><a href='#'>..</a></li>";
					$prev=$num-1;
					$pages.="<li><a href='$ref/{$prev}'>$prev</a></li>";
					$pages.="<li><a href='$ref/{$num}'>$num</a></li>";
				}
				else if($page_num>$num-3){
					$pages.="<li><a href='$ref/1'>1</a></li>";
					$pages.="<li><a href='$ref/2'>2</a></li>";
					$pages.="<li><a href='#'>..</a></li>";
					for($i=$page_num-1;$i<=$num;++$i){
						$class=($i==$page_num)?'class="active"':"";
						$pages.="<li {$class}><a href='$ref/{$i}'>$i</a></li>";
					}
				}
				else{
					$pages.="<li><a href='$ref/1'>1</a></li>";
					$pages.="<li><a href='#'>..</a></li>";
					for($i=$page_num-1;$i<=$page_num+1;++$i){
						$class=($i==$page_num)?'class="active"':"";
						$pages.="<li {$class}><a href='$ref/{$i}'>$i</a></li>";
					}
					$pages.="<li><a href='#'>..</a></li>";
					$pages.="<li><a href='$ref/{$num}'>$num</a></li>";
				}
				
			}
			else{
				for($i=1;$i<=$num;++$i){
					if($i==$page_num){
						$pages.="<li class='active'><a href='#'>$i</a></li>";
					}
					else{
						$pages.="<li><a href='$ref/{$i}' >$i</a></li>";
					}
				}
			}
			
			$p=$page_num+1;
			if($p<=$num){
				$pages.="<li class='next-page'><a href='$ref/{$p}'></a></li>";
			}
			
			$pages.="</ul>";
		}
		return $pages;
	}
	
	public function transliterate($text){ 
		$L['ru'] = array( 
                        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё',  
                        'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 
                        'Н', 'О', 'П', 'Р', 'С', 'Т', 'У',  
                        'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ы', 
                        'Ъ', 'Ь', 'Э', 'Ю', 'Я', 
                        'а', 'б', 'в', 'г', 'д', 'е', 'ё',  
                        'ж', 'з', 'и', 'й', 'к', 'л', 'м', 
                        'н', 'о', 'п', 'р', 'с', 'т', 'у',  
                        'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ы', 
                        'ъ', 'ь', 'э', 'ю', 'я', 
                    ); 

		$L['en'] = array( 
                        "A",  "B",  "V",  "G",  "D",  "E",   "YO",  
                        "ZH", "Z",  "I",  "J",  "K",  "L",   "M",  
                        "N",  "O",  "P",  "R",  "S",  "T",   "U",  
                        "F" , "X" , "CZ", "CH", "SH", "SHH", "Y",  
                        "_", "_",  "E", "YU", "YA", 
                        "a",  "b",  "v",  "g",  "d",  "e",   "yo",  
                        "zh", "z",  "i",  "j",  "k",  "l",   "m",  
                        "n",  "o",  "p",  "r",  "s",  "t",   "u",  
                        "f" , "x" , "cz", "ch", "sh", "shh", "y",  
                        "_", "_",  "e'", "yu", "ya", 
                    );
		return str_replace($L['ru'], $L['en'], $text); 
	}
	
	/*DATABASE*/
	public function get_by_id($item_id){
		$query = $this->db->get_where($this->table, array('id'=>$item_id,), 1);
		if($query->num_rows()>0){
			$row = $query->row_array(); 
			return $row;
		}
		else{
			return null;
		}
	}

	public function get_by_fields($array){
		$query = $this->db->get_where($this->table, $array, 1);
		if($query->num_rows()>0){
			$row = $query->row_array(); 
			return $row;
		}
		else{
			return null;
		}
	}

	public function get_count($where=""){
		if(is_array($where)){
			$this->db->where($where);
		}
		else{
			$this->db->where($where,null,false);
		}
		$query = $this->db->get($this->table);
		return $query->num_rows();
	}
	
	public function get_page($where, $kol=null, $start=null, $order=""){
		if($order){
			$this->db->order_by($order);
		}
		
		if(is_array($where)){
			$this->db->where($where);
		}
		else{
			$this->db->where($where,null,false);
		}
		
		if($kol!==null){
			$query = $this->db->get($this->table, $start, $kol);
		}
		else{
			$query = $this->db->get($this->table);
		}
		return $query->result_array();
	}
	
	public function sql_search($search){
		if(strlen($search)<3){
			return array();
		}
		
		$search="%{$search}%";
		$search=$this->db->escape($search);
		
		
		$fields=$this->get_search_fields();
		if(count($fields)){
			$where="is_block=0 ";
			
			$conditions=$this->get_search_filter_fields();		
			if(count($conditions)){
				foreach($conditions as $field=>$value){
					$value=$this->db->escape($value);
					$where.=" and `$field`='$value' ";
				}
			}
			
			$like="`{$fields[0]}` LIKE $search ";
			for($i=1;$i<count($fields);++$i){
				$like.=" or `{$fields[$i]}` LIKE $search ";
			}
			
			$this->db->where("(".$where.") AND ($like)");
			
			$query = $this->db->get($this->table);
			
			//echo $this->db->last_query();
			$items=$query->result_array();
			$return=array();
			foreach($items as $item_one){
				$element=$this->get_search_element($item_one);
				if($element!==null){
					$return[]=$element;
				}
			}
			return $return;
		}
		else{
			return array();
		}
	}
	
	public function sql_query_array($query){
		$query_res = $this->db->query($query);
		return $query_res->result_array();
	}
	
	public function sql_query_one($query){
		$query_res = $this->db->query($query);
		if(isset($query_res)&&$query_res->num_rows()>0){
			$row = $query_res->row_array(); 
			return $row;
		}
		else{
			return null;
		}
	}
	
	public function sql_non_query($query){
		$this->db->query($query);
	}
		
	public function insert($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function insert_or_update($data, $update){
		if($item=$this->get_by_fields($data)){
			$this->update($item['id'], $update);
			return $item['id'];
		}
		else{
			$this->db->insert($this->table, $update);
			return $this->db->insert_id();
		}
	}
	
	public function update($id, $data){
		$id = (int) $id;
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}
	
	public function update_where($where, $data){
		$this->db->where($where);
		$this->db->update($this->table, $data);
	}
	
	protected function can_del($id){
		$item=$this->get_by_fields(array('id'=>$id));
		if(isset($item['can_delete'])&&$item['can_delete']=='0'){
			return false;
		}
		else return true;
	}
	
	public function block($id){
		if($this->can_del($id)){
			$id = (int) $id;
			$this->db->where('id', $id);
			$this->db->update($this->table, array('is_block'=>1));
		}
	}
	
	public function block_where($where){
		$this->db->where($where);
		$this->db->update($this->table, array('is_block'=>1));
	}
	
	public function delete($id){
		if($this->can_del($id)){
			$id = (int) $id;
			$this->db->where('id', $id);
			$this->db->delete($this->table);
		}
	}
	
	public function delete_where($where){
		$this->db->where($where);
		$this->db->delete($this->table);
	}
	
	//FILE
	public function file_exists($db_name, $item_id){
		$meta=isset($this->meta_array[$db_name])?$this->meta_array[$db_name]:"";
		$params=explode(";", $meta);
		$types=(isset($params[3]))?$params[3]:"jpg|png|gif|jpeg";
		$to_name=(isset($params[4]))?$params[4]:"{$this->table}_{$db_name}_{$item_id}_l";
		$file_prefix=$_SERVER['DOCUMENT_ROOT']."/dir_images/$to_name";	
		
		$real_types=explode("|", $types);	
		foreach($real_types as $resolution){
			if(file_exists($file_prefix.".".$resolution)){
				return "/dir_images/$to_name".".".$resolution;
			}
		}
		return "";
	}
	
	public function load_file_abstract($from, $to_path, $to_name, $types, $resize_x, $resize_y, $resize_name, $method){
		$config['file_name']="/".$to_name;
		$config['upload_path'] = $_SERVER['DOCUMENT_ROOT']."$to_path";
		$config['allowed_types'] = $types;
		$config['max_size'] = '10000';
		$config['max_width'] = '10000';
		$config['max_height'] = '10000';
		$config['overwrite'] = true;	
		$this->load->library('upload');	
		$this->upload->initialize($config);
		if($this->upload->do_upload($from)){
			$file_data = $this->upload->data();
			$source_image = $config['upload_path'].$config['file_name'].strtolower($file_data['file_ext']);
			$new_image = $config['upload_path'].$resize_name.strtolower($file_data['file_ext']);
			if($resize_x&&$resize_y){	
				$this->resize_file($source_image, $new_image, $resize_x, $resize_y, $method);
			}
		}
		else{
			//echo $this->upload->display_errors();
			return false;
		}
		return strtolower($file_data['file_ext']);
	}
	
	public function resize_file($source_image, $new_image, $resize_x, $resize_y, $method){
		$this->load->library('image_moo');
		if($method=="resize"){
			$this->image_moo
				->load($source_image)
				->resize($resize_x,$resize_y)
				->save($new_image, true);
		}
		else if($method=="fixed"){
			$this->image_moo
				->load($source_image)
				->set_background_colour("#ffffff")
				->resize($resize_x,$resize_y, true)
				->save($new_image, true);
		} 
		else if($method=="crop"){
			$this->image_moo
				->load($source_image)
				->resize_crop($resize_x,$resize_y)
				->save($new_image, true);				
		}
		
		if($this->image_moo->errors){
			//echo $this->image_moo->display_errors();
		}
	}
	
	public function model_exists($model){
		$model=ucfirst($model);
		return file_exists(APPPATH."models/$model.php");
	}
} 
?>