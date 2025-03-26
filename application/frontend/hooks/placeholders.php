<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
function placeholders()
{
	$CI =&get_instance();
	$buffer = $CI->output->get_output();
	
	$CI->load->model('placeholders_model');
	
	$placeholders=$CI->placeholders_model->get_list(array(),'name','value');
 
	$search = array_keys($placeholders);
	$replace = array_values($placeholders);
 
	$buffer = str_replace($search, $replace, $buffer);
 
	$CI->output->set_output($buffer);
	$CI->output->_display();
}
?>