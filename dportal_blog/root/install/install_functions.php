<?php
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Installer script (install.php)              #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

function install($sitename,$site_desc,$admin_email,$user,$password,$nick,$site_id,$dportal_absolute_path,$document_root,$libs_dir,$cse_key = null,$use_rewrite = "0",$lang = "en", $memcached_server = null, $memcached_port = null){
	
	$user = sha1($user);
	$password = sha1($password);
	
	// Configure the output (using HEREDOC syntax)
	$conf_output = <<<OUTPUT
<?php	

//Site config file generated automatically. DO NOT EDIT!	
\x24sitename	= "$sitename";
\x24sitedesc	= "$site_desc";
\x24admin_email	= "$admin_email";
\x24admin_nick	= "$nick";
\x24cse_key		= "$cse_key";
\x24admin_user	= "$user";
\x24admin_password= "$password";
\x24language	= "$language";
\x24use_rewrite	= "$use_rewrite";
\x24smarty_debugging= "0";
\x24site_id = "$site_id";
\x24memcached_server = "$memcached_server";
\x24memcached_port = "$memcached_port";

define("DPORTAL_ABSOLUTE_PATH","$dportal_absolute_path"); // public_instalation (absolute!)
define("DPORTAL_PATH",preg_replace("/^\/\x24/","",dirname(\x24_SERVER["PHP_SELF"]))); // public access (relative)
define("REAL_DOCUMENT_ROOT","$document_root"); // Actual DocumentRoot (absolute!)
define("LIBS_PATH","$libs_dir"); // Libraries path // absolute!!!)

?>

OUTPUT;

	$conf_file = @fopen("$dportal_absolute_path/config/config.inc.php",'x');
	$save = @fwrite($conf_file,$conf_output);
	@fclose($conf_file);

	if($save) return true;
	else return false;
}

?>