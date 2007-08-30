<?php
/**
 * Helper functions related to user management
 */

$CI =& get_instance();

$CI->template->add_function('logged_in_username', 'get_logged_in_username');
function get_logged_in_username() {
	global $CI;

	return $CI->session->userdata('username');
}

$CI->template->add_function('user_info', 'get_user_info');
function get_user_info($in_key, $in_username='') {
	global $CI;
	
	$CI->load->model('users_model', 'users_model_theme');
	if(empty($in_username))
	{
		$in_username = get_logged_in_username();
	}
	$CI->users_model_theme->username = $in_username;
	return $CI->users_model_theme->get_value($in_key);
}

$CI->template->add_function('user_role', 'get_user_role');
function get_user_role($in_username='') {
	$user_role = get_user_info('role', $in_username);
	if(!empty($user_role))
	{
		return $user_role; 
	}
	
	return 'Anonymous';
} 

$CI->template->add_function('user_wikis', 'get_user_wikis');
function get_user_wikis($in_username='') {
	$wikis = get_user_info('wikis', $in_username);
	return comma_list_to_array($wikis);
}	

?>
