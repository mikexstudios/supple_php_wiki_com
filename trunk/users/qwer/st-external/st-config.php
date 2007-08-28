<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// ** Site URL ** //
$config['base_url']	= "http://beta.suppletext.com/users/qwer/"; //With trailing slash

// ** MySQL settings ** //
$db['suppletext']['hostname'] = "localhost"; // 99% chance you won't need to change this value
$db['suppletext']['username'] = "test"; // Your MySQL username
$db['suppletext']['password'] = "test"; // ...and password
$db['suppletext']['database'] = "suppletextcom_site"; // The name of the database
// You can have multiple installations in one database if you give each a unique prefix
$db['suppletext']['dbprefix'] = "qwer_"; // Only numbers, letters, and underscores please!

// ** URI Settings ** //
$config['index_page'] = ""; //If using URL Rewriting, set to empty. Otherwise, set to 'index.php'

// ** Wiki Settings ** //
$config['default_page'] = 'HomePage'; //Default wiki page.

// ** Other Settings ** //
$config['encryption_salt'] = 'stsalt_'; // 99% chance you won't need to change this value

?>
