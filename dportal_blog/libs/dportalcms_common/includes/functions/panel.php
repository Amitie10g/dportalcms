<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Functions for Panel (panel.php)             #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU General Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

/* ABOUT THIS FUNCTION
 * 
 * The following function checks if the User and Password
 * is checked or not and return an INTEGER value.
 * 
 * 0: Unchanged
 * 1: Error. Current User and Password, or and data sended don't match
 * 2: Changed only Username
 * 3: Changed only Password
 * 4: Changed Username and Password
 *
 */
 
// int check_change_user_pass([string user, string password, string password_repeat)
function check_change_user_pass($curr_user = null, $curr_password = null, $new_user = null, $new_password = null, $new_password_repeat = null){

	global $admin_user,$admin_password;

	// If all data recived form Form are null, this means Unchanged and return 0
	if(empty($curr_user) && empty($curr_password) &&
	   empty($new_user) && empty($new_password) &&
	   empty($new_password_repeat )) return 0;

	// Assumes than $admin_user and $admin_password aren't NULL.
	// Then, $curr_user and $curr_password sould don't be NULL, too.
	if($admin_user == sha1($curr_user) && $admin_password == sha1($curr_password)){
		if(!empty($new_user) && empty($new_password) && empty($new_password_repeat)) return 2;
		elseif(empty($new_user) && !empty($new_password) && $new_password == $new_password_repeat) return 3;
		elseif(!empty($new_user) && !empty($new_password) && $new_password == $new_password_repeat) return 4;
		else return 1;
	}else return 1;
}

/* ABOUT THIS FUNCTION
 * 
 * This function Updates the site.ini file, that is the Configuration file for Site
 *
 */

// bool update_config()
function update_config($sitename,$site_desc,$email,$nick,$language,$robotstxt,$user,$password,$phpbb_dir = null,$cse_key=null,$use_rewrite = 0,$smarty_debugging = 0,$memcached_server,$memcached_port){

	global $site_id;
	$dportal_absolute_path = DPORTAL_ABSOLUTE_PATH;
	$document_root = REAL_DOCUMENT_ROOT;
	$libs_dir = LIBS_PATH;

	// Configure the output (using HEREDOC syntax)
	$output = <<<OUTPUT
\x3C\x3Fphp	

if(!defined('DPORTAL')) die();

//Site config file generated automatically. DO NOT EDIT!	
\x24sitename		= "$sitename";
\x24sitedesc		= "$site_desc";
\x24admin_email		= "$email";
\x24admin_nick		= "$nick";
\x24cse_key			= "$cse_key";
\x24admin_user		= "$user";
\x24admin_password	= "$password";
\x24language		= "$language";
\x24use_rewrite		= "$use_rewrite";
\x24smarty_debugging= "0";
\x24site_id 		= "$site_id";
\x24memcached_server= "$memcached_server";
\x24memcached_port	= "$memcached_port";

define("DPORTAL_ABSOLUTE_PATH","$dportal_absolute_path"); // public_instalation (absolute!)
define("DPORTAL_PATH",preg_replace("/^\/\x24/","",dirname(\x24_SERVER["PHP_SELF"]))); // public access (relative)
define("REAL_DOCUMENT_ROOT","$document_root"); // Actual DocumentRoot (absolute!)
define("LIBS_PATH","$libs_dir"); // Actual DocumentRoot (absolute!)

\x3F\x3E

OUTPUT;

	if(!is_writable('config/config.inc.php')) die("The Config file does not exists or don't have permissionf of write!");
	$written = file_put_contents('config/config.inc.php',$output,LOCK_EX);	
	// Recommended settings to add 'deny *.php' for Search Engines, but may cause problems.
	if(empty($use_rewrite) && strpos($robotstxt,'disallow *.php') == 0) $robotstxt = str_replace("disallow *.php\n",'',$robotstxt); 
	elseif(!empty($use_rewrite) && strpos($robotstxt,'disallow *.php') == 0) $robotstxt .= "\ndisallow *.php\n";

	if(!is_writable(DPORTAL_ABSOLUTE_PATH.'/robots.txt')) die("The robots.txt file does not exists or don't have permissionf of write!");
	$robotstxt_written = file_put_contents(DPORTAL_ABSOLUTE_PATH.'/robots.txt',$robotstxt,LOCK_EX);	

	if($written !== false && $robotstxt_written !== false) return true;
}


