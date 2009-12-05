<?php

//We override settings in config.php and database.php here
$config['base_url']	= "http://supple-php-wiki.com/";

$db['default']['hostname'] = "localhost";
$db['default']['username'] = "test";
$db['default']['password'] = "test";
$db['default']['database'] = "supplephpwiki_site";

$config['wikis_dir'] = 'wiki'; //No trailing slash
$config['wikis_path']	= realpath(BASEPATH.'../wiki'); //Location where we store user files
$config['script_files_path'] = realpath(BASEPATH.'../../supplephpwiki_CI'); //Location of the original script files.

?>
