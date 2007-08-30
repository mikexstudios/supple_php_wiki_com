<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['users_dir'] = 'users'; //No trailing slash
$config['users_path']	= realpath(BASEPATH.'../users'); //Location where we store user files
$config['script_files_path'] = realpath(BASEPATH.'../../suppleText_CI'); //Location of the original script files.

$config['encryption_salt'] = 'stsalt_';

?>
