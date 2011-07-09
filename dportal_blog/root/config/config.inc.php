<?php	

if(!defined('DPORTAL')) die();

//Site config file generated automatically. DO NOT EDIT!	
$sitename	= "DPortal CMS";
$sitedesc	= "DPortal CMS";
$admin_email	= "DavidKingNT@gmail.com";
$admin_nick	= "Davod el peresoso";
$phpbb_dir	= "";
$admin_user	= "92b362c6263dff2fcdad6a5ff661c7e8a0a1f966";
$admin_password	= "a89ae57ab36d7a83ee25d704b97303780e3e8520";
$language	= "";
$use_rewrite	= "1";
$smarty_debugging= "0";
$site_id = "default";
$cse_key = "";
$memcached_server = "localhost";
$memcached_port = "11211";

define("DPORTAL_ABSOLUTE_PATH","/home/.var/www/test"); // public_instalation (absolute!)
define("DPORTAL_PATH",preg_replace("/^\/$/","",dirname($_SERVER["PHP_SELF"]))); // public access (relative)
define("REAL_DOCUMENT_ROOT","/var/www/"); // Actual DocumentRoot (absolute!)
define("LIBS_PATH","/var/lib/dportalcms"); // Actual DocumentRoot (absolute!)

?>
