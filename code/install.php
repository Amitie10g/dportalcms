<?php

session_start();

// define('INSTALLER',true);

function install($sitename,$sitedesc,$user,$password,$phpbb_dir = null,$banner = null,$use_rewrite = null){

	$check_site = preg_match("/[\w\s&;]{5,50}/",$sitename);
	$check_site_desc = preg_match("/[\w\s,;&.-_]{3,100}/",$sitedesc);
	$check_user = preg_match("/[\w\s-_]{3,15}/",$user);
	$check_pass = preg_match("/[\w\W]{5,20}/",$password);
	$check_phpbb_dir = preg_match("/(^(\/[\w\/]+\/)+$)/",$phpbb_dir);
	if($phpbb_dir == null) $check_phpbb_dir = 1;

	if($check_site>=1&&$check_site_desc>=1&&$check_user>=1&&$check_pass>=1&&$check_phpbb_dir>=1){
		$output = ";Site config CSV file generated automaticaly. DO NOT EDIT!\n";
		$output.= "sitename = \"$sitename\"\n";
		$output.= "sitedesc = \"$sitedesc\"\n";
		$output.= "banner = \"$banner\"\n";
		$output.= "phpbb_dir = \"$phpbb_dir\"\n";
		$output.= "user = \"$user\"\n";
		$output.= "password = \"".sha1($password)."\"\n";
		$output.= "use_rewrite = $use_rewrite";

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

if(isset($_GET['INSTALL']) && !file_exists('config/site.ini')){

	$sitename = htmlentities(utf8_decode($_POST['sitename']));
	$sitedesc = htmlentities(utf8_decode($_POST['sitedesc']));
	$banner = $_POST['banner'];
	$phpbb_dir = $_POST['phpbb_dir'];
	$user = htmlentities($_POST['user']);
	$password = $_POST['password'];
	$use_rewrite = $_POST['use_rewrite'];	

	$install = install($sitename,$sitedesc,$user,$password,$phpbb_dir,$banner,$use_rewrite);

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
		session_destroy();
	}else{
		require_once('includes/install-error_template.php');

	}
}elseif(!file_exists("config/site.ini")){
	if($_SESSION['data_error'] != null) $error_data = $_SESSION['data_error'];

	require_once('includes/install-main_template.php');
	$_SESSION['data_error'] = null;
}
?>
