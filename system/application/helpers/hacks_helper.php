<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();

//For making database output unicode
$CI->load->database(); //Helpers are called before libraries
$CI->db->query("SET NAMES 'utf8'");  //We make SQL output unicode

//Set pages to output unicode
$CI->output->set_header("Content-Type: text/html; charset=UTF-8");

?>
