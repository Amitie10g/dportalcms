<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Confiration Script (config.php)             #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

if(!defined('DPORTAL')) die();

// For timing/benchmark debug purposes only
$timea = microtime(true);

// Starts the Session
//session_set_cookie_params(1800); // Enable if you want to use them
session_name('DPORTALID');
session_start();

error_reporting(E_ALL ^E_NOTICE);

// Include the Constants file
require_once('config/constants.php');


// :: Revise if is installed. Elsewhere, redir to Installer.
if(!file_exists(CONFIG_PATH . "site.ini") && file_exists("install.php")) header('location:install.php');
elseif(file_exists(CONFIG_PATH . "site.ini") && file_exists("install.php")) die("Please delete 'install.php' before continue");


// :: Global configuration

// Regular Expressions (Regex) for general filtering
require_once(INCLUDES_PATH . "regular_expressions.php");

// Get the Functions in 'includes/functions' folder
if(is_dir(FUNCTIONS_PATH) && is_readable(FUNCTIONS_PATH)){
	$functdir = opendir(FUNCTIONS_PATH);
	while (false !== ($file = readdir($functdir))) {
		if($file != "." && $file != ".." &&
		preg_match("/^[\w\.]*php$/",$file) > 0) require_once(FUNCTIONS_PATH . $file);
    }
}


// :: Set Configuration

// Gets the values in the 'config/site.ini' file
$conf = @parse_ini_file(CONFIG_PATH . 'site.ini') or die('Missing or inaccesible Configuration file!');
	
// Set the configuration
$sitename = $conf['sitename']; // String
$description = $conf['sitedesc']; // String
$phpbb_dir = $conf['phpbb_dir']; // String
$admin_user = $conf['user']; // String
$admin_password = $conf['password']; // String
$admin_nick = $conf['admin_nick']; // String
$admin_email = $conf['admin_email']; // String
$use_rewrite = $conf['use_rewrite']; // bool
$smarty_debugging = $conf['smarty_debugging']; // Bool
$language = $conf['language']; // String
$timezone = $conf['timezone']; // Mixed

if(empty($admin_nick)) $admin_nick = $admin_user;

define('SITENAME',$sitename);
define('DESCRIPTION',$description);
define('ADMIN_NICK',$admin_nick);
define('ADMIN_EMAIL',$admin_email);
if(!empty($phpbb_dir)) define('PHPBB_DIR',$phpbb_dir);


// Get Language variales
if(is_file(LANG_PATH . "$language.ini")) $LANG = parse_ini_file(LANG_PATH . "$language.ini") or die('Fatal error: Missing language file!');
else $LANG = parse_ini_file(LANG_PATH . "en.ini") or die('Fatal error: Missing language file!');

// Set the Default Timezone (only available in PHP 5 >= 5.1.0)
@date_default_timezone_set ($timezone);

// Get the Browser capabilities with an updated 'browscap.ini' file placed in '/includes/'
if(ini_set('browscap',INCLUDES_PATH.'browscap.ini') !== false) $get_browser = get_browser(null,true);


// :: Use THE open_basedir directive with ini_set(), to increment the security

ini_set('open_basedir',DPORTAL_ABSOLUTE_PATH.'/'.PATH_SEPARATOR.CONFIG_PATH.PATH_SEPARATOR.
	LANG_PATH.PATH_SEPARATOR.SMARTY_LIBRARIES_PATH.PATH_SEPARATOR.FPDF_PATH.PATH_SEPARATOR.
	SMARTY_TEMPLATES_PATH.PATH_SEPARATOR.INCLUDES_PATH.PATH_SEPARATOR.UPDATES_PATH.
	PATH_SEPARATOR.CONTENT_PATH.PATH_SEPARATOR.PATH_SEPARATOR.COMMENTS_PATH.
	PATH_SEPARATOR.ENTRIES_PATH.PATH_SEPARATOR.BACKUPS_PATH.PATH_SEPARATOR.IMAGES_PATH.
	PATH_SEPARATOR.GALLERY_PATH.PATH_SEPARATOR.VIDEOS_PATH.PATH_SEPARATOR.REAL_DOCUMENT_ROOT.$phpbb_dir);


// :: Libraries

// Smarty

// Include Smarty class (comment if already included in PHP). See README_SMARTY for details
require(SMARTY_LIBRARIES_PATH . "Smarty.class.php");

// Declaring an new isntance of Smarty
$smarty = new Smarty();

// Configuration of directories for the Smarty templates, cache and compiled templates.
$smarty->template_dir = SMARTY_TEMPLATES_PATH . "templates/";
$smarty->compile_dir = SMARTY_TEMPLATES_PATH . "templates_c";
$smarty->cache_dir = SMARTY_TEMPLATES_PATH . "cache";
$smarty->config_dir = SMARTY_TEMPLATES_PATH . "configs";

// Smarty delimiters (double bracers instead of single them; see RERADME_SMARTY!). 
$smarty->left_delimiter = '{{';
$smarty->right_delimiter = '}}';

