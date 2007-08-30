<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['wikis_dir'] = 'wiki'; //No trailing slash
$config['wikis_path']	= realpath(BASEPATH.'../wiki'); //Location where we store user files
$config['script_files_path'] = realpath(BASEPATH.'../../suppleText_CI'); //Location of the original script files.

$config['encryption_salt'] = 'stsalt_';

?>