/* ABOUT THIS FUNCTION
 * 
 * This function get the List of Templates in order to be displayed in Manual Templates edition
 *
 */

// bool get_templates(void)
function get_templates(){

	$dir = opendir(SMARTY_TEMPLATES_PATH.'/templates');
	while ($name = readdir($dir)) {	
		if(preg_match("/^([\w]*)\.tpl$/",$name) && $name != 'panel.tpl') $templates[] = array('name'=>$name,'filename'=>SMARTY_TEMPLATES_PATH.'/templates'.$name);
	}
	closedir($dir);
 
 	sort($templates);
    return $templates;
}

/* ABOUT THIS FUNCTION
 * 
 * This function save the Template edited
 *
 */

// bool template_save(string name, string content
function template_save($name,$content){

	$filename = SMARTY_TEMPLATES_PATH."templates/$name";

	if(is_readable($filename) && is_file($filename) && strpos($name,'panel_') === false) $saved = file_put_contents(SMARTY_TEMPLATES_PATH."templates/$name",$content,LOCK_EX);
	else return false;
	
	return $saved;

}

/* ABOUT THIS FUNCTION
 *
 * backup() function performs a Backup,  by passing an Array with modes,
 * and output them to a ZIP file.
 *
 * Parameters:
 *
 *	* array mode
 *	   An Array with the modes (see bellow).
 *
 * Returned values:
 *
 *	This function will return TRUE if the Backup file has been created successfully,
 *	or FALSE in case of error.
 *
 * Observations:
 *
 *	In order to create the ZIP file, you must install ZIP form PECL.
 *
 *	The Array is passed as following:
 *	The page contains a form with an array of keys with defined values. Then, these
 *	Array is passed to the Script and the Function.
 *
 *	Array is Associative, with the values of keys are Boolean.
 *
 *	Keys defined are:
 *
 *		array(mode)=>
 *		+blog=>true/false
 *		+book=>true/false
 *		+templates=>true/false
 *		+config=>true/false
 *
 *	If no Array is given, this function will perform a Backup with Entries by default.
 *
 */

// bool backup_content([array mode])
function backup(array $mode = null){

	global $sitename;
	global $site_id;
	$date = time();

	if(!empty($mode)){
		$comments	= $mode['comments'];
		$templates	= $mode['templates'];
		$config		= $mode['config'];
	}
	
	if(class_exists('ZipArchive')){

		// The Zip comment in the output archiver.

		$zip_comment = "== DPortal CMS backup file ==\n\n";
		$zip_comment.= "Sitename:\t$sitename\n";
		$zip_comment.= "URL:\t\thttp://" . $_SERVER['SERVER_NAME'] . DPORTAL_PATH . "\n";
		$zip_comment.= "Created:\t" . date("m/d/Y H:i",$date) . "\n\n";
		$zip_comment.= "This backup includes:\n\n";
		$zip_comment.= "\t* Blog entries (by default).\n";
		if($comments) $zip_comment.= "\t* Comments.\n"; 
		if($templates) $zip_comment.= "\t* Templates.\n"; 
		if($config) $zip_comment.= "\t* Configuration file ('site.ini').\n\n";
		$zip_comment.= "This is a Backup of your Blog. Contain the\nfolders of contents and configuration.\n\n";
		$zip_comment.= "If you need to Restore this Backup, use the\n";
		$zip_comment.= "Control panel for them, or upload the contents\ndirectly to the root of your Portal.\n\n";
		$zip_comment.= "Please don't modify the contents unless you know doing.\n";

		// Initialize the ZipArchive Class
		$zip = new ZipArchive;
		if($archive = $zip->open(BACKUPS_PATH . '/backup_' . date("d-m-Y_H-i",$date) . '.zip' , ZipArchive::CREATE) !== false){

			$zip->setArchiveComment($zip_comment);

			// Entries (default)
			if(is_dir(ENTRIES_PATH) && is_readable(ENTRIES_PATH)){
				if(($dh1 = opendir(ENTRIES_PATH)) !== false){
					while (($file = readdir($dh1)) !== false) {
						if(nofakedir($file)) $zip->addFile(ENTRIES_PATH . $file, "entries/$file");
					}
					closedir($dh1);
				}
			}
			
			if(is_dir(COMMENTS_PATH) && is_readable(COMMENTS_PATH) && $comments){
				if(($dh2 = opendir(COMMENTS_PATH)) !== false){
					while (($file = readdir($dh2)) !== false) {
						if(nofakedir($file)) $zip->addFile(COMMENTS_PATH . $file, "comments/$file");
					}
					closedir($dh2);
				}
			}

			// Templates mode
			if(is_dir(SMARTY_TEMPLATES_PATH.'templates/') && is_readable(SMARTY_TEMPLATES_PATH.'templates/') && $templates){
				if(($dh3 = opendir(SMARTY_TEMPLATES_PATH.'templates/')) !== false){
					while (($file = readdir($dh3)) !== false) {
						if(nofakedir($file) && preg_match("/^[\w]+\.tpl$/",$file)) $zip->addFile(SMARTY_TEMPLATES_PATH."templates/$file", "templates/$file");
					}
					closedir($dh3);
				}
			}

			// Config mode
			if($config){
				$zip->addFile(DPORTAL_ABSOLUTE_PATH . '/config/config.inc.php', 'config/config.inc.php');
			}

			$zip->addFromString('site_id',$site_id);

			// Put your own Mode here
	
			$zip->close();

			return true;

		}else return false;

	// If ZIP does not exist, us GZ instead (currently not implemented)	
	}else die('ZIP extension does not exist. Please install zip via PECL.');
}

