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

session_start();

require_once('config/constants.php');

/* Generate the Config file for instalation
 *
 * install() will generate the INI config file to complete the instalation of DPortal CMS
 *
 * Parameters:
 *
 *	* string sitename
 *	   The Sitename, a simple name to identify the Website.
 *
 *	* string sitedesc
 *	   A description of the Website
 *
 *	* string user
 *	   The default Username of the Website.
 *
 *	* string password
 *	   The password of the default user.
 *
 *	* string nick
 *	   A Nickname of the user, trat may be different than the Username.
 *
 *	* string phpbb_dir
 *	   The path of the phpBB installation, if will be used.
 *
 *	* string banner
 *	   The path or URL of the banner. it can be a static or dynamic image.
 *
 *	* bool use_rewrite
 *	   Option to be used if you wish to use mod_rewrite (available in Apache2 only)
 *
 * Returned values:
 *
 *	This function will return TRUE if the file is writen successfully, FALSE in case of error.
 *
*/

function install($sitename,$sitedesc,$user,$password,$nick,$phpbb_dir = null,$banner = null,$use_rewrite = null){

	$check_site = preg_match("/[\w\s&;]{5,50}/",$sitename);
	$check_site_desc = preg_match("/[\w\s,;&.-_]{3,100}/",$sitedesc);
	$check_user = preg_match("/[\w\s-_]{3,15}/",$user);
	$check_nick = preg_match("/[\w\s-_]{3,50}/",$nick);
	$check_pass = preg_match("/[\w\W]{5,20}/",$password);
	$check_phpbb_dir = preg_match("/(^(\/[\w\/]+\/)+$)/",$phpbb_dir);
	if($phpbb_dir == null) $check_phpbb_dir = 1;
	
	if($use_rewrite == null) $use_rewrite = false;

	if($check_site>=1&&$check_site_desc>=1&&$check_user>=1&&$check_nick>=1&&$check_pass>=1&&$check_phpbb_dir>=1){
		$output = ";Site config CSV file generated automaticaly. DO NOT EDIT!\n";
		$output.= "sitename = \"$sitename\"\n";
		$output.= "sitedesc = \"$sitedesc\"\n";
		$output.= "banner = \"$banner\"\n";
		$output.= "phpbb_dir = \"$phpbb_dir\"\n";
		$output.= "user = \"$user\"\n";
		$output.= "password = \"".sha1($password)."\"\n";
		$output.= "nick = $nick\n";
		$output.= "use_rewrite = $use_rewrite\n";
		$output.= "smarty_debugging = false\n";

		$saved = file_put_contents(CONFIG_PATH.'site.ini',$output,LOCK_EX);
	
		if($saved !== false) return true;
		else return false;

	}else{

		return array('check_site'=>$check_site,'sitename'=>$sitename,
		'check_sitedesc'=>$check_site_desc,'sitedesc'=>$sitedesc,
		'check_user'=>$check_user,'user'=>$user,
		'check_pass'=>$check_pass,'pass'=>$pass,
		'check_nick'=>$check_nick,'nick'=>$nick,
		'check_phpbb_dir'=>$check_phpbb_dir,'phpbb_dir'=>$phpbb_dir);
	}
}

if(is_writable(CONFIG_PATH) &&
   is_writable(SMARTY_TEMPLATES_PATH.'templates_c/') &&
   is_writable(SMARTY_TEMPLATES_PATH.'cache/') &&
   is_writable(CONTENT_PATH) &&
   is_writable(ENTRIES_PATH) &&
   is_writable(COMMENTS_PATH) &&
   is_writable(GALLERY_PATH) &&
   is_writable(VIDEOS_PATH)&&
   is_readable(SMARTY_LIBRARIES_PATH) &&
   is_readable(SMARTY_LIBRARIES_PATH.'Smarty.class.php')&&
   is_readable(SMARTY_LIBRARIES_PATH.'Smarty_Compiler.class.php')&&
   is_readable(SMARTY_LIBRARIES_PATH.'Config_File.class.php')) $writable = true;
   
if(isset($_GET['INSTALL']) && !file_exists(CONFIG_PATH.'site.ini')){

	$sitename = htmlentities(utf8_decode($_POST['sitename']));
	$sitedesc = htmlentities(utf8_decode($_POST['sitedesc']));
	$banner = $_POST['banner'];
	$phpbb_dir = $_POST['phpbb_dir'];
	$user = htmlentities($_POST['user']);
	$password = $_POST['password'];
	$nick = $_POST['nick'];
	$use_rewrite = $_POST['use_rewrite'];	

	$install = install($sitename,$sitedesc,$user,$password,$nick,$phpbb_dir,$banner,$use_rewrite);

	if($install === true){
		$_SESSION['install_success'] = true;
		header('location:'.$_SERVER['PHP_SELF'].'?INSTALLED');

	}else{
		$_SESSION['data_error'] = $install;
		header('location:'.$_SERVER['PHP_SELF']);
	}
	
}elseif(isset($_GET['DELETE'])){

	@unlink(__FILE__);
	header('location:panel.php');
	die();
	
}elseif(isset($_GET['INSTALLED']) || file_exists("config/site.ini")){

	if($_SESSION['install_success']){

		require_once(INCLUDES_PATH.'install-success_template.php');
	}else{
		require_once(INCLUDES_PATH.'install-error_template.php');
	}
	session_destroy();

}elseif(!$writable){
	
	require_once(INCLUDES_PATH.'install-notwritable_template.php');
	
}elseif(!file_exists(CONFIG_PATH.'site.ini') && $writable){
	if($_SESSION['data_error'] != null) $error_data = $_SESSION['data_error'];

	require_once(INCLUDES_PATH.'install-main_template.php');
	$_SESSION['data_error'] = null;
}
?>
