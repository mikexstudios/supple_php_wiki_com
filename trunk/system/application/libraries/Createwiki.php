<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CreateWiki {
	var $CI;
	var $users_url; //No trailing slash
	var $base_domain;
	var $users_path; //No trailing slash
	var $script_files_path; //No trailing slash
	var $user_dir; //The current user's directory
	var $wiki_domain, $wiki_title;
	var $username;
	
	var $full_user_url;
	
    function CreateWiki() {
    	$this->CI =& get_instance();
    }
    
    function does_wiki_exist($in_wiki) {
			//$query = $this->CI->db->query('DESCRIBE `'.$in_wiki.'`;');
			$this->CI->db->select('id');
			$this->CI->db->from($in_wiki.'_pages');
			$this->CI->db->limit(1);
			$query = $this->CI->db->get();

			if($query === FALSE)
			{
				return false;
			}
			
			if ($query->num_rows() > 0)
			{
				return true;
			}
			
			return false;
		}
    
    function create_new_directory() {
    	$this->user_dir = $this->users_path.'/'.$this->wiki_domain;
    	if(!mkdir($this->user_dir, 0777))
    	{
    		show_error('Unable to create directory: '.$this->user_dir);
    	}
    	chmod($this->user_dir, 0777);
    }
    
    function copy_over_script_files() {
    
    	if(!symlink($this->script_files_path.'/st-system', $this->user_dir.'/st-system'))
    	{
    		show_error('Unable to create symlink. From '.$this->script_files_path.'/st-system to '.$this->user_dir.'/st-system');
    	}
    	
    	/*
    	if(!symlink($this->script_files_path.'/st-admin', $this->user_dir.'/st-admin'))
    	{
    		die('Unable to create symlink. From '.$this->script_files_path.'/st-admin to '.$this->user_dir.'/st-admin');
    	}
    	*/
    	
    	if(!symlink($this->script_files_path.'/index.php', $this->user_dir.'/index.php'))
    	{
    		show_error('Unable to create symlink. From '.$this->script_files_path.'/index.php to '.$this->user_dir.'/index.php');
    	}
    	
    	if(!symlink($this->script_files_path.'/.htaccess', $this->user_dir.'/.htaccess'))
    	{
    		show_error('Unable to create symlink. From '.$this->script_files_path.'/.htaccess to '.$this->user_dir.'/.htaccess');
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
    		show_error('Unable to create directory: '.$this->user_dir.'/st-external');
    	}
    	chmod($this->user_dir.'/st-external', 0777);

    	if(!symlink($this->script_files_path.'/st-external/.htaccess', $this->user_dir.'/st-external/.htaccess'))
    	{
    		show_error('Unable to create symlink. From '.$this->script_files_path.'/st-external/.htaccess to '.$this->user_dir.'/st-external/.htaccess');
    	}    	
    	
    	//Symbolic links to theme (current implementation until we allow user to upload theme)
    	if(!symlink($this->script_files_path.'/st-external/themes', $this->user_dir.'/st-external/themes'))
    	{
    		show_error('Unable to create symlink. From '.$this->script_files_path.'/st-external/themes to '.$this->user_dir.'/st-external/themes');
    	}
    	
    }
    
    function generate_config_file() {

			$config_sample_file = @file_get_contents($this->script_files_path.'/st-external/st-config.php.sample');
			if($config_sample_file === FALSE)
			{
				show_error('Sample config file not found!');
			}
			
			//Set search and replaces
			$search[] = 'st_'; $replace[] = $this->wiki_domain.'_'; //Do this before the others since this has the most potential to conflict.
			//$search[] = 'localhost'; $replace[] = $db_config['hostname'];
			//$search[] = 'http://yoursite.com/'; $replace[] = $this->users_url.$this->wiki_domain.'/';
			$search[] = 'http://yoursite.com/'; $replace[] = 'http://'.$this->wiki_domain.'.'.$this->base_domain.'/';
			$search[] = 'putyourdbnamehere'; $replace[] = $this->CI->db->database;
			$search[] = 'usernamehere'; $replace[] = $this->CI->db->username;
			$search[] = 'yourpasswordhere'; $replace[] = $this->CI->db->password;
			//$search[] = "\$db['suppletext']['dbprefix'].'sessions'"; $replace[] = 'sessions';
	
			$config_sample_file = str_replace($search, $replace, $config_sample_file);
			
			//Append things to config file:
			ob_start();
?>
// ** Custom suppleText.com settings ** // 
$config['sessions_table_prefix'] = '';
$config['users_table_prefix'] = '';
<?php
			$custom_config = ob_get_contents();
			ob_end_clean();
			
			$config_sample_file .= "<?php\n".$custom_config."\n?>";
						
			if(!file_put_contents($this->user_dir.'/st-external/st-config.php', $config_sample_file))
			{
				show_error('Unable to create config file for user: '.$this->user_dir.'/st-external/st-config.php');
			}
			
			chmod($this->user_dir.'/st-external/st-config.php', 0777);
    }
    
    function create_and_populate_database() {
			$db_info['dbdriver'] = 'mysql';
			$db_info['dbprefix'] = $this->wiki_domain.'_';
			
			// Define schema info
			$available_dbms = array(
				'mysql'=> array(
					'LABEL'			=> 'MySQL',
					'SCHEMA'		=> 'mysql', 
					'DELIM'			=> ';',
					'DELIM_BASIC'	=> ';',
					'COMMENTS'		=> 'remove_remarks'
					)
				);
		
			$dbms_schema = $this->script_files_path.'/st-system/install/sql/'.$db_info['dbdriver'].'_schema.sql';
			
			$remove_remarks = $available_dbms[$db_info['dbdriver']]['COMMENTS'];
			$delimiter = $available_dbms[$db_info['dbdriver']]['DELIM']; 
			$delimiter_basic = $available_dbms[$db_info['dbdriver']]['DELIM_BASIC']; 
			
			$this->CI->load->helper('sqlparse'); //phpBB's DB schema cleaning library
			$sql_query = @file_get_contents($dbms_schema);
			if($sql_query === FALSE)
			{
				show_error('Could not find SQL schema!');
			}
			
			//Set up table prefix
			$sql_query = str_replace('st_', $db_info['dbprefix'], $sql_query);
			
			//Clean up SQL file
			$sql_query = remove_remarks($sql_query);
			
			//Get SQL statements
			$sql_query = split_sql_file($sql_query, $delimiter);
			
			//Add Options		
			$sql_query[] = 'INSERT INTO `'.$db_info['dbprefix'].ST_CONFIG_TABLE."` VALUES (3, 'site_name', ".$this->CI->db->escape($this->wiki_title).");";
			
			//Execute queries
			$is_error = false;
			for ($i = 0; $i < count($sql_query); $i++) 
			{
				if (trim($sql_query[$i]) != '') 
			  {
				  $result = $this->CI->db->query($sql_query[$i]);
				    
					if($result===FALSE) //Error in query
					{
						show_error('Error in importing SQL Schema!');
					}
				}
			}
			
			// -----------------
			
			//Drop sessions and users table
			$this->CI->db->query('DROP TABLE '.$db_info['dbprefix'].ST_SESSIONS_TABLE);
			$this->CI->db->query('DROP TABLE '.$db_info['dbprefix'].ST_USERS_TABLE);
			
			//Add this wiki to the user's list of wikis
			$this->CI->db->get(); //Free up any previous queries
			$this->CI->users_model->username = $this->username;
			$user_wikis = $this->CI->users_model->get_value('wikis');
			$user_wikis = add_to_comma_list($user_wikis, $this->wiki_domain);
			$this->CI->users_model->set_value('wikis', $user_wikis);
			
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