// array get_backup(void)
function get_backup(){

	$path = BACKUPS_PATH;
	$dh = opendir($path);
	if ($dh) {
		while (($file = readdir($dh)) !== false) {
			if(nofakedir($file)) $list[] = $file;
		}
	}

	if(!empty($list)) rsort($list);

	return $list;
}

// void delete_backups([bool no_last_file])
function delete_backups($no_last = false){

	$dir = BACKUPS_PATH;
	$files = get_backup();

	foreach($files as $key => $value){
		if(($no_last && $key != 0)||!$no_last) unlink($dir.$value);
	}
}

// string get_pannel_message(void)
function get_panel_message(){

	$params = null;

	global $LANG;

	if($_SESSION['UPDATED']){
		$message = $LANG['configuration_updated_success'];

	}elseif($_SESSION['UPDATED']){
		$message = $LANG['configuration_updated_success']."!";

	}elseif($_SESSION['TEMPLATE_UPDATED']){
		$message = $LANG['templates_updated']."!";
	
	}elseif($_SESSION['CLEANED']){
		$message = $LANG['smarty_cache_cleaned']."!";	
			
	}elseif($_SESSION['ERROR']){
		$message = $LANG['update_error'];

	}elseif($_SESSION['CREATED_ERROR']){
		$message = $LANG['created_errors'];		

	}elseif($_SESSION['FILE_EXISTS']){
		$message = $LANG['section_exist'];		

	}elseif($_SESSION['PASSWORDS_NO_MATCH']){
		$message = $LANG['passwords_no_match'];

	}elseif($_SESSION['BACKED_UP']){
		$message = $LANG['backed_up'];

	}elseif($_SESSION['NOT_BACKED_UP']){
		$message = $LANG['not_backed_up'];

	}elseif($_SESSION['RESTORED']){
		$message = $LANG['restored'];

	}elseif($_SESSION['RESTORE_ERROR']){
		$message = $LANG['restore_error'];

	}elseif($_SESSION['BACKUPS_DELETED']){
		$message = $LANG['backups_deleted'];
	
	}elseif($_SESSION['TEMPLATE_NOT_EXIST']){
		$message = $LANG['template_not_exist'];
	
	}elseif($_SESSION['STYLE_UPDATED']){
		$message = $LANG['style_updated'];

	}elseif($_SESSION['STYLE_NOT_UPDATED']){
		$message = $LANG['style_not_updated'];

	}else $mesagge = false;
	
	return $message;
}


