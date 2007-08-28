<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['users_dir'] = 'users'; //No trailing slash
$config['users_path']	= BASEPATH.'../users'; //Location where we store user files
$config['script_files_path'] = BASEPATH.'../../suppleText_CI'; //Location of the original script files.

//Probably don't need this:
$config['user_database_prefix'] = 'st_'; //NOTE: This is for the database name. Not the table name!

?>
