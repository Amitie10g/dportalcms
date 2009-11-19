<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Functions for Panel (panel.php)             #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// The following function checks if the User and Password
// is checked or not and return an INTEGER value.

// If changes are made (all values are NOT NULL and User and passwords match),
// returns INT 1, that is interpreted as TRUE.
//
// If Passwords not match, returns 2.
//
// If one of the data are NULL, return INT 0, that is interpreted as FALSE

// int check_change_user_pass([string user, string password, string password_repeat)
function check_change_user_pass($curr_user = null, $user = null,$password = null,$password_repeat = null){

	if($curr_user != null && (($curr_user != $user && $user != null) || $user == null) &&
		$password != null &&	$password_repeat != null &&
		$password == $password_repeat) return 1; // true

	elseif(($password != $password_repeat) ||
		($user != null && ($password == null ||
		$password_repeat == null))) return 0; // Passwords not match (false)
	
	else return 2; // Unchanged
}

// bool update_config()
function update_config($sitename,$site_desc,$phpbb_dir,$robotstxt,$user,$password,$use_rewrite = null,$banner = null,$style = null,$smarty_debugging = null,$language = null){

	// Configure the output
	$output = ";Site config file generated automatically. DO NOT EDIT!\n";	
	$output.= "sitename = \"$sitename\"\n";
	$output.= "sitedesc = \"$site_desc\"\n";
	$output.= "banner = \"$banner\"\n";
	$output.= "phpbb_dir = \"$phpbb_dir\"\n";
	$output.= "user = \"$user\"\n";
	$output.= "password  = \"".$password."\"\n";
	$output.= "language = \"$language\"\n";
	$output.= "use_rewrite = $use_rewrite\n";
	$output.= "smarty_debugging = $smarty_debugging\n";

	// Error messages
	$error = "The Config file does not exists or don't have permissionf of write!";
	
	// Open the Configuration file for Write
	$file = fopen('config/site.ini', 'w') or die("<b>Fatal error:</b> $error");
	flock($file,2);
	$written = @fwrite($file,$output);	
	fclose($file);

	// Open the 'robots.txt' file for write
	$robotstxt_file = fopen('robots.txt','w');
	flock($robotstxt_file,2);
	$robotstxt_written = fwrite($robotstxt_file,$robotstxt);	
	fclose($robotstxt_file);

	if($written !== false && $robotstxt_written !== false) return true;}

// array get_sections(void)
function get_sections(){
  
	$secs = @fopen("content/.list", "r") or die('Archivo de listas inexistente');
	while (($data = fgetcsv($secs, 1000, ";")) !== FALSE) {	
		$name = $data[1];
		$title = $data[2];
		$sections[] = array('name'=>$name,'title'=>$title);
	}
	fclose($secs);
 
  return $sections;
}

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

// bool template_save(string name, string content
function template_save($name,$content){

	$file = fopen("smarty/templates/$name",'w');
	if(fwrite($file,$content)) $saved = true;
  fclose($file);
	
	return $saved;

}

/* ABOUT THIS FUNCTION
 *
 * This function performs a Backup. parameters are given
 * from the Formulary as Array. Keys are the Names of the
 * type, for easy association, and is scalable.
 * 
 * If $mode is null (no Array is given from the Form,
 * the Function shouldn't create foreach()
 *
 */

//bool backup_content(array mode)
function backup(array $mode = null){

	global $sitename;
	$date = time();

	if($mode != null){
		$blog = $mode['blog'];
		$templates = $mode['templates'];
		$config = $mode['config'];
	}

	$zip_comment = "DPortal CMS backup file\n\n";
	$zip_comment.= "Sitename:\t$sitename\n";
	$zip_comment.= "URL:\t\thttp://" . $_SERVER['SERVER_NAME'] . DPORTAL_PATH . "\n";
	$zip_comment.= "Created:\t" . date("m/d/Y H:i",$date) . "\n\n";
	$zip_comment.= "This backup includes:\n\n";
	$zip_comment.= "\t* Sections (by default).\n";
	if($blog) $zip_comment.= "\t* Blog (entries and comments).\n"; 
	if($templates) $zip_comment.= "\t* Templates.\n"; 
	if($config) $zip_comment.= "\t* Configuration file ('siten.ini').\n"; 
	$zip_comment.= "\nThis is a Backup of your Portal. Contain the\nfolders of content and configuration.\n\n";
	$zip_comment.= "If you need to Restore this Backup, use the\nControl panel for them, or upload the contents\ndirectly to the root of your Portal.\n\n";
	$zip_comment.= "Please don't modify the contents if you don't know.\n";

	$sections_path = 'content/';
	$config_path = 'config/';
	$entries_path = 'entries/';
	$comments_path = 'comments/';
	$templates_path = 'smarty/templates/';

	// Declare the ZipArchive Class
	$zip = new ZipArchive;
	$archive = $zip->open('backups/backup_' . date("d-m-Y_H-i",$date) . '.zip' , ZipArchive::CREATE) or die('Error opening or creating file file');

	if($archive){

		$zip->setArchiveComment($zip_comment);

		// Default mode: Backup Sections
		if(is_dir($sections_path)){
			$dh1 = opendir($sections_path);
			if($dh1){
				while (($file = readdir($dh1)) !== false) {
					if(nofakedir($file)) $zip->addFile($sections_path . $file);
				}
			}
			closedir($dh1);
		}

		// Blog mode
		if(is_dir($entries_path) &&
		is_dir($comments_path) && $blog){
			$dh2 = opendir($comments_path);
			if($hd2){
				while (($file = readdir($dh2)) !== false) {
					if(nofakedir($file)) $zip->addFile($comments_path . $file);
				}
			}
			closedir($dh2);

			$dh3 = opendir($entries_path);
			if($dh3){
				while (($file = readdir($dh3)) !== false) {
					if(nofakedir($file)) $zip->addFile($entries_path . $file);
				}
			}
			closedir($dh3);
		}

		// Templates mode
		if(is_dir($templates_path) && $templates){
			$dh4 = opendir($templates_path);
			if($dh4){
				while (($file = readdir($dh4)) !== false) {
					if(nofakedir($file) && preg_match("/^[\w]+\.tpl$/",$file)) $zip->addFile($templates_path . $file);
				}
			}
			closedir($dh4);
		}

		// Config mode
		if(is_dir($config_path) && $config){
			$dh5 = opendir($config_path);
			if($dh5){
				$zip->addFile($config_path . 'site.ini');
			}
			closedir($dh5);
		}

		// Put your own Mode here
	
		$zip->close();

		return true;

	}else return false;
}

/* WHY NOT USE scandir() ?
 *
 * Because I have a Function to avoid the Fake Dirs,
 * nofakedir(), I can't use scandir(). Instead, I must be use
 * the traditional Directory listing with fopen() and foreach.
 * I will be create a Function that supress these, and
 * will reeuce the code.
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

	if($list != null){ natsort($list); rsort($list); }

	return $list;
}

// void delete_backups([bool no_last_file])
function delete_backups($no_last = false){

	$dir = "backups/";
	$files = get_backup();

	foreach($files as $key => $value){
		if(($no_last && $key != 0)||!$no_last) unlink($dir.$value);
	}
}

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
	}

	else $message = $LANG['control_panel_preface'];

	return $message;
}
?>
