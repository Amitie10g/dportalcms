<?php	

if(!defined('DPORTAL')) die();

//Site config file generated automatically. DO NOT EDIT!	
$sitename	= "DPortal CMS developement site";
$sitedesc	= "CMS without Database Engine";
$admin_email	= "DavidKingNT@gmail.com";
$admin_nick	= "Davod";
$phpbb_dir	= "/forum/";
$admin_user	= "92b362c6263dff2fcdad6a5ff661c7e8a0a1f966";
$admin_password	= "a89ae57ab36d7a83ee25d704b97303780e3e8520";
$language	= "";
$use_rewrite	= "1";
$smarty_debugging= "0";
$site_id = "00d7293d487dd29ce22771367f23a91e41acf490";
$memcached_server = "";
$memcached_port = "";

define("DPORTAL_ABSOLUTE_PATH","/home/dportalc/public_html/"); // public_instalation (absolute!)
define("DPORTAL_PATH",preg_replace("/^\/$/","",dirname($_SERVER["PHP_SELF"]))); // public access (relative)
define("REAL_DOCUMENT_ROOT","/home/dportalc/public_html/"); // Actual DocumentRoot (absolute!)
define("LIBS_PATH","/home/dportalc/.libs/"); // Actual DocumentRoot (absolute!)

?>
