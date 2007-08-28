<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signup {
	var $CI;
	var $users_url; //No trailing slash
	var $users_path; //No trailing slash
	var $script_files_path; //No trailing slash
	var $user_dir; //The current user's directory
	var $name, $email;
	
	var $full_user_url;
	
    function Signup() {
    	$this->CI =& get_instance();
    }
    
    function setUsersURL($in_url) {
    	$this->users_url = $in_url;
    }
    
    function setUsersDirectory($in_path) {
    	$this->users_path = realpath($in_path);
    }
    
    function setScriptFilesDirectory($in_path) {
    	$this->script_files_path = realpath($in_path);
    }
    
    function setName($in_name) {
    	$this->name = $in_name;
    }
    
    function setEmail($in_email) {
    	$this->email = $in_email;
    }
    
    function createNewDirectory() {
    	$this->user_dir = $this->users_path.'/'.$this->name;
    	if(!mkdir($this->user_dir, 0777))
    	{
    		die('Unable to create directory: '.$this->user_dir);
    	}
    }
    
    function copyOverScriptFiles() {
    
    	if(!symlink($this->script_files_path.'/st-system', $this->user_dir.'/st-system'))
    	{
    		die('Unable to create symlink. From '.$this->script_files_path.'/st-system to '.$this->user_dir.'/st-system');
    	}
    	
    	/*
    	if(!symlink($this->script_files_path.'/st-admin', $this->user_dir.'/st-admin'))
    	{
    		die('Unable to create symlink. From '.$this->script_files_path.'/st-admin to '.$this->user_dir.'/st-admin');
    	}
    	*/
    	
    	if(!symlink($this->script_files_path.'/index.php', $this->user_dir.'/index.php'))
    	{
    		die('Unable to create symlink. From '.$this->script_files_path.'/index.php to '.$this->user_dir.'/index.php');
    	}
    	
    	if(!symlink($this->script_files_path.'/.htaccess', $this->user_dir.'/.htaccess'))
    	{
    		die('Unable to create symlink. From '.$this->script_files_path.'/.htaccess to '.$this->user_dir.'/.htaccess');
    	}
    	
    	//Now copy over elements from st-external
    	/*
    	if($this->_dircopy($this->script_files_path.'/st-external', $this->user_dir.'/st-external') <= 0)
    	{
    		die('Unable to copy directory. From '.$this->script_files_path.'/st-external to '.$this->user_dir.'/st-external');
    	}
    	*/
    	
    	//Create st-external directory
    	if(!mkdir($this->user_dir.'/st-external', 0777))
    	{
    		die('Unable to create directory: '.$this->user_dir.'/st-external');
    	}

    	if(!symlink($this->script_files_path.'/st-external/.htaccess', $this->user_dir.'/st-external/.htaccess'))
    	{
    		die('Unable to create symlink. From '.$this->script_files_path.'/st-external/.htaccess to '.$this->user_dir.'/st-external/.htaccess');
    	}    	
    	
    	//Symbolic links to theme (current implementation until we allow user to upload theme)
    	if(!symlink($this->script_files_path.'/st-external/themes', $this->user_dir.'/st-external/themes'))
    	{
    		die('Unable to create symlink. From '.$this->script_files_path.'/st-external/themes to '.$this->user_dir.'/st-external/themes');
    	}
    	
    }
    
    function generateConfigFile() {
    
		$config_sample_file = file_get_contents($this->script_files_path.'/st-external/st-config.php.sample');
		//Set search and replaces
		$search[] = 'st_'; $replace[] = $this->name.'_'; //Do this before the others since this has the most potential to conflict.
		$this->full_user_url = $this->users_url.$this->name.'/'; //Set so we can retrieve later
		$search[] = 'http://yoursite.com/'; $replace[] = $this->users_url.$this->name.'/';
		//$search[] = 'localhost'; $replace[] = 'localhost';
		$search[] = 'putyourdbnamehere'; $replace[] = $this->CI->db->database;
		//For now, we don't create separate users for each database. But we should later!
		$search[] = 'usernamehere'; $replace[] = $this->CI->db->username;
		$search[] = 'yourpasswordhere'; $replace[] = $this->CI->db->password;
		$search[] = "\$db['suppletext']['dbprefix'].'sessions'"; $replace[] = 'sessions';

		$config_sample_file = str_replace($search, $replace, $config_sample_file);
		
		if(!file_put_contents($this->user_dir.'/st-external/st-config.php', $config_sample_file))
		{
			die('Unable to create config file for user: '.$this->user_dir.'/st-external/st-config.php');
		}
    }
    
    function createAndPopulateDatabase() {
    	
    	$this->CI->load->dbutil();
    	
    	/*
    	//Create database
			if(!$this->CI->dbutil->create_database($this->CI->config->item('user_database_prefix').$this->name))
			{
			    die('Unable to create database: '.$this->CI->config->item('user_database_prefix').$this->name);
			}
			*/
			
			//Create tables
			$this->CI->db->query("
							CREATE TABLE IF NOT EXISTS `".$this->name."_archives` (
							  `id` int(10) unsigned NOT NULL auto_increment,
							  `tag` varchar(75) NOT NULL default '',
							  `time` int(10) NOT NULL,
							  `body` mediumtext NOT NULL,
							  `user` varchar(75) NOT NULL default '',
							  `note` varchar(100) NOT NULL default '',
							  PRIMARY KEY  (`id`),
							  FULLTEXT KEY `body` (`body`)
							) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
		
			$this->CI->db->query("
							CREATE TABLE IF NOT EXISTS `".$this->name."_config` (
							  `order` smallint(5) unsigned NOT NULL default '0',
							  `option` varchar(50) NOT NULL default '',
							  `value` text NOT NULL,
							  `vartype` enum('string','number','boolean') NOT NULL default 'string',
							  `displaycode` varchar(20) NOT NULL default '',
							  `name` varchar(100) NOT NULL default '',
							  `description` varchar(200) NOT NULL default '',
							  PRIMARY KEY  (`option`),
							  UNIQUE KEY `order` (`order`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

			$this->CI->db->query("	
							CREATE TABLE IF NOT EXISTS `".$this->name."_pages` (
							  `id` int(10) unsigned NOT NULL auto_increment,
							  `tag` varchar(75) NOT NULL default '',
							  `time` int(10) NOT NULL,
							  `body` mediumtext NOT NULL,
							  `user` varchar(75) NOT NULL default '',
							  `note` varchar(100) NOT NULL default '',
							  PRIMARY KEY  (`id`),
							  FULLTEXT KEY `body` (`body`)
							) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
			
			//Insert default data:
			$this->CI->db->query("							
							INSERT INTO `".$this->name."_config` (`order`, `option`, `value`, `vartype`, `displaycode`, `name`, `description`) VALUES 
								(1, 'root_page', 'HomePage', 'string', 'string', 'Default Page', 'The page that is displayed when no page is specified.'),
								(0, 'site_name', 'My suppleText wiki', 'string', 'text', 'Wiki Site Name', 'A title for your wiki'),
								(2, 'use_theme', 'supple', 'string', 'text', 'Use Theme', 'The theme used to display pages');");
			
			$this->CI->load->helper('date');
			$this->CI->db->query("	
							INSERT INTO `".$this->name."_pages` (`id`, `tag`, `time`, `body`, `user`, `note`) VALUES 
								(1, 'HomePage', ".now().", '== Welcome to your new suppleText wiki! ==\n\nYou will want to replace this text with whatever you want to put on your new home page. This is done by clicking the Edit link in the bottom right-hand corner. Any time you want to edit this or any content page, just click on the link!', 'suppleText', 'Initial Setup'),				
								(2, 'SandBox', ".now().", '=== Welcome to the SandBox! ===\n\nThis page is for playing around with wiki syntax. Feel free to mess around!', 'suppleText', 'Initial Setup'),
								(3, 'Special:Navigation', ".now().", 'HomePage | [[http://www.suppletext.com/|suppleText]] | [[SandBox]] | //Put navigation links here//', 'suppleText', 'Initial Setup');");
			
			
    }
    
    
	// A function to copy files from one directory to another one, including subdirectories and
	// nonexisting or newer files. Function returns number of files copied.
	// This function is PHP implementation of Windows xcopy  A:\dir1\* B:\dir2 /D /E /F /H /R /Y
	// Syntaxis: [$number =] dircopy($sourcedirectory, $destinationdirectory [, $verbose]);
	// Example: $num = dircopy('A:\dir1', 'B:\dir2', 1);
	// Written by SkyEye
	function _dircopy($srcdir, $dstdir, $verbose = false) {
	  $num = 0;
	  if(!is_dir($dstdir)) mkdir($dstdir);
	  if($curdir = opendir($srcdir)) {    	if(!mkdir($this->user_dir, 0777))
    	{
    		die('Unable to create directory: '.$this->user_dir);
    	}
	    while($file = readdir($curdir)) {
	      if($file != '.' && $file != '..' && $file != '.svn') { //Ignore subversion dirs too
	        $srcfile = $srcdir . '/' . $file;
	        $dstfile = $dstdir . '/' . $file;
	        if(is_file($srcfile)) {
	          if(is_file($dstfile)) $ow = filemtime($srcfile) - filemtime($dstfile); else $ow = 1;
	          if($ow > 0) {
	            if($verbose) echo "Copying '$srcfile' to '$dstfile'...";
	            if(copy($srcfile, $dstfile)) {
	              touch($dstfile, filemtime($srcfile)); $num++;
	              if($verbose) echo "OK\n";
	            }
	            else echo "Error: File '$srcfile' could not be copied!\n";
	          }                  
	        }
	        else if(is_dir($srcfile)) {
	          $num += $this->_dircopy($srcfile, $dstfile, $verbose);
	        }
	      }
	    }
	    closedir($curdir);
	  }
	  return $num;
	}

}

?>
