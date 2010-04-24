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


/* :: Define the Paths as Constants.
 *
 * Here is defined the Paths to different directories as consants.
 * For portability reasons, you can place the sensible directories in another place
 * (/var/www/dportalcmd for public, '/var/local/dportalcms/' for Smarty Templates,
 * '/usr/lib/dportalcms' for functions, '/usr/lib/smarty' for Smarty class, etc).
 *
 * Originally, Paths are defined in the public directory, but I strongly recommended
 * to move sensible directories and place changes here. In Debian package,
 * directories was already moved to these directories.
 *
 */

// All should be SECURE forms to obtain Directory names
define('DPORTAL_ABSOLUTE_PATH',dirname(dirname(__FILE__))); // public_instalation (absolute)
define('DPORTAL_PATH',preg_replace("/^\/$/",'',dirname($_SERVER['PHP_SELF']))); // public access (relative)
define('DOCUMENT_ROOT',str_replace(DPORTAL_PATH,'',DPORTAL_ABSOLUTE_PATH)); // Document root (absolute)

// Absolute paths for Inclusion (remove ABSOLUTE_PATH to place another different paths).
define('CONFIG_PATH',DPORTAL_ABSOLUTE_PATH.'/config/');
define('LANG_PATH',DPORTAL_ABSOLUTE_PATH.'/lang/');
define('SMARTY_LIBRARIIES_PATH',DPORTAL_ABSOLUTE_PATH.'/libs/smarty/');
define('SMARTY_TEMPLATES_PATH',DPORTAL_ABSOLUTE_PATH.'/smarty/');
define('INCLUDES_PATH',DPORTAL_ABSOLUTE_PATH.'/includes/');
define('FUNCTIONS_PATH',DPORTAL_ABSOLUTE_PATH.'/includes/functions/');
define('UPDATES_PATH',DPORTAL_ABSOLUTE_PATH.'/updates/');
define('CONTENT_PATH',DPORTAL_ABSOLUTE_PATH.'/content/');
define('COMMENTS_PATH',DPORTAL_ABSOLUTE_PATH.'/comments/');
define('ENTRIES_PATH',DPORTAL_ABSOLUTE_PATH.'/entries/');
define('BACKUPS_PATH',DPORTAL_ABSOLUTE_PATH.'/content/');
define('IMAGES_PATH',DPORTAL_ABSOLUTE_PATH.'/images/');
define('GALLERY_PATH',DPORTAL_ABSOLUTE_PATH.'/images/gallery/');
define('VIDEOS_PATH',DPORTAL_ABSOLUTE_PATH.'/videos/');


// :: Revise if is installed. Elsewhere, redir to Installer.
if((!file_exists(CONFIG_PATH . "site.ini") && file_exists("install.php")) || file_exists("install.php")) header('location:install.php');


// :: Global configuration

// Regular Expressions (Regex) for general filtering
require_once(INCLUDES_PATH . "regular_expressions.php");

// Get the Functions in 'includes/functions' folder
if(is_dir(FUNCTIONS_PATH)){
	$functdir = opendir(FUNCTIONS_PATH);
	while (false !== ($file = readdir($functdir))) {
		if($file != "." && $file != ".." &&
		preg_match("/^[\w\.]*php$/",$file) > 0) require_once(FUNCTIONS_PATH . $file);
    }
}



// :: Libraries

// Smarty

// Include Smarty class (comment if already included in PHP). See README_SMARTY for details
require(SMARTY_LIBRARIIES_PATH . "Smarty.class.php");

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


// :: Set Configuration

// Gets the values in the 'config/site.ini' file
$conf = @parse_ini_file(CONFIG_PATH . 'site.ini') or die('Missing or inaccesible Configuration file!');
	
// Set the configuration
$sitename = $conf['sitename'];
$description = $conf['sitedesc'];
$phpbb_dir = $conf['phpbb_dir'];
$admin_user = $conf['user'];
$admin_password = $conf['password'];
$use_rewrite = $conf['use_rewrite'];
$smarty_debugging = $conf['smarty_debugging'];
$language = $conf['language'];
$timezone = $conf['timezone'];

// Get Language variales
if(is_file(LANG_PATH . "lang/$language.ini")) $LANG = parse_ini_file(LANG_PATH . "$language.ini") or die('Fatal error: Missing language file!');
else $LANG = parse_ini_file(LANG_PATH . "en.ini") or die('Fatal error: Missing language file!');

// Assign the General variables for Smarty
$smarty->assign('SITENAME',$sitename);
$smarty->assign('SITE_DESCRIPTION',$description);
$smarty->assign('PHPBB_DIR',$phpbb_dir);
$smarty->assign('LANG',$LANG);

$smarty->debugging = $smarty_debugging;
//$smarty->debugging = true;

// Set the Default Timezone (only available in PHP 5 >= 5.1.0)
@date_default_timezone_set ($timezone);


// :: External elements integration

// Use phpBB3 or the built-in function for administration
if(is_dir(DOCUMENT_ROOT . $phpbb_dir) && $phpbb_dir != null) require_once(INCLUDES_PATH . "phpbb3.php");
else require_once(INCLUDES_PATH . 'session_built-in.php');


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

// New function {fetch} with zlib support
$smarty->register_function('fetch2','fetch2');

?>
