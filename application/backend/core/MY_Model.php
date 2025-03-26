<?php

//класс абстрктной модели
class  MY_Model  extends  CI_Model  {	
	protected $table, $table_parent, $table_child, $fields, $controller, $old_table;
	protected $filters_array, $top_filters_array, $fields_array, $over_fields_array, $add_fields, $fields_names_array, $fields_echo_array, $tr_names_array, $meta_array, $rools_array, $required_array;
	protected $redirect, $current_id;
	protected $pages=20;
	protected $order_field="id";
	protected $order_type="desc";
	protected $name="Модуль";
	protected $module_id=0;
	protected $config=array();
	protected $is_region=false;
	protected $gallerys_group_id=0;
	protected $default_width=0;
	protected $default_height=0;
	
	public function __construct(){
		parent::__construct();
		$this->old_table=$this->table;
		if($this->session->userdata('region')&&$this->is_region){
			$this->table=$this->session->userdata('region')."_".$this->table;
		}
		if(isset($this->fields)&&count($this->fields)){
			$rools=array(
				0=>'fields_array',
				1=>'fields_names_array',
				2=>'required_array',
				3=>'fields_echo_array',
				4=>'filters_array',
				5=>'top_filters_array',
				6=>'tr_names_array',
				7=>'meta_array',
				8=>'rools_array',
			);
			foreach($this->fields as $field_name=>$field_one){
				if(isset($field_name)){
					foreach($rools as $rool_id=>$var_name){
						if(isset($field_one[$rool_id])){
							$this->set_base_array($this->$var_name, $field_name, $field_one[$rool_id]);
						}
					}
				}
			}
		}
		
		$this->over_fields_array=$this->add_fields;

		if($this->input->cookie("filter_{$this->old_table}_order")){
			$this->order_field=$this->input->cookie("filter_{$this->old_table}_order");
		}
		if($this->input->cookie("filter_{$this->old_table}_order_type")){
			$this->order_type=$this->input->cookie("filter_{$this->old_table}_order_type");
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
	
	public function config(){
		return $this->config;
	}
	
	public function is_field($field){
		return !isset($this->config['fields'][$field]['is_active'])||$this->config['fields'][$field]['is_active'];
	}
	
	protected function set_base_array(&$base_array, $field_name, $value){
		if(method_exists($this, "overload_base_array_".$field_name)){
			$this->{"overload_base_array_".$field_name}($base_array, $field_name, $value);
		}
		else{
			if($value!==''){
				$base_array[$field_name]=$value;
			}
		}
	}
	
	//установить куки
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
	
	//проверить, что отображать - лист групп или лист элементов
	public function check_variant($pid){
		if($this->get_count(array("pid"=>$pid, "is_block"=>"0"))){
			return true;
		}
		return false;
	}
	
	//проверить права доступа
	public function check_permissions($permision_name, $current_permissions=null, $extra_permissions=null, $module_name=""){
		if($this->session->userdata('super')&&$this->session->userdata('super_mode')){
			return true;
		}
		
		if($current_permissions===null){
			$this->load->model('extra_permissions_model');
			$this->load->model('modules_model');
			$module_id=0;
			
			if($module_name){
				$module_id=$this->modules_model->get_id_by_name($module_name);
				if(!$module_id){
					return false; 
				} 
			}
			$current_permissions=$this->modules_model->check_permission($this->session->userdata('admin_user_id'),$module_id);
			$extra_permissions=$this->extra_permissions_model->check_permission($this->session->userdata('admin_user_id'),$module_id);
		}
		
		if(method_exists($this, "overload_permission_".$permision_name)){
			return $this->{"overload_permission_".$permision_name}($current_permissions, $extra_permissions);
		}
		else{
			if(isset($this->config['rools'][$permision_name])&&!$this->config['rools'][$permision_name]){
				return false;
			}
		
			if(isset($current_permissions[$permision_name])&&$current_permissions[$permision_name]!=0) return true;
			if(isset($extra_permissions[$permision_name])&&$extra_permissions[$permision_name]!=0) return true;
			return false; 
		}
	}
	
	public function check_filtres_post($pid, $post){
		if(isset($post['set_filter'])){
			$this->set_filters($pid, $post);
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		}
		else if(isset($post['top_filter'])){
			$this->top_filters($pid, $post);
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		}
		else if(isset($post['reset'])){
			$this->reset_filters($pid, $post);
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		}
		else if(isset($post['update'])){
			$this->update_table($pid, $post);
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		}
	}
	
	public function set_one_filter($pid, $field_name, $value){
		$array=array();
		$this->reset_filters(0, $array);
		$this->set_cookie("filter_{$this->old_table}_{$field_name}", $value);
		redirect("{$this->controller}/show/$pid");
	}
	
	public function clear_filters(){
		$array=array();
		$this->reset_filters(0, $array);
	}
	
	protected function update_table($pid, $post){
	}
	
	protected function set_filters_abstract($pid, &$post, &$filters_array){
		foreach($filters_array as $name=>$type){
			if(strpos($type,'interval')!==false){
				if(isset($post["filter_".$name."_from"])){
					$this->set_cookie("filter_{$this->old_table}_{$name}_from", $post["filter_".$name."_from"]);
				}
				if(isset($post["filter_".$name."_to"])){
					$this->set_cookie("filter_{$this->old_table}_{$name}_to", $post["filter_".$name."_to"]);
				}
			}
			else if(isset($post["filter_".$name])){
				$this->set_cookie("filter_{$this->old_table}_{$name}", $post["filter_".$name]);
			}
		}
	}
	
	protected function set_filters($pid, &$post){
		$this->set_filters_abstract($pid, $post, $this->filters_array);
	}
	
	protected function top_filters($pid, &$post){
		$this->set_filters_abstract($pid, $post, $this->top_filters_array);
	}
	
	protected function reset_filters($pid, &$post){
		foreach(array($this->filters_array, $this->top_filters_array) as $filters_array){
			if(count($filters_array)){
				foreach($filters_array as $name=>$type){
					if(strpos($type,'interval')!==false){
						delete_cookie("filter_{$this->old_table}_{$name}_from");
						delete_cookie("filter_{$this->old_table}_{$name}_to");
					}
					delete_cookie("filter_{$this->old_table}_{$name}");
				}
			}
		}
		delete_cookie("filter_{$this->old_table}_order");
		delete_cookie("filter_{$this->old_table}_order_type");
	}
	
	public function get_show_conditions($pid){
		return "`{$this->table}`.pid='$pid' and `{$this->table}`.is_block='0'";
	}
	
	public function get_show_filters_conditions($pid){
		$condition="";
		foreach(array($this->filters_array, $this->top_filters_array) as $filters_array){
			if(is_array($filters_array)&&count($filters_array)){
				foreach($filters_array as $name=>$type){
					$value=$this->input->cookie("filter_{$this->old_table}_{$name}");
					$value_from=$this->input->cookie("filter_{$this->old_table}_{$name}_from");
					$value_to=$this->input->cookie("filter_{$this->old_table}_{$name}_to");

					if($value||$value_to||$value_from){
						switch($type){
							case 'text_like':
								if($value!==""){
									$value=$this->db->escape("%{$value}%");
									$condition.=" and `$name` like $value ";
								}
								break;
							case 'text_equal':
								if($value!==""){
									$value=$this->db->escape($value);
									$condition.=" and `$name` like $value ";
								}
								break;
							case 'select':
								$condition.=" and `$name` = '{$value}' ";
								break;
							case 'date':
								if($this->date_to_sql($value)){
									$condition.=" and `$name` BETWEEN '{$val} 00.00.00' AND '{$val} 23.59.59' ";
								}
								break;
							case 'date_interval':
								if($this->date_to_sql($value_from)){
									$date_from=$this->date_to_sql($value_from);
									$condition.=" and `$name` >= '{$date_from} 00.00.00' ";
								}
								if($this->date_to_sql($value_to)){
									$date_to=$this->date_to_sql($value_to);
									$condition.=" and `$name` <= '{$date_to} 23.59.59' ";
								}
								break;
						}
					}
				}
			}
		}
		
		$condition.=$this->extra_filters_conditions($pid);
		return $condition;
	}
	
	protected function extra_filters_conditions($pid){
		return "";
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
	
	public function sql_to_date($date){
		$date=date("d.m.Y", strtotime($date));
		return $date;
	}
	
	protected function check_over_fields(&$current_permissions, &$extra_permissions){
		$real_fields=array();
		if(count($this->over_fields_array)){
			foreach($this->over_fields_array as $over_field){
				$over_field_check=$over_field;
				switch($over_field){
					case 'edit_group_echo':
						$over_field_check='edit';
					break;
					case 'edit_echo':
						$over_field_check='edit';
					break;
					case 'delete_group_echo':
						$over_field_check='delete';
					break;
					case 'delete_echo':
						$over_field_check='delete';
					break;
					case 'hide_id_echo':
						$over_field_check='show';
					break;
				}
				if($this->check_permissions($over_field_check, $current_permissions, $extra_permissions)){
					$real_fields[]=$over_field;
				}
			}
		}
		return $real_fields;
	}
	
	public function get_th_array(){
		$td=array();
		if(count($this->tr_names_array)){
			foreach($this->tr_names_array as $db_name=>$th_name){
				if($this->can_rools($db_name)){
					$td[]=$th_name;
				}
			}
		}
		if(count($this->over_fields_array)){
			$td[]='Действия';
		}
		return $td;
	}
	
	protected function get_show_list($condition, $start, $kol){
		$items=$this->get_page($condition, $start, $kol, $this->order_field." ".$this->order_type);
		//echo $this->db->last_query();
		return $items;		
	}
	
	public function get_count_table($condition){
		return $this->get_count($condition);
	}
	
	public function generate_table($pid, $condition, $page_num, &$current_permissions, &$extra_permissions){
		$this->over_fields_array=$this->check_over_fields($current_permissions, $extra_permissions);
		
		$start=($page_num-1)*$this->pages;
		$kol=$this->pages;		
		$trs=array();
		
		$items=$this->get_show_list($condition, $start, $kol);
		foreach($items as $item){
			$tds=array();
			foreach($this->fields_echo_array as $db_name=>$function_name){
				if(!isset($item[$db_name])) $item[$db_name]='';
				if(!isset($item['id'])) $item['id']=0;
								
				$echo_this=(method_exists($this, $function_name))?$function_name:"show_td";

				if($this->can_rools($db_name, $extra_permissions)){
					$tds[]=$this->$function_name($item[$db_name], $item['id'], $db_name);
				}
			} 
			
			if(count($this->over_fields_array)){
				$over_string="";
				foreach($this->over_fields_array as $over_field_function){
					if(method_exists($this, $over_field_function)){					
						$over_string.=$this->$over_field_function($item, $item['id']);
					}
				}
				$tds[]="<td align='center'>$over_string</td>";
			}
			else{
				$tds[]="";
			}
			
			$trs[]=$tds;
		}
		
		return $trs;
	}
	
	public function sort_table_tr($pid){
		$new_order=($this->order_type=="asc")?"desc":"asc";
		$td=array();
		if(count($this->tr_names_array)){
			foreach($this->tr_names_array as $db_name=>$th_name){
				if(!$this->can_rools($db_name)){
					continue;
				}
				$img=($this->order_field==$db_name)?$new_order:"null";
				$td[]=array($db_name,$img,$new_order,);
			}
		}
		return $td;
	}
	
	public function filter_table_tr($pid){
		$td=array();
		if(count($this->tr_names_array)){
			foreach($this->tr_names_array as $db_name=>$th_name){
				if(!$this->can_rools($db_name)){
					continue;
				}
				if(!isset($this->filters_array[$db_name])){
					$td[]="";
					continue;
				}
				$inner_th="";
				$value=$this->input->cookie("filter_{$this->old_table}_{$db_name}");
				$value_from=$this->input->cookie("filter_{$this->old_table}_{$db_name}_from");
				$value_to=$this->input->cookie("filter_{$this->old_table}_{$db_name}_to");
				switch($this->filters_array[$db_name]){
					case('text_equal'):case('text_like'):
						$inner_th=form_input(array(
							'name'       => "filter_".$db_name,
							'id'         => "filter_".$db_name,
							'value' 	 => $value,
							'class'		 => "form-control",
						));
						break;
					case('date'):
						$values=explode(" ",$value);
						if(isset($values[0])) $value=$values[0];
						$inner_th=form_input(array(
							'name'        => "filter_".$db_name,
							'id'          => "filter_".$db_name,
							'value' 	  => $value,
							'style'		  => 'width:80px;',
							'class'		  => "form-control date-pick",
						));
						break;
					case('date_interval'):
						if(is_null($value)){
							$value="";
						}
						$values=explode(" ",$value);
						if(isset($values[0])) $value=$values[0];
						$inner_th=form_input(array(
							'name'        => "filter_".$db_name."_from",
							'id'          => "filter_".$db_name."_from",
							'maxlength'   => '100',
							'class'		 => 'date-pick form-control',
							'value' 	 => $value_from,
							'style'		=> 'width:100%;',
						));
						$inner_th.=form_input(array(
							'name'        => "filter_".$db_name."_to",
							'id'          => "filter_".$db_name."_to",
							'maxlength'   => '100',
							'class'		 => 'date-pick form-control',
							'value' 	 => $value_to,
							'style'		=> 'width:100%;',
						));
						break;
					case('select'):		
						$items=$this->return_select_values($db_name);
						$inner_th=form_dropdown("filter_".$db_name, $items, $value, "id='filter_{$db_name}' class='form-control'");
						break;
					case('own'):
						if(method_exists($this, "own_filter_".$db_name)){
							$inner_th=$this->{"own_filter_".$db_name}($value);
						}
						break;
				}
				if($inner_th){
					$td[]=$inner_th;
				}
			}
		}
		return $td;
	}
	
	protected function return_select_values($db_name, $skip_filtres=false){
		
		$function="";
		if(!$skip_filtres&&method_exists($this, "select_filter_".$db_name)){
			$function="select_filter_".$db_name;
		}
		else if(method_exists($this, "select_".$db_name)){
			$function="select_".$db_name;
		}
		else if(isset($this->meta_array[$db_name])){
			$function="meta_select_values";
		}
		else $function="empty_select";
		
		return $this->$function($db_name);
	}
	
	protected function meta_select_values($db_name){
		$params=explode(";",$this->meta_array[$db_name]);
		if(count($params)==3&&$this->model_exists($params[0])){
			$this->load->model($params[0]);
			return $this->{$params[0]}->get_list(array('is_block'=>0,),$params[1],$params[2],true);
		}
		return $this->empty_select($db_name);
	}
	
	public function empty_select($db_name=''){
		return array('-1'=>'---',);
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
	
	public function get_top_filters($pid){
		$filtres=array();
		if(is_array($this->top_filters_array)&&count($this->top_filters_array)){
			foreach($this->top_filters_array as $db_name=>$type){
				if(isset($this->fields_names_array[$db_name])){
					$value=$this->input->cookie("filter_{$this->old_table}_{$db_name}");
					$value_from=$this->input->cookie("filter_{$this->old_table}_{$db_name}_from");
					$value_to=$this->input->cookie("filter_{$this->old_table}_{$db_name}_to");
					
					$content="";
					switch($type){
						case('text_like'):case('text_equal'):
							$content=form_input(array(
								'name'        => "filter_".$db_name,
								'id'          => "filter_".$db_name,
								'class'		 => "form-control",
								'value' 		 => $value
							));
							break;
						case('date'):
							$values=explode(" ",$value);
							if(isset($values[0])) $value=$values[0];
							$content=form_input(array(
								'name'        => "filter_".$db_name,
								'id'          => "filter_".$db_name,
								'class'		  => "form-control date-pick",
								'value' 	  => $value,
								'style' 	  => 'width:150px;'
							));
							break;
						case('select'):		
							$items=$this->return_select_values($db_name);
							$content=form_dropdown("filter_".$db_name, $iems, $value, "id='filter_{$db_name}' class='form-control'");
							break;
						case('own'):
							if(method_exists($this, "own_filter_".$db_name)){
								$content=$this->{"own_filter_".$db_name}($value);
							}
							break;
					}
					if($content){
						$filtres[$this->fields_names_array[$db_name]]=$content;
					}
				}
			}
		}
		return $filtres;
	}
	
	public function get_ref($pid){
		if($this->old_table==$this->table_child&&$this->old_table!=$this->table_parent&&$this->uri->segment(2)!='add'&&$this->uri->segment(2)!='show'){
			$tmp_category=$this->get_by_fields(array('id'=>$pid,));
			$now_category=isset($tmp_category['pid'])?$tmp_category['pid']:0;
			$model=$this->table_parent."_model";
		}
		else{
			$now_category=$pid;
			$model=$this->table_parent."_model";
		}
		$max_depth=10;
		$refs=array();
		if($this->table_child!=$this->table_parent){
			while($now_category&&$max_depth){
				--$max_depth;
				$category_this=$this->$model->get_by_fields(array('id'=>$now_category,));
				if(!isset($category_this['pid'])) return "";
				$refs[site_url("{$this->controller}/show/{$category_this['id']}/")]=isset($category_this['name'])?$category_this['name']:$category_this['id'];
				$now_category=$category_this['pid'];
			}
		}
		$refs[site_url("{$this->controller}/")]=$this->name;
		return array_reverse($refs);
	}
	
	public function get_pager($url, $count_pages, $active_segment){
		$this->load->library('pagination');
		$config['base_url'] = $url;
		$config['total_rows'] = $count_pages;
		$config['per_page'] = $this->pages; 
		$config['uri_segment'] = $active_segment;
		$config['last_link'] = "В конец";
		$config['first_link'] = "В начало";
		$config['num_links'] = 5;
		$config['use_page_numbers'] = true;
		
		$this->pagination->initialize($config); 

		return $this->pagination->create_links();
	}
	
	public function get_title($action, $item=array()){
		$name=$this->name." ".$action;
		if(isset($item['name'])){
			$name.=" - ".$item['name'];
		}
		return $name;
	}
	
	public function prepare_fields_array($fields_array, $item_id, $is_insert){
		return $fields_array;
	}
	
	protected function get_abstract_fields($item_id, $is_insert=false){
		$fields=array();
		if(!$is_insert){
			$item=$this->get_by_fields(array('id'=>$item_id,));
		}
		
		$this->load->model('extra_permissions_model');
		$extra_permissions=array();
		if($this->module_id){
			$extra_permissions=$this->extra_permissions_model->check_permission($this->session->userdata('admin_user_id'), $this->module_id);
			$extra_permissions=array_merge($extra_permissions, $this->extra_permissions_model->check_permission($this->session->userdata('admin_user_id'), 20));
		}
		
		$fields_array=$this->prepare_fields_array($this->fields_array,$item_id, $is_insert);
		
		foreach($fields_array as $db_name=>$type){
			$rus_name=(isset($this->fields_names_array[$db_name]))?$this->fields_names_array[$db_name]:"";
			$value=(isset($item[$db_name]))?$item[$db_name]:"";
			$content="";
			$gallerys_count=0;
			switch($type){
				case('long_text'):case('text'):
					$init=array(
						'name'        => $db_name,
						'id'          => "field_".$db_name,
						'class'		  => "form-control",
						'value'		  => $value,
					);
					if(isset($this->required_array[$db_name])&&$this->required_array[$db_name]){
						$init['required']='required';
					}
					$content=form_input($init);	
					break;
				case('date'):
					if($value){
						$value=$this->sql_to_date($value);
					}
					$content=form_input(array(
						'name'        => $db_name,
						'id'          => "field_".$db_name,
						'class'		  => 'date-pick form-control',
						'style' 	  => 'width:150px;',
						'value'		  => $value,
					));
					break;
				case('select'):	
					if($is_insert&&$db_name=='pid'){
						$value=$item_id;
					}
					else{
						$this->current_id=$item_id;
					}
					$items=$this->return_select_values($db_name, true);
					$content=form_dropdown($db_name, $items, $value, "id='field_{$db_name}' class='form-control' ");
					break;
				case('own'):
					if(method_exists($this, "own_input_".$db_name)){
						$content=$this->{"own_input_".$db_name}($value);
					}
					break;
				case('hidden'):
					if($is_insert&&$db_name=='pid'){
						$value=$item_id;
					}
					$content=form_hidden($db_name, $value);
					break;
				case('color'):
					$content=form_input(array(
						'name'        => $db_name,
						'id'          => "field_".$db_name,
						'type'		  => 'color',
						'style' 	  => 'width:150px;',
						'value'		  => $value,
					));
					break;
				case('password'):
					$content=form_password(array(
						'name'        => $db_name,
						'id'          => $db_name,
						'maxlength'   => '100',
						'class'		  => "form-control pull-left",
						'style'		  => 'width:150px',
					));
					
					$content.=form_password(array(
						'id'          => $db_name."2",
						'maxlength'   => '100',
						'class'		  => "form-control pull-left",
						'style'		  => 'width:150px',
						'placeholder' => "Повторно",
					));
					break;
				case('checkbox'):
					$value=($value)?true:false;
					$content=form_checkbox($db_name,'', $value);
					break;
				case('ckeditor'):
					$content=form_textarea(array(
						   'name'        => $db_name,
						   'id'          => $db_name,
						   'value'		 => $value,
					));
					$content.="<script type='text/javascript'>
							var editor = CKEDITOR.replace( '$db_name' );
							CKEDITOR.timestamp='ABCD';
							CKFinder.setupCKEditor( editor, '/js/ckfinder/' ) ;
						</script>";
					break;
				case('textarea'):
					$content=form_textarea(array(
						'name'        => $db_name,
						'id'          => $db_name,
						'value' 	  => $value,
					));
					break;
				case('file'):
					if(isset($item['id'])&&$file_path = $this->file_exists($db_name, $item['id'])){
						if(strpos($file_path,"jpg")!==false||strpos($file_path,"jpeg")!==false||strpos($file_path,"png")!==false||strpos($file_path,"gif")!==false||strpos($file_path,"svg")!==false){
							$del_url=site_url("{$this->controller}/delete_file/{$item['id']}/".base64_encode($file_path));
							$content="<img width='100' src='$file_path'> <a href='$del_url'>Удалить</a>";
						}
						else{
							$del_url=site_url("{$this->controller}/delete_file/{$item['id']}/".base64_encode($file_path));
							$content="<a href='$file_path' target='_blank'>Посмотреть</a> <a href='$del_url'>Удалить</a>";
						}
					}
					else{
						$content=form_upload(array(
							'name'        => $db_name,
							'id'          => $db_name,
							'maxlength'   => '100'
						));
					}
					break;
				case('file_editor'):
					if(isset($item['id'])&&$file_path = $this->file_exists($db_name, $item['id'])){
						$del_url=site_url("{$this->controller}/delete_file/{$item['id']}/".base64_encode($file_path));
						$file=$file_path;
					}
					else{
						$del_url="";
						$file=form_upload(array(
							'name'        => $db_name,
							'id'          => $db_name,
							'maxlength'   => '100'
						));
					}
					
					if(!empty($item)){
						$content=$this->load->view('gallerys/file_one', array(
							'item'=>$item,
							'module'=>$this->controller,
							'filename'=>$db_name,
							'file'=>$file,
							'del_url'=>$del_url,
							'name'=>'',
							'width'=>$this->get_default_width($item['id'],$db_name),
							'height'=>$this->get_default_height($item['id'],$db_name),
						),true);
					}
					else{
						$content='<div class="pt5">Сначала сохраните страницу</div>';
					}
					
					break;
				case 'gallery':
					if(!$is_insert&&$this->model_exists("gallerys_model")&&$this->is_field($db_name)){
						$this->load->model("gallerys_model");
						if(!$value){
							$gallery_name=$item['name'];
							if($gallerys_count>0) $gallery_name.=" ($gallerys_count)";
							$this->load->model("gallerys_group_model");
							$value=$this->gallerys_group_model->insert(array('name'=>$gallery_name,'pid'=>$this->gallerys_group_id,));
							$this->update($item['id'],array($db_name=>$value,));
							++$gallerys_count;
						}
						$galery_items=$this->gallerys_model->get_page(array('is_block'=>0,'pid'=>$value,),null,null,"order");
						
						$items=array();
						foreach($galery_items as $image){
							$is_file=false;
							if($file_path = $this->gallerys_model->file_exists('file', $image['id'])){
								if(strpos($file_path,"jpg")!==false||strpos($file_path,"jpeg")!==false||strpos($file_path,"png")!==false||strpos($file_path,"gif")!==false||strpos($file_path,"svg")!==false){
									$image['image']=$file_path;
									$items[]=$image;
									$is_file=true;
								}
							}
							if(!$is_file){
								$this->gallerys_model->delete($image['id']);
							}								
						}
						
						$content=$this->load->view('gallerys/gallery_list', array(
							'items'=>$items,
							'width'=>$this->get_default_width($item['id'],$db_name),
							'height'=>$this->get_default_height($item['id'],$db_name),
							'item_id'=>$item['id'],
							'gallery_id'=>$value,
						),true);
					}
					break;
			}
			
			if($this->can_rools($db_name, $extra_permissions)){
				$fields[$rus_name]=$content;
			}
		}
		return $fields;
	}
	
	protected function get_default_width($item_id, $db_name){
		return $this->default_width;
	}
	
	protected function get_default_height($item_id, $db_name){
		return $this->default_height;
	}	

	protected function can_rools($db_name, $extra_permissions=array()){
		if($this->session->userdata('super')&&$this->session->userdata('super_mode')){
			return true;
		}

		if(!isset($this->config['fields'][$db_name])||$this->config['fields'][$db_name]['is_active']){
			return true;
		}
		return false;
	}
	
	public function get_add_fields($pid){
		return $this->get_abstract_fields($pid,true);
	}
	
	public function get_edit_fields($pid){
		return $this->get_abstract_fields($pid,false);
	}
	
	public function get_after_add_fields_regions(){
		if($this->is_region){
			return $this->load->view("common/regions", array(
				'regions'=>$this->regions,
			),true);;
		}
		return "";
	}
	public function get_after_edit_fields_regions(){
		if($this->is_region){
			return $this->load->view("common/regions", array(
				'regions'=>$this->regions,
			),true);;
		}
		return "";
	}
	
	public function get_after_add_fields($pid){
		return $this->get_after_add_fields_regions()."";
	}
	
	public function get_after_edit_fields($pid){
		return $this->get_after_edit_fields_regions()."";
	}
	
	public function select_pid($db_name){
		$ret=array("0"=>"Корень",);
		$this->{$this->table_parent."_model"}->select_pid_recoursive(0, "&nbsp;&nbsp;", $ret);
		return $ret;
	}
	
	protected function select_pid_recoursive($root, $prefix, &$ret){
		if($this->current_id!==$root){
			$items=$this->get_page(array("pid"=>$root, "is_block"=>0,),null,null,$this->order_field);
			
			$item=$this->get_by_fields(array('id'=>$root,"is_block"=>0,));
			if(isset($item['id'])){
				$ret[$item['id']]=$prefix.$item['name'];
			}
			
			if(count($items)){
				foreach($items as $item){
					$this->select_pid_recoursive($item['id'], "&nbsp;&nbsp;".$prefix, $ret);
				}			
			}
		}

		return $ret;
	}

	protected function prepare_fields_common($post){
		if(count($this->fields_array)){
			foreach($this->fields_array as $db_name=>$type){
				switch($db_name){
					case 'url':
						if(!isset($post['url'])){
							$post['url']="";
						}
						$name=isset($post['name'])?$post['name']:$this->old_table;
						$post['url']=$this->build_unique_url($post['url'], $name);
					break;
					case 'meta_title':case 'meta_description':case 'meta_keywords':
						if(!isset($post[$db_name])) $post[$db_name]="";
						if(!trim($post[$db_name])){
							$name=isset($post['name'])?$post['name']:$this->old_table;
							$post[$db_name]=$this->prepare_meta_tags($name);
						}
					break;	
					case 'pid':
						if(isset($this->current_id)&&$this->current_id){
							if($this->table_child==$this->old_table&&$this->old_table!=$this->table_parent){
								$item_old=$this->get_by_id($this->current_id);
								if($item_old['pid']!=$post[$db_name]){
									if($this->{$this->table_parent."_model"}->get_count(array('is_block'=>0,'pid'=>$post[$db_name],))){
										$post[$db_name]=$item_old['pid'];
									}
								}
							}
						}
					break;
				}
				switch($type){
					case 'checkbox':
						$post[$db_name]=isset($post[$db_name])?1:0;
						if(!$this->can_rools('is_show')&&$db_name=='is_show'){
							$post[$db_name]=1;
						}
					break;
					case 'date':
						if(isset($post[$db_name])){
							$post[$db_name]=$this->date_to_sql($post[$db_name]);
							if(!$post[$db_name]) $post[$db_name]=date("Y-m-d");
						}
					break;
					case 'datetime':
						if(isset($post[$db_name])){
							$post[$db_name]=datetime_to_sql($post[$db_name]);
							if(!$post[$db_name]) $post[$db_name]=date("Y-m-d H:i");
						}
					break;
				}
			}
		}
		return $post;
	}
	
	public function before_insert_item($post){
		$this->redirect=(isset($post['submit']))?"submit":"save";
		unset($post[$this->redirect]);
		$post=$this->prepare_fields_common($post);
		return $post;
	}
	
	public function before_update_item($post){
		if(isset($post['item_id'])){
			$this->current_id=$post['item_id'];
			unset($post['item_id']);
		}
		if(isset($post['image'])&&$this->model_exists('gallerys_model')){
			$this->load->model("gallerys_model");
			foreach($post['image'] as $image_id=>$image_name){
				$this->gallerys_model->update($image_id, array(
					'name'=>$image_name,
					'href'=>isset($post['hrefs'][$image_id])?$post['hrefs'][$image_id]:"",
				));
			}
			unset($post['image']);
			unset($post['hrefs']);				
		}
		
		$this->redirect=(isset($post['submit']))?"submit":"save";
		unset($post[$this->redirect]);
		$post=$this->prepare_fields_common($post);
		return $post;
	}
	
	public function insert_item($post){
		$this->current_id=$this->insert($post);
	}
	
	public function update_item($post){
		$this->update($this->current_id, $post);
	}
	
	protected function after_action_common(){
		foreach($this->fields_array as $db_name=>$type){
			switch($type){
				case 'file':case 'file_editor':
					$meta=isset($this->meta_array[$db_name])?$this->meta_array[$db_name]:"";
					$this->load_file($db_name, $meta);
				break;
			}
		}
	}
	
	public function after_insert_item(){
		$this->after_action_common();
	}
	
	public function after_update_item(){
		$this->after_action_common();	
	}
	
	protected function after_action_redirect($post){
		if($this->redirect=="save"){
			if($this->old_table==$this->table_parent&&$this->old_table!=$this->table_child){
				redirect($this->controller."/edit_group/".$this->current_id);
			}
			else{
				redirect($this->controller."/edit/".$this->current_id);
			}
		}
		else{
			$pid=isset($post['pid'])?intval($post['pid']):0;
			redirect($this->controller."/show/".$pid);
		}
	}
	
	public function after_insert_redirect($post){
		$this->after_action_redirect($post);	
	}
	
	public function after_update_redirect($post){
		$this->after_action_redirect($post);	
	}
	
	public function build_unique_url($url, $name){
		if(!$url){
			$prepared_field=$this->transliterate($name);
		}
		else $prepared_field=$url;
		
		$prepared_field=$this->escape_url($prepared_field);
		
		$current_id=(isset($this->current_id))?$this->current_id:0;
		
		$i="";
		do{
			$count=$this->get_count(array("url"=>$prepared_field.$i, "id !=" =>$current_id));
			if(!$i) $i=1;
			else ++$i;
		}
		while($count!=0);
		
		if($i>1){
			$prepared_field.=$i-1;
		}
		return $prepared_field;
	}
	
	public function transliterate($text){ 
		$translit = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'j',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'x',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
            'ь' => "",  'ы' => 'y',   'ъ' => "",
            'э' => "e",   'ю' => 'yu',  'я' => 'ya',
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'J',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
            'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
            'Ь' => "",  'Ы' => "Y",   'Ъ' => "",
            'Э' => "E",   'Ю' => 'YU',  'Я' => 'YA',
			' '=>'_'
        );
		
		$prepared_field = strtolower(strtr($text, $translit));
		
		return $prepared_field;
	}
	
	public function escape_url($url){ 
		$prepared_field=preg_replace('/[^\da-zA-Z\-\_]/i', "",$url);
		return str_replace(" ","_",$prepared_field);
	}
	
	protected function prepare_meta_tags($name){
		return "";
	}
	
	public function submit_table($pid){
		return "";
	}
	
	public function block_recoursive($group_id){
		$this->block($group_id);
		$subitems=$this->get_page(array('pid' => $group_id,));
		if(count($subitems)){
			foreach($subitems as $subitem){
				$this->block_recoursive($subitem['id']);
				$this->block($subitem['id']);
			}
		}
		else{
			$this->{$this->table_child."_model"}->block_where(array('pid' => $group_id,));
		}
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
	
	function get_page($where, $kol=null, $start=null, $order=""){
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
		if($this->is_region){
			$renew_regions=isset($data['regions'])?$data['regions']:array();
			unset($data['regions']);
			
			$base_table=$this->table;
			if($this->session->userdata('region')){
				$base_table=str_replace($this->session->userdata('region')."_","",$this->table);
			}
			
			foreach($this->regions as $prefix=>$name){
				$table=($prefix)?$prefix."_".$base_table:$base_table;
				$prefix_index=($prefix=="")?0:$prefix;
				$insert_data=$data;
				$insert_data['is_block']=(isset($renew_regions[$prefix_index])||$this->session->userdata('region')==$prefix)?0:1;
				$insert_data['region_rewrite']=(isset($renew_regions[$prefix_index]))?1:0;
				if($this->session->userdata('region')==$prefix){
					$insert_data['region_rewrite']=$data['region_rewrite'];
				}
				$this->db->insert($table, $insert_data);
				$this->db->flush_cache();
			}
		}
		else{
			$this->db->insert($this->table, $data);
		}
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
		if($this->is_region){
			$renew_regions=isset($data['regions'])?$data['regions']:array();
			unset($data['regions']);
			
			$base_table=$this->table;
			if($this->session->userdata('region')){
				$base_table=str_replace($this->session->userdata('region')."_","",$this->table);
			}
			
			foreach($this->regions as $prefix=>$name){
				$table=($prefix)?$prefix."_".$base_table:$base_table;
				$prefix_index=($prefix=="")?0:$prefix;
				$update_data=$data;
				$query = $this->db->get_where($table, array('id'=>$id,), 1);
				if($query->num_rows()>0){
					$row = $query->row_array();
					if($this->session->userdata('region')==$prefix||($row['region_rewrite']&&isset($renew_regions[$prefix_index]))){
						$update_data['is_block']=0;
						$this->db->where('id', $id);
						$this->db->update($table, $update_data);
						$this->db->flush_cache();
					}
				}
			}
		}
		else{
			$this->db->where('id', $id);
			$this->db->update($this->table, $data);
		}
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
			if($this->is_region){
				$base_table=$this->table;
				if($this->session->userdata('region')){
					$base_table=str_replace($this->session->userdata('region')."_","",$this->table);
				}
			
				foreach($this->regions as $prefix=>$name){
					$table=($prefix)?$prefix."_".$base_table:$base_table;
					
					$this->db->where('id', $id);
					$this->db->update($table, array('is_block'=>1,));
					$this->db->flush_cache();
				}
			}
			else{
				$this->db->where('id', $id);
				$this->db->update($this->table, array('is_block'=>1,));
			}
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
	
	//TD ECHO
	public function edit_td($value, $item_id){
		$url=site_url("{$this->controller}/edit/{$item_id}/");
		return "<a href='$url'>$value</a>";
	}
	
	public function subitem_td($value, $item_id){
		$url=site_url("{$this->controller}/show/{$item_id}/");
		return "<a href='$url'>$value</a>";
	}
	
	public function show_td($value, $item_id, $db_field){
		return $value;
	}
	
	public function decimal_td($value, $item_id, $db_field){
		if(!$value) $value=0;
		return number_format($value, 2, '.', "");
	}
	
	public function date_td($value, $item_id, $db_field){
		$date=date("d.m.Y", strtotime($value));
		return $date;
	}

	public function datetime_td($value, $item_id, $db_field){
		$date=date("d.m.Y H:i", strtotime($value));
		return $date;
	}
	
	public function yesno_td($value, $item_id, $db_field){
		return ($value)?"Да":"Нет";
	}
	
	public function input_td($value, $item_id, $db_field){
		return "<td align='center'>".form_input(array(
							'name'  => "table_{$db_field}[$item_id]",
							'value' => $value,
							'style' => "width:100px;",
							'class' => 'form-control'
						))."</td>";
	}
	
	public function checkbox_td($value, $item_id, $db_field){
		$value=($value)?true:false;
		return "<td align='center'>".form_checkbox("table_{$db_field}[$item_id]",'', $value)."</td>";
	}
	
	//EXTRA TD
	public function delete_echo($item){
		if(!isset($item['can_delete'])||$item['can_delete']==1){
			$url=site_url("{$this->controller}/delete/{$item['id']}/");
			return "<a href='$url' class='confirm' title='Удалить'><img src='/site_img/admin/delete.png'></a>&nbsp;";
		}
		else return "&nbsp;";
	}

	public function delete_group_echo($item){
		if(!isset($item['can_delete'])||$item['can_delete']==1){
			$url=site_url("{$this->controller}/delete_group/{$item['id']}/");
			return "<a href='$url' class='confirm' title='Удалить'><img src='/site_img/admin/delete.png'></a>&nbsp;";
		}
		else return "&nbsp;";
	}
	
	public function edit_group_echo($item){
		$url=site_url("{$this->controller}/edit_group/{$item['id']}/");
		return "<a href='$url' title='Редактировать'><img src='/site_img/admin/edit.png'></a>&nbsp;";
	}
	
	public function edit_echo($item){
		$url=site_url("{$this->controller}/edit/{$item['id']}/");
		return "<a href='$url' title='Редактировать'><img src='/site_img/admin/edit.png'></a>&nbsp;";
	}
	
	public function hide_id_echo($item){
		return form_hidden("hide_id[{$item['id']}]", $item['id']);
	}
	
	//FILE
	protected function file_exists($db_name, $item_id){
		$meta=isset($this->meta_array[$db_name])?$this->meta_array[$db_name]:"";
		$params=explode(";", $meta);
		$types=(isset($params[3]))?$params[3]:"jpg|png|gif|jpeg|svg";
		$to_name=(isset($params[4]))?$params[4]:"{$this->old_table}_{$db_name}_{$item_id}_l";
		$file_prefix=$_SERVER['DOCUMENT_ROOT']."/dir_images/$to_name";	

		$real_types=explode("|", $types);	
		foreach($real_types as $resolution){
			if(file_exists($file_prefix.".".$resolution)){
				return "/dir_images/$to_name".".".$resolution;
			}
		}
		return "";
	}
	
	protected function load_file($from, $meta){
		$to_path="/dir_images/";
		$params=explode(";", $meta);
		$resize_x=(isset($params[0])&&$params[0])?intval($params[0]):0;
		$resize_y=(isset($params[1])&&$params[1])?intval($params[1]):0;
		$method=(isset($params[2])&&$params[2])?$params[2]:"fixed";
		$types=(isset($params[3])&&$params[3])?$params[3]:"jpg|png|gif|jpeg|svg";
		$to_name=(isset($params[4])&&$params[4])?$params[4]:"{$this->old_table}_{$from}_{$this->current_id}_l";
		$resize_name=(isset($params[5])&&$params[5])?$params[5]:"{$this->old_table}_{$from}_{$this->current_id}_s";
		
		return $this->load_file_abstract($from, $to_path, $to_name, $types, $resize_x, $resize_y, $resize_name, $method);
	}
	
	public function load_file_abstract($from, $to_path, $to_name, $types, $resize_x, $resize_y, $resize_name, $method){
		$config['file_name']="/".$to_name;
		$config['upload_path'] = $_SERVER['DOCUMENT_ROOT']."$to_path";
		$config['allowed_types'] = $types;
		$config['max_size'] = '10000';
		$config['max_width'] = '10000';
		$config['max_height'] = '10000';
		$config['overwrite'] = true;	
		$config['file_ext_tolower'] = true;	
		
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
		/*$this->load->library('image_moo');
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
		}*/
	}
	
	public function get_config(){
		if($this->config&&count($this->config)){
			return $this->load->view("common/config", array(
				'data'=>$this->config,
				'controller'=>$this->controller,
				'model'=>$this->old_table,
			),true);
		}
		return "";
	}
	
	public function set_config($post){	
		foreach($this->config['fields'] as $name=>$values){
			if(!$this->config['fields'][$name]['is_always']){
				$this->config['fields'][$name]['is_active']=isset($post['fields'][$name]);
			}
		}
		
		foreach($this->config['rools'] as $name=>$values){
			$this->config['rools'][$name]=isset($post['user_rools'][$name]);
		}
		
		if(isset($this->config['settings'])){
			foreach($this->config['settings'] as $name=>$values){
				foreach($values['data'] as $name2=>$one){
					if($one['type']!='checkbox'){
						$this->config['settings'][$name]['data'][$name2]['value']=$post['settings'][$name][$name2];
					}
					else{
						$this->config['settings'][$name]['data'][$name2]['value']=isset($post['settings'][$name][$name2]);
					}
				}
			}
		}
		
		$module_id=$this->config['id'];
		$module=$post['model'];
		$this->load->model('modules_config_model');
		$this->modules_config_model->delete_where(array('id'=>$module_id,'module'=>$module,));
		$this->modules_config_model->insert(array(
			'id'=>$module_id,
			'module'=>$module,
			'data'=>serialize($this->config),
		));
		
		redirect($this->controller."/config");
	}
	
	function run_sql_file($location){
		$commands = file_get_contents($location);

		$lines = explode("\n",$commands);
		$commands = '';
		foreach($lines as $line){
			$line = trim($line);
			if( $line && !$this->startsWith($line,'--') ){
				$commands .= $line . "\n";
			}
		}
		$commands = explode("<--end-->", $commands);

		$total = $success = 0;
		foreach($commands as $command){
			if(trim($command)){
				$success +=1;
				$this->db->query($command);
				$total += 1;
			}
		}

		return array(
			"success" => $success,
			"total" => $total
		);
	}

	private function startsWith($haystack, $needle){
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
	
	public function model_exists($model){
		$model=ucfirst($model);
		return file_exists(APPPATH."models/$model.php");
	}
} 
?>