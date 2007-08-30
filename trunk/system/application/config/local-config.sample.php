<?php

//We override settings in config.php and database.php here
$config['base_url']	= "http://local.suppletext.com/";

$db['default']['hostname'] = "localhost";
$db['default']['username'] = "test";
$db['default']['password'] = "test";
$db['default']['database'] = "suppletextcom_site";

$config['wikis_dir'] = 'wiki'; //No trailing slash
$config['wikis_path']	= realpath(BASEPATH.'../wiki'); //Location where we store user files
$config['script_files_path'] = '/home/mikeh/suppletext_trunk'; //Location of the original script files.

?>