function get_lang_files(){

	foreach(glob(LANG_PATH.'*.ini') as $langfile){
	
		$lang_content = parse_ini_file($langfile);
		$lang_fullname = $lang_content['lang_fullname'];
		$lang_name = $lang_content['lang_name'];
		
		$langvars[] = array('key'=>$lang_name,'str'=>$lang_fullname);
	}
	return $langvars;
}

// bool update_style(array style)
function update_style($style){
	if(!is_array($style) && empty($style)) return false;
	
	global $array_zero_to_five;
	global $array_zero_to_twenty;
	
	// Types:
	// Color: Use Color selector in Style editor
	// BG: Options for Background (color and URL)
	// Size: Used for Combobox. Parameters are the numbers, between, or fixed values. Used for font-size, margin and padding
	// Border: Options for Border. Parameters are borde size (0-5), color and Type (solid, dotted, inset, etc)
	// Text: Used for fixed values (as width)
	// Width: Input text for numbers in px
	// Font family: Options for common Font-family used: parameters may be Arial, Verdana, Monospaced, etc
	// Float: For float. Values are left and right
	
	// HEREDOC syntax!
	$output = <<<OUTPUT
\x3C\x3Fphp

\x24style_list['body_background'] = array('value'=>array('color'=>'$style[body_background_color]','url'=>'$style[body_background_url]','params'=>'$style[body_background_params]'),'type'=>'bg');
\x24style_list['body_font_color'] = array('value'=>'$style[body_font_color]','type'=>'color');
\x24style_list['body_font_family'] = array('value'=>'$style[body_font_family]','type'=>'font');
\x24style_list['body_font_size'] = array('value'=>'$style[body_font_size]','type'=>'size','parameters'=>get_array_number_between(8,14));
\x24style_list['body_padding'] = array('value'=>'$style[body_padding]','type'=>'size','parameters'=>get_array_number_between(0,50),'separator'=>true);

\x24style_list['banner_background'] = array('value'=>array('color'=>'$style[banner_background_color]','url'=>'$style[banner_background_url]','params'=>'$style[banner_background_params]'),'type'=>'bg');
\x24style_list['banner_border'] = array('value'=>array('color'=>'$style[banner_border_color]','size'=>'$style[banner_border_size]','type'=>'$style[banner_border_type]'),'type'=>'border','parameters'=>get_array_number_between(0,5));
\x24style_list['_banner_border'] = array('value'=>array('color'=>'$style[_banner_border_color]','size'=>'$style[_banner_border_size]','type'=>'$style[_banner_border_type]'),'type'=>'border','parameters'=>get_array_number_between(0,5));
\x24style_list['_banner_margin'] = array('value'=>'$style[_banner_margin]','type'=>'size','parameters'=>get_array_number_between(0,20));
\x24style_list['banner_width'] = array('value'=>array('width'=>'$style[banner_width_width]','mode'=>'$style[banner_width_mode]'),'type'=>'width');
\x24style_list['_banner_width'] = array('value'=>array('width'=>'$style[_banner_width_width]','mode'=>'$style[_banner_width_mode]'),'type'=>'width','separator'=>true);

\x24style_list['container_background'] = array('value'=>array('color'=>'$style[container_background_color]','url'=>'$style[container_background_url]','params'=>'$style[container_background_params]'),'type'=>'bg');
\x24style_list['container_border'] = array('value'=>array('color'=>'$style[container_border_color]','size'=>'$style[container_border_size]','type'=>'$style[container_border_type]'),'type'=>'border','parameters'=>get_array_number_between(0,5));
\x24style_list['container_margin'] = array('value'=>'$style[container_margin]','type'=>'size','parameters'=>get_array_number_between(0,20));
\x24style_list['container_padding'] = array('value'=>'$style[container_padding]','type'=>'size','parameters'=>get_array_number_between(0,5));
\x24style_list['container_width'] = array('value'=>array('width'=>'$style[container_width_width]','mode'=>'$style[container_width_mode]'),'type'=>'width','separator'=>true);

\x24style_list['content_background'] = array('value'=>array('color'=>'$style[content_background_url]','url'=>'$style[content_background_url]','params'=>'$style[content_background_params]'),'type'=>'bg');
\x24style_list['content_border'] = array('value'=>array('color'=>'$style[content_border_color]','size'=>'$style[content_border_size]','type'=>'$style[content_border_type]'),'type'=>'border','parameters'=>get_array_number_between(0,5));
\x24style_list['content_font_color'] = array('value'=>'$style[content_font_color]','type'=>'color');
\x24style_list['content_font_size'] = array('value'=>'$style[content_font_size]','type'=>'size','parameters'=>get_array_number_between(8,14));
\x24style_list['content_margin'] = array('value'=>'$style[content_margin]','type'=>'size','parameters'=>get_array_number_between(0,5));
\x24style_list['content_padding'] = array('value'=>'$style[content_padding]','type'=>'size','parameters'=>get_array_number_between(0,5),'separator'=>true);

\x24style_list['sidebar_border'] = array('value'=>array('color'=>'$style[sidebar_border_color]','size'=>'$style[sidebar_border_size]','type'=>'$style[sidebar_border_type]'),'type'=>'border','parameters'=>get_array_number_between(0,5));
\x24style_list['sidebar_width'] = array('value'=>array('width'=>'$style[sidebar_width_width]','mode'=>'$style[sidebar_width_mode]'),'type'=>'width');
\x24style_list['sidebar_background'] = array('value'=>'$style[sidebar_backgorund]','type'=>'bg');
\x24style_list['sidebar_float'] = array('value'=>'$style[sidebar_float]','type'=>'float');
\x24style_list['sidebar_font_size'] = array('value'=>'$style[sidebar_font_size]','type'=>'size','parameters'=>get_array_number_between(8,14));
\x24style_list['search_control_backgorund'] = array('value'=>'$style[search_control_backgorund]','type'=>'bg','separator'=>true);

\x24style_list['footer_background'] = array('value'=>array('color'=>'$style[footer_background_color]','url'=>'$style[footer_background_url]','params'=>'$style[footer_background_params]'),'type'=>'bg');
\x24style_list['footer_border'] = array('value'=>array('color'=>'$style[footer_border_color]','size'=>'$style[footer_border_size]','type'=>'$style[footer_border_type]'),'type'=>'border','parameters'=>get_array_number_between(0,5));
\x24style_list['footer_margin'] = array('value'=>'$style[footer_margin]','type'=>'size','parameters'=>get_array_number_between(0,20));
\x24style_list['footer_padding'] = array('value'=>'$style[footer_padding]','type'=>'size','parameters'=>get_array_number_between(0,5),'separator'=>true);

\x24style_list['a_hover_color'] = array('value'=>'$style[a_hover_color]','type'=>'color');
\x24style_list['a_link_color'] = array('value'=>'$style[a_link_color]','type'=>'color');
\x24style_list['a_visited_color'] = array('value'=>'$style[a_visited_color]','type'=>'color','separator'=>true);

\x24style_list['h1_font_size'] = array('value'=>'$style[h1_font_size]','type'=>'size','parameters'=>get_array_number_between(14,20));
\x24style_list['h2_font_size'] = array('value'=>'$style[h2_font_size]','type'=>'size','parameters'=>get_array_number_between(13,18));
\x24style_list['h3_font_size'] = array('value'=>'$style[h3_font_size]','type'=>'size','parameters'=>get_array_number_between(12,16),'separator'=>true);
\x24style_list['h5_titre_background'] = array('value'=>array('color'=>'$style[h5_titre_backgorund_color]','url'=>'$style[h5_titre_backgorund_url]','params'=>'$style[h5_titre_backgorund_params]'),'type'=>'bg');
\x24style_list['h5_titre_font_size'] = array('value'=>'$style[h5_titre_font_size]','type'=>'size','parameters'=>get_array_number_between(8,14));
\x24style_list['h5_titre_font_family'] = array('value'=>'$style[h5_titre_font_family]','type'=>'font','parameters'=>'Verdana, Arial, sans-serif');
\x24style_list['h5_titre_font_color'] = array('value'=>'$style[h5_titre_font_color]','type'=>'color');


\x3F\x3E
	
OUTPUT;

	if(file_put_contents(DPORTAL_ABSOLUTE_PATH . '/config/style_cfg.php',$output,LOCK_EX) !== false) return true;
	else return false;

}

?>
