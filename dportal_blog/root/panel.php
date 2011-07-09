<?php
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Control Panel (panel.php)                   #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

define('DPORTAL',true);
require_once('config/config.php');

// If the User IS NOT ADMIN, redir to Home, or use Login...
if(!$user_admin){
	redir('blog','blog'); die();
}

// Show phpinfo()
if(isset($_GET['PHPINFO'])){ die(phpinfo());

// :: Site manage
// Update the config file
}elseif(isset($_GET['SITE_CONF'])){
	$get_sitename = $_POST['sitename'];
	$get_sitedesc = $_POST['sitedesc'];
	$get_robotstxt = $_POST['robotstxt'];
	$get_admin_email = $_POST['admin_email'];
	$get_admin_nick = $_POST['admin_nick'];
	$get_phpbb_dir = $_POST['phpbb_dir'];
	$get_language = $_POST['lang'];
	$get_curr_user = $_POST['curr_user'];
	$get_curr_password = $_POST['curr_pass'];
	$get_username = $_POST['username'];
	$get_password = $_POST['password'];
	$get_password_repeat = $_POST['password_repeat'];
	$get_cse_key = $_POST['cse_key'];
	$get_use_rewrite = $_POST['use_rewrite'];
	$get_memcached_server = $_POST['memcached_server'];
	$get_memcached_port = $_POST['memcached_port'];

	// By default, User and Password is the same
	$username = $admin_user;
	$password = $admin_password;

	// If no changes in the User and password, parse the original data
	$check_user_pass_change = check_change_user_pass($get_curr_user,$get_curr_password,$get_username,$get_password,$get_password_repeat);

	// If the User and password don't match, redir with Error
	if($check_user_pass_change === 1){
		$_SESSION['PASSWORDS_NO_MATCH'] = true;
		redir('panel','user_pass'); die();
	}
	
	if($check_user_pass_change === 2) $username = sha1($get_username);
	if($check_user_pass_change === 3) $password = sha1($get_password);
	if($check_user_pass_change === 4){
		$username = sha1($get_username);
		$password = sha1($get_password);
	}

	if(!isset($get_sitename)) $get_sitename = $sitename;
	if(!isset($get_sitedesc)) $get_sitedesc = $sitedesc;
	if(!isset($get_robotstxt)) $get_robotstxt = file_get_contents(DPORTAL_ABSOLUTE_PATH . '/robots.txt');
	if(!isset($get_admin_email)) $get_admin_email = $admin_email;
	if(!isset($get_admin_nick)) $get_admin_nick = $admin_nick;
	if(!isset($get_phpbb_dir)) $get_phpbb_dir = $phpbb_dir;
	if(!isset($get_language)) $get_language = $language;
	if(!isset($get_username)) $get_username = $admin_user;
	if(!isset($get_password)) $get_password = $admin_password;
	if(!isset($get_cse_key)) $get_cse_key = $cse_key;
	if(!isset($get_memcached_server)) $get_memcached_server = $memcached_server;
	if(!isset($get_memcached_port)) $get_memcached_port = $memcached_port;
	
	if(($get_use_rewrite == "1" || empty($get_use_rewrite)) && !isset($get_sitename)) $get_use_rewrite = $use_rewrite;

	$saved = update_config($get_sitename,$get_sitedesc,$get_admin_email,$get_admin_nick,$get_language,$get_robotstxt,$username,$password,$get_phpbb_dir,$get_cse_key,$get_use_rewrite,$smarty_debugging,$get_memcached_server,$get_memcached_port);

	$smarty->clear_cache('panel.tpl');

	// If User or Password is changed successfully, Close de session (unless you are using phpBB)
	if($saved && ($check_user_pass_change === 2 || $check_user_pass_change === 3 || $check_user_pass_change === 4) && !$use_phpbb) session_destroy();
	if($saved) $_SESSION['UPDATED'] = true;

	$smarty->clear_all_cache();

	if(!empty($_SERVER['HTTP_REFERER'])) header('location:' . $_SERVER['HTTP_REFERER']);
	else redir('panel','general',null,'?tab=general');
	die();


// :: Update Styles file

}elseif(isset($_GET['UPDATE_STYLE'])){

	$style = $_POST['style'];
	if(update_style($style)) $_SESSION['STYLE_UPDATED'] = true;
	else $_SESSION['STYLE_NOT_UPDATED'] = true;
	
	$smarty->clear_cache('style_css.tpl');
	
	redir('panel','style',null,'?tab=style');

	die();

// :: Elements (templates) Update mode

// Update the Template
}elseif(isset($_GET['TEMPLATE_SAVE'])){

	$content = stripslashes($_POST['content']);
	$file = $_POST['file'];
	
	if(file_exists(SMARTY_TEMPLATES_PATH."/templates/$name")) $save = template_save($file,$content);

	if($save) $_SESSION['TEMPLATE_UPDATED'] = true;
	else $_SESSION['ERROR'] = true;

	$smarty->clear_cache('panel.tpl');

	redir('panel',"style/template:$file",null,"?tab=style&mode=template&template_file=$file"); die();


// Clear Smarty Cache/Templates and Thumbnails of Videos (optional)
}elseif(isset($_GET['CLR_CACHE'])){
	$smarty->clear_all_cache();
	$smarty->clear_compiled_tpl();
	// Uncomment only if you want to clear thumbs here
	//clear_thumbs();
	$_SESSION['CLEANED'] = true;
	if(!empty($_SERVER['HTTP_REFERER'])) header('location:' . $_SERVER['HTTP_REFERER']);
	else redir('panel','general',null,"?tab=general");
	die();

 // Backup mode
}elseif(isset($_GET['BACKUP'])){

	$mode = $_POST['mode'];
	$download = $_POST['download'];

	if(backup($mode)) $_SESSION['BACKED_UP'] = true;
	else $_SESSION['NOT_BACKED_UP'] = true;

	$smarty->clear_cache('panel.tpl');

	redir('panel','backup',null,"?tab=backup");
	die();

// Restore Backups
}elseif(isset($_GET['RESTORE'])){
	
	$zip = new ZipArchive;
	$archive = $zip->open($_FILES['filename']['tmp_name']);

	/*$delete_destination = $_POST['delete_destination'];
	if($delete_destination == '1') */$delete_destination = true;

	if($archive){
		if(!is_dir(DPORTAL_TEMP_PATH)) mkdir(DPORTAL_TEMP_PATH);
	
		$zip->extractTo(DPORTAL_TEMP_PATH);
		
		if(file_get_contents(DPORTAL_TEMP_PATH . 'site_id') == $site_id){
			unlink(DPORTAL_TEMP_PATH . 'site_id');

			// Config file copy
			if(is_readable(DPORTAL_TEMP_PATH.'/config/config.inc.php')){
				unlink(DPORTAL_ABSOLUTE_PATH . '/config/config.inc.php');
				copy(DPORTAL_TEMP_PATH.'/config/config.inc.php', DPORTAL_ABSOLUTE_PATH . '/config/config.inc.php');
				unlink(DPORTAL_TEMP_PATH.'/config/config.inc.php');
			}
	
			// Entries
			if(is_dir(DPORTAL_TEMP_PATH.'/entries/')){
				if(($dir = opendir(DPORTAL_TEMP_PATH.'/entries/')) !== false){
					// Delete destination files (all contents) before restore.					
					if($delete_destination === true){
						$dest_dir = opendir(ENTRIES_PATH);
						while(($dest_file = readdir($dest_dir)) !== false){
							if($dest_file != '.' && $dest_file != '..' && is_file(ENTRIES_PATH . $dest_file)) unlink(ENTRIES_PATH . $dest_file);
						}
						closedir($dest_dir);
					}
					while(($file = readdir($dir)) !== false){
						if(nofakedir($file)){
							if(is_file(ENTRIES_PATH . $file)) unlink(ENTRIES_PATH . $file);
							copy(DPORTAL_TEMP_PATH.'/entries/' . $file, ENTRIES_PATH . $file);
							unlink(DPORTAL_TEMP_PATH.'/entries/' . $file);
						}
					}
				closedir($dir);
				}
			}
			
			// Comments
			if(is_dir(DPORTAL_TEMP_PATH.'/comments/')){
				if(($dir = opendir(DPORTAL_TEMP_PATH.'/comments/')) !== false){
					// Delete destination files (all contents) before restore.					
					if($delete_destination === true){
						$dest_dir = opendir(COMMENTS_PATH);
						while(($dest_file = readdir($dest_dir)) !== false){
							if($dest_file != '.' && $dest_file != '..' && is_file(COMMENTS_PATH . $dest_file)) unlink(COMMENTS_PATH . $dest_file);
						}
						closedir($dest_dir);
					}
					while(($file = readdir($dir)) !== false){
						if(nofakedir($file)){
							if(is_file(COMMENTS_PATH . $file)) unlink(COMMENTS_PATH . $file);
							copy(DPORTAL_TEMP_PATH.'/comments/' . $file, COMMENTS_PATH . $file);
							unlink(DPORTAL_TEMP_PATH.'/comments/' . $file);
						}
					}
				}
				closedir($dir);
			}
			
			// Templates
			if(is_dir(DPORTAL_TEMP_PATH.'/templates/')){
				if(($dir = opendir(DPORTAL_TEMP_PATH.'/templates/')) !== false){
					// Delete destination files (all contents) before restore.					
					if($delete_destination === true){
						$dest_dir = opendir(SMARTY_TEMPLATES_PATH);
						while(($dest_file = readdir($dest_dir)) !== false){
							if($dest_file != '.' && $dest_file != '..' && is_file(SMARTY_TEMPLATES_PATH . $dest_file)) unlink(SMARTY_TEMPLATES_PATH . $dest_file);
						}
						closedir($dest_dir);
					}
					while(($file = readdir($dir)) !== false){
						if(nofakedir($file)){
							if(is_file(SMARTY_TEMPLATES_PATH . "templates/$file")) unlink(SMARTY_TEMPLATES_PATH . "templates/$file");
							copy(DPORTAL_TEMP_PATH.'/templates/' . $file, SMARTY_TEMPLATES_PATH . "templates/$file");
							unlink(DPORTAL_TEMP_PATH.'/templates/' . $file);
						}
					}
				closedir($dir);
				}
			}

			// Remove the directories
			rmdir(DPORTAL_TEMP_PATH.'/config/');
			rmdir(DPORTAL_TEMP_PATH.'/comments/');
			rmdir(DPORTAL_TEMP_PATH.'/entries/');
			rmdir(DPORTAL_TEMP_PATH.'/templates/');

			$_SESSION['RESTORED'] = true;
		}else{
				$_SESSION['RESTORE_ERROR'] = true;
		}
	}else $_SESSION['RESTORE_ERROR'] = true;

	$smarty->clear_all_cache();

	redir('panel','backup',null,"?tab=backup");
	die();

// Download Backup mode
}elseif(isset($_GET['DOWNLOAD_BACKUP'])){

	$filename = $_POST['filename'];

	raw_download(BACKUPS_PATH . $filename,'application/zip'); die();
	// No more output after the Download!!!

// Delete Backups mode
}elseif(isset($_GET['DELETE_BACKUPS'])){

	$no_last = $_POST['no_last'];

	delete_backups($no_last);
	$_SESSION['BACKUPS_DELETED'] = true;

	$smarty->clear_cache('panel.tpl');

	redir('panel','backup',null,"?tab=backup");
	die();


// :: Normal mode

}else{

	if(!empty($_POST['template_file'])){
	
		$name = $_POST['template_file'];
	
		// Redir to Panel if template does not exist
		if(is_writable(SMARTY_TEMPLATES_PATH."templates/$name") &&
		is_file(SMARTY_TEMPLATES_PATH."templates/$name") &&
		$name != 'panel.tpl'){
			redir('panel',"style/template:$name",null,"?tab=style&mode=template&template_file=$name"); die();
		}else{
			$_SESSION['TEMPLATE_NO_EXIST'] = true;
			redir('panel',"style/template",null,"?tab=style&mode=template"); die();
		}
	
		$smarty->assign('PANEL_MESSAGE',get_panel_message());
	
	}
	
	if(!empty($_GET['template_file'])){
	
		$name = $_GET['template_file'];

		$file = SMARTY_TEMPLATES_PATH."templates/$name";
	
		$smarty->assign('NAME',$name);
		$smarty->assign('FILE',$file);
	
	}
	
	$tab = $_GET['tab'];
	$mode = $_GET['mode'];
	
	switch($tab){
		// general mode by default
		default :
			$smarty->assign('TAB','general');
			switch($mode){
				default		 : $smarty->assign('MODE','site_conf'); break;
				case 'robotstxt' : $smarty->assign('MODE','robotstxt'); break;
				case 'robotstxt' : $smarty->assign('MODE','site_conf'); break;
				case 'memcached' : $smarty->assign('MODE','memcached'); break;
				case 'cse'	 : $smarty->assign('MODE','cse'); break;
			}
			break;
		
		case 'user_pass' :
			$smarty->assign('TAB','user_pass');
			break;
	
		case 'style' :
			$smarty->assign('TAB','style');
			switch($mode){
				default			:
					require_once('config/style_cfg.php');
					$smarty->assign('STYLE_LIST',$style_list);
					$smarty->assign('MODE','edit_style'); break;
				case 'template' :
					$templates = get_templates();
					$smarty->assign('TEMPLATES',$templates);
					$smarty->assign('MODE','template');
					break;
			}
			break;
	
		case 'backup' :
			$smarty->assign('TAB','backup');
			$backups   = get_backup();
			
			if(empty($backups)){
				switch($mode){
					default: $smarty->assign('MODE','create'); break;
					case 'restore':  $smarty->assign('MODE','restore'); break;
				}
			}else{
				switch($mode){
					default:
						$smarty->assign('BACKUPS',$backups);
						$smarty->assign('MODE','download');
						break;
					case 'create':  $smarty->assign('MODE','create'); break;
					case 'restore': $smarty->assign('MODE','restore'); break;
					case 'delete':  $smarty->assign('MODE','delete'); break;
				}
			}
			
			$smarty->assign('BACKUPS',$backups);
			
			break;
		break;
	}

	$langfiles = get_lang_files();
	$smarty->assign('LANGFILES',$langfiles);

	$smarty->assign('PANEL_MESSAGE',get_panel_message());

	// Get list of files to be updated (not implemented)
	//$files = diff_updated_files();

	// Iteration for select num of Images per page
	for($num = 10; $num <= 50;$num++)	$max[] = $num;

	$smarty->assign('MAX',$max);

	$smarty->assign('USE_REWRITE',$use_rewrite);
	$smarty->assign('PHPBB_DIR',$phpbb_dir);

	$smarty->display('panel.tpl');
}

require_once(INCLUDES_PATH.'/footer.php');

?>
