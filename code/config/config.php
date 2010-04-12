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

// :: Revise if is installed. Elsewhere, redir to Installer.
if((!file_exists("config/site.ini") && file_exists("install.php")) || file_exists("install.php")) header('location:install.php');

// Include the Constants, including paths. Don't remove!!!
require_once('includes/constants.php');

// :: Global configuration

// Regular Expressions (Regex) for general filtering
require_once('includes/regular_expressions.php');

// Get the Functions in 'includes/functions' folder
if(is_dir(FUNCTIONS_PATH)){
	$functdir = opendir(FUNCTIONS_PATH);
	while (false !== ($file = readdir($functdir))) {
		if($file != "." && $file != ".." &&
		preg_match("/^[\w\.]*php$/",$file) > 0) require_once(FUNCTIONS_PATH.$file);
    }
}

// Set the Default Timezone
date_default_timezone_set ("America/Santiago");

// :: Libraries

// Smarty

// Smarty configuration. See README_SMARTY for details
require(SMARTY_DIR."Smarty.class.php");

// Declaring an new isntance of Smarty
$smarty = new Smarty();

// Configuration of directories (relative to the DOCUMENT_ROOT).
$smarty->template_dir = "smarty/templates/";
$smarty->compile_dir = 'smarty/templates_c';
$smarty->cache_dir = 'smarty/cache';
$smarty->config_dir = 'smarty/configs';

// Smarty delimiters (double bracers instead of single them). 
$smarty->left_delimiter = '{{';
$smarty->right_delimiter = '}}';


// :: Set Configuration

// Gets the values in the 'config/site.ini' file
$conf = @parse_ini_file(CONFIG_PATH.'site.ini') or die('Missing or inaccesible Configuration file!');
	
// Set the configuration
$sitename = $conf['sitename'];
$description = $conf['sitedesc'];
$phpbb_dir = $conf['phpbb_dir'];
$admin_user = $conf['user'];
$admin_password = $conf['password'];
$use_rewrite = $conf['use_rewrite'];
$smarty_debugging = $conf['smarty_debugging'];
$language = $conf['language'];

// Get Language variales
if(is_file(DPORTAL_ABSOLUTE_PATH."lang/$language.ini")) $LANG = parse_ini_file(DPORTAL_ABSOLUTE_PATH."lang/$language.ini") or die('Missing language file!');
else $LANG = parse_ini_file(DPORTAL_ABSOLUTE_PATH."/lang/en.ini") or die('missing language file!');

// Assign the General variables for Smarty
$smarty->assign('SITENAME',$sitename);
$smarty->assign('SITE_DESCRIPTION',$description);
$smarty->assign('PHPBB_DIR',$phpbb_dir);
$smarty->assign('LANG',$LANG);

$smarty->debugging = $smarty_debugging;


// :: External elements integration

// Use phpBB3 or the built-in function for administration
if(is_dir(DOCUMENT_ROOT.$phpbb_dir) && $phpbb_dir != null) require_once("includes/phpbb3.php");
else require_once(INCLUDES_PATH.'session_built-in.php');


// :: Registering Functions for Smarty

// Registering a Smarty function for create portable links
$smarty->register_function('LINK','link_url');

// Custom Modifier to Uppercase the first character of a String
// (this modifier is not available in Smarty, but is really REALLY usefull)
$smarty->register_modifier('ucfirst','ucfirst');

// Dynamic Block for templates where Caching is enabled
$smarty->register_block('DYNAMIC', 'dynamic',false);

// CallAjax Javascript fnction for body tag
$smarty->register_function('CALLAJAX','callajax_body');

// PopUp
$smarty->register_function('POPUP','popup_message',false);

// Blog message
$smarty->register_function('BLOG_MESSAGE','blog_message',false);

?>