// Assign the General variables for Smarty
$smarty->assign('SITENAME',$sitename);
$smarty->assign('SITE_DESCRIPTION',$description);
$smarty->assign('PHPBB_DIR',$phpbb_dir);
$smarty->assign('LANG',$LANG);
$smarty->assign('USE_REWRITE',$use_rewrite);
$smarty->assign('ADMIN_NICK',$admin_nick);
$smarty->assign('ADMIN_EMAIL',$admin_email);

// Enable Debugging only for Administrator 
if($user_admin) $smarty->debugging = $smarty_debugging;
$smarty->debugging = false;


// FPDF
if(is_file(INCLUDES_PATH . "html2fpdf.php")){
	require_once(INCLUDES_PATH . "html2fpdf.php");
	$pdf = new HTML2FPDF;
}


// :: Cache handler function

// Here you can configure the Cache handler. Yoy may compress Cache on Files or create your
// own function for caching in "includes/smarty_cache_handler_custom.php" to extend them.
//
// In $cache_method variable you can configure your preferred method. Alternatives are:
// 
//  * gz (zlib)
//  * bzip2 (problems)
//  * lzf (not tested)
//  * lzma (not available)
//  * db (you may create this function using Smarty documentation)
//  * none disable the Caching.
//
// Then, the result name is checked using is_callable() in order to call correctly the
// Handler function if is callable. If not, default cache handler function will be used.
//
// Put 'none' to disable the Caching.
//

if(is_file(INCLUDES_PATH.'smarty_cache_handler_custom_functions.php')){
	require_once(INCLUDES_PATH.'smarty_cache_handler_custom_functions.php');
	if(empty($cache_method)) $cache_method = 'none';
	if(is_callable('cache_handler_'.$cache_method)) $smarty->cache_handler_func = 'cache_handler_'.$cache_method;
}

// :: External elements

// Use phpBB3 or the built-in function for administration
if(@is_dir(REAL_DOCUMENT_ROOT . $phpbb_dir) && !empty($phpbb_dir)) require_once(INCLUDES_PATH . "phpbb3.php");
else require_once(INCLUDES_PATH . 'session_built-in.php');

// :: Other variables

// Enable Smarty Debugging only for Administrator 
if($user_admin) $smarty->debugging = $smarty_debugging;
$smarty->debugging = false;

// Get Language variales (after phpBB!!!)
if(is_file(LANG_PATH . "$language.ini")) $LANG = parse_ini_file(LANG_PATH . "$language.ini") or die('Fatal error: Missing language file!');
else $LANG = parse_ini_file(LANG_PATH . "en.ini") or die('Fatal error: Missing language file!');

// Assign the General variables for Smarty
$smarty->assign('SITENAME',$sitename);
$smarty->assign('SITE_DESCRIPTION',$description);
$smarty->assign('PHPBB_DIR',$phpbb_dir);
$smarty->assign('LANG',$LANG);
$smarty->assign('USE_REWRITE',$use_rewrite);
$smarty->assign('USER_LANG',$language);
$smarty->assign('USER_LANG_STRING',$LANG['book_lang_'.$language]);

// :: Registering Functions for Smarty

// Registering a Smarty function for create portable links
$smarty->register_function('LINK','link_url');

// Custom Modifier to Uppercase the first character of a String
// (this modifier is not included in Smarty, but is really REALLY usefull)
$smarty->register_modifier('ucfirst','auto_ucfirst');

//$smarty->register_modifier('htmlentities','htmlentities');

// Custom modifier to get the Author name using the function get_user_by_id
$smarty->register_function('get_user','get_user');

// Custom modifier to get the License using the function get_license
$smarty->register_function('get_license','get_license');

// Dynamic Block for templates where Caching is enabled
$smarty->register_block('DYNAMIC', 'dynamic',false);

// CallAjax Javascript function for body tag
$smarty->register_function('CALLAJAX','callajax_body');

// PopUp
$smarty->register_function('POPUP','popup_message',false);

// Blog message
$smarty->register_function('BLOG_MESSAGE','blog_message',false);

// New Smarty function {fetch2} with zlib support
$smarty->register_function('fetch2','fetch2');

// bzdecompress
$smarty->register_function('bzdecompress','bzdecompress');


// :: Retrive the User data from Session or Cookie

if(empty($_COOKIE['NICK']) && !empty($_SESSION['NICK'])) $saved_nick = $_SESSION['NICK'];
elseif(!empty($_COOKIE['NICK'])) $saved_nick = $_COOKIE['NICK'];

if(empty($_COOKIE['EMAIL']) && !empty($_SESSION['EMAIL'])) $saved_email = $_SESSION['EMAIL'];
elseif(!empty($_COOKIE['EMAIL'])) $saved_email = $_COOKIE['EMAIL'];

if(empty($_COOKIE['WEBSITE']) && !empty($_SESSION['WEBSITE'])) $saved_website = $_SESSION['WEBSITE'];
elseif(!empty($_COOKIE['WEBSITE'])) $saved_website = $_COOKIE['WEBSITE'];

$smarty->assign('SAVED_NICK',$saved_nick);
$smarty->assign('SAVED_EMAIL',$saved_email);
$smarty->assign('SAVED_WEBSITE',$saved_website);

// :: Other configurations

// Set the mb_internal_encoding() to UTF-8 for multibyte functions
mb_internal_encoding('UTF-8');
?>
