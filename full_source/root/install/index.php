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
//session_destroy();

//error_reporting('E_ALL & ^E_STRICT');

require_once('install_functions.php');

if(isset($_GET['START_OVER'])){
	session_destroy();
	if(is_file(dirname(dirname(__FILE__)) . '/config/config.inc.php')) @unlink(dirname(dirname(__FILE__)) . '/config/config.inc.php');
	header('location: ' . $_SERVER['PHP_SELF'] . '?step=site_conf');
	die();
}

if(!is_readable(dirname(dirname(__FILE__)) . '/config/config.inc.php') && is_writable(dirname(dirname(__FILE__)) . '/config/')){
	if(isset($_GET['INSTALL'])){
	
		$sitename			= $_SESSION['sitename'];
		$site_desc			= $_SESSION['site_desc'];
		$admin_email			= $_SESSION['email'];
		$use_rewrite			= $_SESSION['use_rewrite'];
		$user				= $_SESSION['user'];
		$password			= $_SESSION['password'];
		$nick				= $_SESSION['nick'];
		$phpbb_dir			= $_SESSION['phpbbdir'];
		$site_id			= $_SESSION['site_id'];
		$dportal_absolute_path		= dirname(dirname(__FILE__));	
		$document_root			= $_SESSION['document_root'];
		$libs_dir			= $_SESSION['libs_dir'];
		$memcached_server		= $_SESSION['memcached_server'];
		$memcached_port			= $_SESSION['memcached_port'];
	
		$install = install($sitename,$site_desc,$admin_email,$user,$password,$nick,$phpbb_dir,$site_id,$dportal_absolute_path,$document_root,$libs_dir,$use_rewrite,$lang,$memcached_server,$memcached_port);
	
		if($install === true){
			$_SESSION['install_success'] = true;
			header('location:'.$_SERVER['PHP_SELF'].'?INSTALLED');
	
		}else{
			$_SESSION['data_error'] = $install;
			header('location:'.$_SERVER['PHP_SELF']);
		}
	
	}else{
		if(!empty($_SESSION['data_error'])) $error_data = $_SESSION['data_error'];
	
	
		if(empty($_GET['step'])){
				require_once('install-header_template.php');
		
		}elseif($_GET['step'] == 'site_conf'){
			require_once('install-header_template.php');
			require_once('install-siteconf_template.php');
	
		}elseif($_GET['step'] == 'path_conf'){
	
			if($_SESSION['siteconf_ok'] != true){
	
				$sitename = htmlentities($_POST['sitename'],NULL,'UTF-8');
				$site_desc = htmlentities($_POST['sitedesc'],NULL,'UTF-8');
				$admin_email = $_POST['email'];
				$use_rewrite = $_POST['use_rewrite'];
				$user = $_POST['user'];
				$password = $_POST['password'];
				$nick = $_POST['nick'];
				$phpbb_dir = $_POST['phpbb_dir'];
				$memcached_server = $_POST['memcached_server'];
				$memcached_port = $_POST['memcached_port'];
				
				// Validate data
				$validate_sitename = preg_match("/^([\w\s&;]){3,25}$/",$sitename);
				$validate_sitedesc = preg_match("/^([\w\W\s&;]){10,100}$/",$site_desc);
				$validate_email    = preg_match("/^\w[-.\w]*@([-a-z0-9]+\.)+[a-z]{2,4}$/",$admin_email);
				$validate_username = preg_match("/^([\w\s]){3,15}$/",$user);
				$validate_password = preg_match("/^([\w\W\s]){3,25}$/",$password);
				$validate_nick     = preg_match("/^([\w\W\s]){3,20}$/",$nick);
				$validate_phpbbdir = preg_match("/^([a-z0-9-_\/])+$/",$phpbb_dir);
				
				if($validate_sitename == 1 && $validate_sitedesc == 1 && $validate_email == 1 && $validate_username == 1 &&
				   $validate_password == 1 && $validate_nick == 1 && ($validate_phpbbdir == 1 || empty($validate_phpbbdir)) &&
				   ($use_rewrite == "1" || empty($use_rewrite))){
				   
					$_SESSION['sitename'] = $sitename;
					$_SESSION['site_desc'] = $site_desc;
					$_SESSION['email'] = $admin_email;
					$_SESSION['user'] = $user;
					$_SESSION['password'] = $password;
					$_SESSION['nick'] = $nick;
					$_SESSION['phpbbdir'] = $phpbb_dir;
					$_SESSION['memcached_server'] = $memcached_server;
					$_SESSION['memcached_port'] = $memcached_port;
					if(!empty($use_rewrite)) $_SESSION['use_rewrite'] = true;
					
					unset($_SESSION['error_sitename']);
					unset($_SESSION['error_sitedesc']);
					unset($_SESSION['error_email']);
					unset($_SESSION['error_user']);
					unset($_SESSION['error_password']);
					unset($_SESSION['error_nick']);
					unset($_SESSION['error_phpbbdir']);
					unset($_SESSION['data_error']);
		
					$_SESSION['siteconf_ok'] = true;
		
				}else{
		
					$_SESSION['data_error'] = true;
					
					if($validate_sitename == 1){ $_SESSION['sitename'] = $sitename; unset($_SESSION['error_sitename']); }
					else $_SESSION['error_sitename'] = true;
					
					if($validate_sitedesc == 1){ $_SESSION['site_desc'] = $site_desc; unset($_SESSION['error_sitedesc']); }
					else $_SESSION['error_sitedesc'] = true;
					
					if($validate_email == 1){ $_SESSION['email'] = $admin_email; unset($_SESSION['error_email']); }
					else $_SESSION['error_email'] = true;
					
					if($validate_username == 1){ $_SESSION['user'] = $user; unset($_SESSION['error_user']); }
					else $_SESSION['error_user'] = true;
					
					if($validate_password == 1){ $_SESSION['password'] = $password; unset($_SESSION['error_password']); }
					else $_SESSION['error_password'] = true;
					
					if($validate_nick == 1){ $_SESSION['nick'] = $nick; unset($_SESSION['error_nick']); }
					else $_SESSION['error_nick'] = true;
					
					if($validate_phpbbdir == 1 || empty($validate_phpbbdir)){ $_SESSION['phpbbdir'] = $phpbb_dir; unset($_SESSION['error_phpbbdir']); }
					else $_SESSION['error_phpbbdir'] = true;
		
					header('location: http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?step=site_conf');
					die();
				}
			}
			
			$dportal_absolute_path = dirname(dirname(__FILE__));
			
			require_once('install-header_template.php');
			require_once('install-pathconf_template.php');
			die();
		
		}elseif($_GET['step'] == 'ready'){
		
			if($_SESSION['siteconf_ok']){
	
				$sitename = $_SESSION['sitename'];
				$site_desc = $_SESSION['site_desc'];
				$admin_email = $_SESSION['email'];
				$use_rewrite = $_SESSION['use_rewrite'];
				$user = $_SESSION['user'];
				$password = $_SESSION['password'];
				$nick = $_SESSION['nick'];
				$phpbb_dir = $_SESSION['phpbbdir'];
				$memcached_server = $_SESSION['memcached_server'];
				$memcached_port = $_SESSION['memcached_port'];
	
				$site_id_default = $_POST['site_id_default'];
				if($site_id_default == "1") $site_id = "default";
				else $site_id = $_POST['site_id'];
				$document_root = $_POST['document_root'];
				$libs_dir = $_POST['libs_dir'];
		
				if($site_id_default == "1")$validate_siteid        = preg_match("/^([\w])+$/",$site_id);
				$validate_documentroot  = preg_match("/^([\w-_\/])+$/",$document_root);
				$validate_libs_dir       = preg_match("/^([\w-_\/])+$/",$libs_dir);
		
				if(($validate_siteid == 1 || $site_id_default == "1") && $validate_documentroot == 1 && ($validate_libs_dir == 1 && is_readable($libs_dir))){
	
					unset($_SESSION['error_siteid']);
					unset($_SESSION['error_absolutepath']);
					unset($_SESSION['error_documentroot']);
					unset($_SESSION['error_libs_dir']);
					unset($_SESSION['data_error']);
	
					$_SESSION['site_id'] = $site_id;
					$_SESSION['document_root'] = $document_root;
					$_SESSION['libs_dir'] = $libs_dir;
					
					require_once('install-header_template.php');
					require_once('install-ready_template.php');
				}else{
		
					$_SESSION['data_error'] = true;
					
					if($validate_siteid == 1){ $_SESSION['site_id'] = $site_id; unset($_SESSION['error_siteid']); }
					else $_SESSION['error_siteid'] = true;
					
					if($validate_absolute_path == 1){ $_SESSION['absolute_path'] = $dportal_absolute_path; unset($_SESSION['error_absolutepath']); }
					else $_SESSION['error_absolutepath'] = true;
					
					if($validate_documentroot == 1){ $_SESSION['documentroot'] = $document_root; unset($_SESSION['error_documentroot']); }
					else $_SESSION['error_documentroot'] = true;
					
					if($validate_libs_dir == 1){ $_SESSION['libs_dir'] = $libs_dir; unset($_SESSION['error_libs_dir']); }
					else $_SESSION['error_libs_dir'] = true;
		
					header('location: http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?step=path_conf');
					die();
				}
			}else{
					header('location: http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']);
					die();
			}
		}
	}
}elseif(isset($_GET['INSTALLED']) && $_SESSION['install_success']){
	$installed = true;
	require_once('install-header_template.php');
	require_once('install-success_template.php');
	unset($_SESSION['install_success']);
	session_destroy();
}else{
	$already_installed = true;

	require_once('install-header_template.php');
	require_once('install-error_template.php');
}
?>