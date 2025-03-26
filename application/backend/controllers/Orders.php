<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class orders extends MY_Table {
	protected $table='orders';
	protected $table_top='orders_group';
	protected $controller="orders";
	
	public function add_item($item_id, $add_id){
		$this->load->model('catalogs_model');
		$new=$this->catalogs_model->get_by_fields(array(
			'id'=>$add_id,
			'is_block'=>0,
		));
		
		$count=$this->orders_model->get_by_fields(array('is_block'=>0,'item_id'=>$add_id,'pid'=>$item_id,));
		if(isset($new['id'])&&!$count){
			$this->orders_model->insert(array(
				'pid'=>$item_id,
				'price'=>$new['price'],
				'price_in'=>$new['price_in'],
				'count'=>1,
				'item_id'=>$new['id'],
			));
		}
		redirect("/orders/edit_group/$item_id");
	}
	
	public function print_one($item_id){
		$this->load->model('catalogs_model');
		$item=$this->orders_group_model->get_by_id($item_id);
		$items=$this->orders_model->get_page(array('is_block'=>0,'pid'=>$item_id,));
		$summa=0;
		foreach($items as &$item_one){
			if(!$item_one['is_matras']){
				$catalog_item=$this->catalogs_model->get_by_id($item_one['item_id']);
				if($catalog_item['item_parent']){
					$catalog_item['url_part']="edit_subitem";
					$parent=$this->catalogs_model->get_by_id($catalog_item['item_parent']);
					$catalog_item['name']=$parent['name']." ({$catalog_item['name']})";
				}
				else{
					$catalog_item['url_part']="edit";
				}
			}
			else{
				$this->load->database('matras', TRUE);
				$this->load->model('matras_model');
				$catalog_item=$this->matras_model->get_by_id($item_one['item_id']);
				if($catalog_item['item_parent']){
					$catalog_item['url_part']="edit_subitem";
					$parent=$this->matras_model->get_by_id($catalog_item['item_parent']);
					$catalog_item['name']=$parent['name']." ({$catalog_item['name']})";
				}
				else{
					$catalog_item['url_part']="edit";
				}

				$this->load->database('default', TRUE);
			}
			$item_one['item']=$catalog_item;
			
			$summa+=$item_one['count']*$item_one['price'];
		}
		
		echo $this->load->view('orders/account',array(
			'item'=>$item,
			'items'=>$items,
			'sum_prop'=>$this->num2str($summa),
		),true);
	}
	
	public function print_two($item_id){
		$this->load->model('catalogs_model');
		$item=$this->orders_group_model->get_by_id($item_id);
		$items=$this->orders_model->get_page(array('is_block'=>0,'pid'=>$item_id,));
		$summa=0;
		foreach($items as &$item_one){
			if(!$item_one['is_matras']){
				$catalog_item=$this->catalogs_model->get_by_id($item_one['item_id']);
				if($catalog_item['item_parent']){
					$catalog_item['url_part']="edit_subitem";
					$parent=$this->catalogs_model->get_by_id($catalog_item['item_parent']);
					$catalog_item['name']=$parent['name']." ({$catalog_item['name']})";
				}
				else{
					$catalog_item['url_part']="edit";
				}
			}
			else{
				$this->load->database('matras', TRUE);
				$this->load->model('matras_model');
				$catalog_item=$this->matras_model->get_by_id($item_one['item_id']);
				if($catalog_item['item_parent']){
					$catalog_item['url_part']="edit_subitem";
					$parent=$this->matras_model->get_by_id($catalog_item['item_parent']);
					$catalog_item['name']=$parent['name']." ({$catalog_item['name']})";
				}
				else{
					$catalog_item['url_part']="edit";
				}

				$this->load->database('default', TRUE);
			}
			$item_one['item']=$catalog_item;
			
			$summa+=$item_one['count']*$item_one['price'];
		}
		
		echo $this->load->view('orders/bill',array(
			'item'=>$item,
			'items'=>$items,
			'sum_prop'=>$this->num2str($summa),
		),true);
	}
	
	function num2str($num) {
		$nul='ноль';
		$ten=array(
			array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
			array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
		);
		$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
		$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
		$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
		$unit=array( // Units
			array('' ,'' ,'',	 1),
			array(''   ,''   ,''    ,0),
			array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
			array('миллион' ,'миллиона','миллионов' ,0),
			array('миллиард','милиарда','миллиардов',0),
		);
		//
		list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
		$out = array();
		if (intval($rub)>0) {
			foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
				if (!intval($v)) continue;
				$uk = sizeof($unit)-$uk-1; // unit key
				$gender = $unit[$uk][3];
				list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
				// mega-logic
				$out[] = $hundred[$i1]; # 1xx-9xx
				if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
				else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
				// units without rub & kop
				if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
			} //foreach
		}
		else $out[] = $nul;
		
		$out[] = $this->morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
		//$out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
		return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));

	}

	function morph($n, $f1, $f2, $f5) {
		$n = abs(intval($n)) % 100;
		if ($n>10 && $n<20) return $f5;
		$n = $n % 10;
		if ($n>1 && $n<5) return $f2;
		if ($n==1) return $f1;
		return $f5;
	}
	
}
?>