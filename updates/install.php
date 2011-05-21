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

error_reporting('E_ALL & ^E_STRICT');

require_once('config/constants.php');

function install($sitename,$site_desc,$user,$password,$nick,$email,$lang = 'en',$use_rewrite = 0,$phpbb_dir = null){

	$check_site = preg_match("/[\w\s&;]{5,50}/",$sitename);
	$check_site_desc = preg_match("/[\w\s,;&.-_]{3,100}/",$site_desc);
	$check_user = preg_match("/[\w\s-_]{3,15}/",$user);
	$check_pass = preg_match("/[\w\W]{5,20}/",$password);
	$check_phpbb_dir = preg_match("/(^(\/[\w\/]+\/)+$)/",$phpbb_dir);
	if($phpbb_dir == null) $check_phpbb_dir = 1;
	
	if($use_rewrite == null) $use_rewrite = false;

	if($check_site>=1&&$check_site_desc>=1&&$check_user>=1&&$check_pass>=1&&$check_phpbb_dir>=1){
	
		$user = sha1($user);
		$password = sha1($password);
	
		// Configure the output (using HEREDOC syntax)
		$output = <<<OUTPUT
;Site config file generated automatically. DO NOT EDIT!	
sitename	= "$sitename"
sitedesc	= "$site_desc"
admin_email	= "$email"
admin_nick	= "$nick"
phpbb_dir	= "$phpbb_dir"
user		= "$user"
password	= "$password"
language	= "$language"
use_rewrite	= $use_rewrite
smarty_debugging= 0

OUTPUT;

		$conf_file = @fopen("config/site.ini",'x');
		$save = @fwrite($conf_file,$output);
		@fclose($conf_file);
	
		if($save) return true;

	}else{

		return array('check_site'=>$check_site,'sitename'=>$sitename,
		'check_sitedesc'=>$check_site_desc,'sitedesc'=>$sitedesc,
		'check_user'=>$check_user,'user'=>$user,
		'check_pass'=>$check_pass,'pass'=>$pass,
		'check_phpbb_dir'=>$check_phpbb_dir,'phpbb_dir'=>$phpbb_dir);
	}
}

if(is_writable('config') &&
   is_writable('smarty/templates_c') &&
   is_writable('smarty/cache') &&
   is_writable('content') &&
   is_writable('smarty/cache') &&
   is_writable('smarty/cache') &&
   is_writable('smarty/cache') &&
   is_writable('smarty/cache') &&
   is_writable('smarty/cache')) $writable = true;
else $writable = false;

if(isset($_GET['INSTALL']) && !file_exists('config/site.ini')){

	$sitename = htmlentities(utf8_decode($_POST['sitename']));
	$sitedesc = htmlentities(utf8_decode($_POST['sitedesc']));
	$nick = $_POST['nick'];
	$email = $_POST['email'];
	$phpbb_dir = $_POST['phpbb_dir'];
	$user = $_POST['user'];
	$password = $_POST['password'];
	$use_rewrite = $_POST['use_rewrite'];
	$lang = $_POST['lang'];

	$install = install($sitename,$sitedesc,$user,$password,$nick,$email,$lang,$use_rewrite,$phpbb_dir);

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

		require_once('includes/install-success_template.php');
	}else{
		require_once('includes/install-error_template.php');
	}
	session_destroy();

}elseif(!$writable){
	
	require_once('includes/install-notwritable_template.php');
	
}elseif(!file_exists("config/site.ini") && $writable){
	if(!empty($_SESSION['data_error'])) $error_data = $_SESSION['data_error'];

	require_once('includes/install-main_template.php');
	$_SESSION['data_error'] = null;
}
?>
