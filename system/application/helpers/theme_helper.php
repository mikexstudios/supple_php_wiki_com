<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();
$CI->load->library('template'); //Seems like template library has not been loaded yet.

/**
 * An alias for ->execute() that is used in templating
 * so that users have an easier time using "tags". Can accept
 * additional arguments which will be passed to ->execute().
 *
 * @param string $inTag Short variable-like name associated with a function such as 'getimagetag'.
 * @return mixed Returns whatever the function associated to the tag returns. Could possibly be nothing. Usually, expect a string.
 */
function get($inTag) {
	$CI =& get_instance();
	
	  if (func_num_args() > 1)
	  {
	      $args = func_get_args();
	      return call_user_func_array(array(&$CI->template, 'execute'), $args);
	  }
	
	return $CI->template->execute($inTag);
}

/**
 * Similar to get() as an alias for $CI->doAction, but prints
 * the output rather than returning it. Can accept
 * additional arguments which will be passed to ->doAction().
 * 
 * @param string $inTag Short variable-like name associated with a function such as 'getimagetag'.
 */
function out($inTag) {
	if (func_num_args() > 1)
	{
		$args = func_get_args();
		echo call_user_func_array('get', $args); 
		return;
	}
	
	echo get($inTag);

}

$CI->template->add_function('execution_time', 'get_execution_time');
function get_execution_time() {
	global $CI;
	
	return $CI->benchmark->elapsed_time();
}

$CI->template->add_function('database_queries', 'get_num_database_queries');
function get_num_database_queries() {
	global $CI;
	
	return $CI->db->total_queries();
}

$CI->template->add_function('form_value', 'get_form_value');
function get_form_value($in_name, $escape=true) {
	global $CI;

	if($escape === true)
	{
		$CI->load->helper('form');
		return form_prep($CI->validation->$in_name);
	}
	
	return $CI->validation->$in_name;
}

$CI->template->add_function('page_url', 'construct_page_url');
function construct_page_url($page, $handler='', $args='') {
	$segments = array($page, $handler, $args);
	return site_url($segments);
}

?>
