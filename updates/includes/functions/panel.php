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
function update_config($sitename,$site_desc,$email,$nick,$language,$robotstxt,$user,$password,$phpbb_dir = null,$use_rewrite = 0,$smarty_debugging = 0){

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
smarty_debugging= $smarty_debugging

OUTPUT;

	if(!is_writable(DPORTAL_ABSOLUTE_PATH.'/config/site.ini')) die("The Config file does not exists or don't have permissionf of write!");
	$written = file_put_contents(DPORTAL_ABSOLUTE_PATH.'/config/site.ini',$output,LOCK_EX);	

	// Recommended settings to add 'deny *.php' for Search Engines, but may cause problems.
	//if(empty($use_rewrite) && strpos('deny *.php',$robotstxt) == 0) $robotstxt = str_replace("deny *.php\n",'',$robotstxt);
	//elseif(!empty($use_rewrite) && strpos('deny *.php',$robotstxt) == 0) $robotstxt .= "\ndeny *.php\n";

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

	$dir = opendir("smarty/templates");
	while ($name = readdir($dir)) {	
		if(preg_match("/^([\w]*)\.tpl$/",$name) && $name != 'panel.tpl') $templates[] = array('name'=>$name,'filename'=>'smarty/templates/'.$name);
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

	$file = fopen("smarty/templates/$name",'wb');
	if(fwrite($file,$content)) $saved = true;
	fclose($file);
	
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
 *	If no Array is given, this function will perform a Backup with Sections by default.
 *
 */

// bool backup_content([array mode])
function backup(array $mode = null){

	global $sitename;
	$date = time();

	if(!empty($mode)){
		$blog = $mode['blog'];
		$book = $mode['book'];
		$templates = $mode['templates'];
		$config = $mode['config'];
	}
	
	if(class_exists('ZipArchive')){

		// The Zip comment in the output archiver.

		$zip_comment = "== DPortal CMS backup file ==\n\n";
		$zip_comment.= "Sitename:\t$sitename\n";
		$zip_comment.= "URL:\t\thttp://" . $_SERVER['SERVER_NAME'] . DPORTAL_PATH . "\n";
		$zip_comment.= "Created:\t" . date("m/d/Y H:i",$date) . "\n\n";
		$zip_comment.= "This backup includes:\n\n";
		$zip_comment.= "\t* Sections (by default).\n";
		if($blog) $zip_comment.= "\t* Blog (entries and comments).\n";
		if($book) $zip_comment.= "\t* Book (stories, chapters and comments).\n";
		if($templates) $zip_comment.= "\t* Templates.\n"; 
		if($config) $zip_comment.= "\t* Configuration file ('site.ini').\n\n";
		$zip_comment.= "This is a Backup of your Portal. Contain the\nfolders of contents and configuration.\n\n";
		$zip_comment.= "If you need to Restore this Backup, use the\nControl panel for them, or upload the contents\ndirectly to the root of your Portal.\n\n";
		$zip_comment.= "Please don't modify the contents unless you know doing.\n";

		// Initialize the ZipArchive Class
		$zip = new ZipArchive;
		$archive = $zip->open('backups/backup_' . date("d-m-Y_H-i",$date) . '.zip' , ZipArchive::CREATE) or die('Error opening or creating file!');

		if($archive){

			$zip->setArchiveComment($zip_comment);

			// Default mode: Backup Sections
			if(is_dir(CONTENT_PATH)){
				if($dh1 = opendir(CONTENT_PATH)){
					while (($file = readdir($dh1)) !== false) {
						if(nofakedir($file)) $zip->addFile(CONTENT_PATH . $file, basename(CONTENT_PATH) .'/'. $file);
					}
					closedir($dh1);
				}	
			}

			// Blog mode
			if(is_dir(ENTRIES_PATH) && is_dir(COMMENTS_PATH) && $blog){
				if($dh2 = opendir(COMMENTS_PATH)){
					while (($file = readdir($dh2)) !== false) {
						if(nofakedir($file)) $zip->addFile(COMMENTS_PATH . $file, basename(COMMENTS_PATH) .'/'. $file);
					}
					closedir($dh2);
				}
			
				if($dh3 = opendir(ENTRIES_PATH)){
					while (($file = readdir($dh3)) !== false) {
						if(nofakedir($file)) $zip->addFile(ENTRIES_PATH . $file, basename(ENTRIES_PATH) .'/'. $file);
					}
					closedir($dh3);
				}
			}

			// Templates mode
			if(is_dir(BOOKS_PATH) && $book){
				if($dh4 = opendir(BOOKS_PATH)){
					while (($file = readdir($dh4)) !== false) {
						if(nofakedir($file)) $zip->addFile(BOOKS_PATH . $file, basename(BOOKS_PATH) .'/'. $file);
					}
					closedir($dh4);
				}
			}
		
			// Templates mode
			if(is_dir(SMARTY_TEMPLATES_PATH.'templates/') && $templates){
				$dh5 = opendir(SMARTY_TEMPLATES_PATH.'templates/');
				if($dh5){
					while (($file = readdir($dh5)) !== false) {
						if(nofakedir($file) && preg_match("/^[\w]+\.tpl$/",$file)) $zip->addFile(SMARTY_TEMPLATES_PATH.'templates/' . $file, basename(SMARTY_TEMPLATES_PATH) .'/' . basename(SMARTY_TEMPLATES_PATH.'templates/') . '/' . $file);
					}
					closedir($dh5);
				}
			}

			// Config mode
			if(is_dir(CONFIG_PATH) && $config){
				if($dh6 = opendir(CONFIG_PATH)){
					$zip->addFile(CONFIG_PATH . 'site.ini', basename(CONFIG_PATH) . '/site.ini');
					closedir($dh6);
				}
			}

			// Put your own Mode here
	
			$zip->close();

			return true;

		}else return false;

	// If ZIP does not exist, us GZ instead (currently not implemented)	
	}else die('ZIP extension does not exist. Please install zip via PECL.');
}

/* WHY NOT USE scandir() ?
 *
 * Because I have a Function to avoid the Fake Dirs,
 * nofakedir(), I can't use scandir(). Instead, I must be use
 * the traditional Directory listing with fopen() and foreach.
 * I will be create a Function that supress these, and
 * will reduce the code.
 * 
 */
 
/* Get the backups file list
 *
 * This function gets the list of Backups archives in /backup/ directory
 * 
 */
 
// array get_backup(void)
function get_backup(){

	$path = 'backups/';
	$dh = opendir($path);
	if ($dh) {
		while (($file = readdir($dh)) !== false) {
			if(nofakedir($file)) $list[] = $file;
		}
	}

	if(!empty($list)) rsort($list);

	return $list;
}

/* ABOUT THIS FUNCTION
 *
 * This function allow to Delete all backups, and optionally,
 * excluding the Last backup.
 * 
 */

// void delete_backups([bool no_last_file])
function delete_backups($no_last = false){

	$dir = "backups/";
	$files = get_backup();

	foreach($files as $key => $value){
		if(($no_last && $key != 0)||!$no_last) unlink($dir.$value);
	}
}

/* ABOUT THIS FUNCTION
 *
 * This function gets the list of directories of Galleries.
 * 
 */

// array get_galleries(void)
function get_galleries(){

	$path = "images/gallery";
	$dh = opendir($path);
	if ($dh) {
		while (($file = readdir($dh)) !== false) {
			if(nofakedir($file)){
				$config = explode('|',file_get_contents(GALLERY_PATH."$file/.name"));
				$list[] = array('file'=>$file,'title'=>$config[0]);
			}	
		}
	}
	closedir($dh);
	
	return $list;
}


/* ABOUT THIS FUNCTION
 *
 * This function sets the Panel message. This is the message in the
 * top of the page, that indicates if a operation is completed successfull or not.
 * This is passed by Session variables; not a nice way, but works.
 * 
 */

// string get_pannel_message(void)
function get_panel_message($params = null,&$smarty){

	$params = null;

	global $LANG;

	if($_SESSION['UPDATED']){
		$message = $LANG['configuration_updated_success'];

	}elseif($_SESSION['CREATED']){
		$section = $_SESSION['SECTION_CREATED'];
		$message = $LANG['section']." \"$section\" ".$LANG['created_success']."!";
		$message.= "<a href=\"$path/edit.php?file=$section\">".$LANG['edit']."</a>";
		
	}elseif($_SESSION['SECTION_EXISTS']){
		$section = $_SESSION['SECTION_CREATED'];
		$message = $LANG['section'] . ' ' . $LANG['already_exists']."!";
		
	}elseif($_SESSION['DELETED']){
		$section = $_SESSION['SECTION_DELETED'];
		$message = $LANG['section']." \"$section\" ".$LANG['deleted_success']."!";

	}elseif($_SESSION['DELETED_SECTION']){
		$section = $_SESSION['SECTION_DELETED'];
		$message = $LANG['section']." \"$section\" ".$LANG['deleted_success']."!";

	}elseif($_SESSION['SECTION_NOT_DELETED']){
		$section = $_SESSION['SECTION_DELETED'];
		$message = $LANG['section']." \"$section\" ".$LANG['deleted_fail']."!";

	}elseif($_SESSION['DELETE_HOME']){
		$message = $LANG['home_cant_delete'];

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

	}elseif($_SESSION['SECTION_NOT_EXIST']){
		$message = $LANG['section_no_exist'];

	}elseif($_SESSION['GALLERY_CREATED']){
		$message = $LANG['gallery_created'];

	}elseif($_SESSION['GALLERY_CREATE_ERROR']){
		$message = $LANG['gallery_create_error'];

	}elseif($_SESSION['IMAGES_UPLOADED']){
		$message = $LANG['images_uploaded'];

	}elseif($_SESSION['IMAGES_NOT_UPLOADED']){
		$message = $LANG['images_not_uploaded'];

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
	
	}elseif($_SESSION['CATEGORY_CREATED']){
		$message = $LANG['category_created'];
	}

	else $message = $LANG['control_panel_preface'];

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

?>
