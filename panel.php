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
require_once('includes/header.php');

// If the User IS NOT ADMIN, redir to Home, and aslo, put a 403
if(!$user_admin){
	redir('index','home'); die();
}

// :: Sections manage

// Show phpinfo()
if(isset($_GET['PHPINFO'])){ die(phpinfo());

// Create section
}elseif(isset($_GET['CREATE'])){
	$filename = strtolower($_POST['filename']);
	$title = $_POST['title'];
	$category = $_POST['category'];

	// If Category is provided, append to the name
	if($category != null) $filename = $category . '_' . $filename;

	$created = create_section($filename,$title, $category);
	
	$smarty->clear_cache('panel.tpl');

	if($created === true){
		$_SESSION['CREATED'] = true;
		$_SESSION['SECTION_CREATED'] = $filename;
		redir('new',$filename); die();

	}elseif($created == 2){
		$_SESSION['SECTION_EXISTS'] = true;
		redir('panel','panel'); die();
	}else{
		$_SESSION['CREATED_ERROR'] = true;
		redir('panel','panel'); die();
	}	
	
// Create Category
}elseif(isset($_GET['CREATE_CATEGORY'])){
	$name = strtolower($_POST['name']);
	$title = $_POST['title'];

	$created = create_category($name,$title);

	if($created === true){
		$_SESSION['CATEGORY_CREATED'] = true;
		$_SESSION['CATEGORY_CREATED_NAME'] = $name;
	}elseif($created == 2){
		$_SESSION['CATEGORY_EXISTS'] = true;
	}else{
		$_SESSION['CREATED_ERROR'] = true;
	}

	$smarty->clear_cache('panel.tpl');
	$smarty->clear_cache('categories.tpl');
	
	redir('panel','panel'); die();

// Wrapper to Editor, to avoid problem with Form
}elseif(isset($_GET['EDIT'])){

	$file = $_POST['file'];
	
	if($file != null) redir('edit',$file);
	else redir ('panel','panel');

// Delete section
}elseif(isset($_GET['DELETE'])){
	$filename = $_POST['filename'];
	
	if(strpos($filename,"_") === true){
		$category = explode("_",$filename);
		$category = $category[0];
	}

	// Main section (home) can't be delete! Ask before anithing
	if($filename == 'home'){
		$_SESSION['DELETE_HOME'] = true;
		redir('panel','panel'); die();
	}

	if(delete_section($filename)){
		$_SESSION['DELETED_SECTION'] = true; // Boolean
		$_SESSION['SECTION_DELETED'] = $filename; // The filename
	}else $_SESSION['SECTION_NOT_DELETED'] = true;

	$smarty->clear_cache('menu_dynamic.tpl',$category);
	$smarty->clear_cache('category.tpl',$category);
	$smarty->clear_cache('categories.tpl');
	$smarty->clear_cache('panel.tpl');

	redir('panel','panel'); die();

// :: Site manage

// Update the config file
}elseif(isset($_GET['SITE_CONF'])){
	$get_sitename = $_POST['sitename'];
	$get_sitedesc = $_POST['sitedesc'];
	$robotstxt = $_POST['robotstxt'];
	$get_banner = $_POST['banner'];
	$get_style = $_POST['style'];
	$get_phpbb_dir = $_POST['phpbb_dir'];
	$get_curr_user = $_POST['curr_user'];
	$get_username = $_POST['username'];
	$get_password = $_POST['password'];
	$get_password_repeat = $_POST['password_repeat'];
	$get_use_rewrite = $_POST['use_rewrite'];

	// If no changes in the User and password, parse the original data
	$check_user_pass_change = check_change_user_pass($get_curr_user,$get_username,$get_password,$get_password_repeat);

	// If the User and password don't match, redir with Error
	if($check_user_pass_change === 0){
		$_SESSION['PASSWORDS_NO_MATCH'] = true;
		redir('panel','panel'); die();
	}
	
	// If the result of the Check User is 0 (no change), use the original data
	if($check_user_pass_change === 2){
		$get_username = $admin_user;
		$get_password = $admin_password;
	}

	if($check_user_pass_change === 1 && $get_username == null) $get_username = $get_curr_user;
	if($check_user_pass_change === 1) $get_password = sha1($get_password);
		
	$saved = update_config($get_sitename,$get_sitedesc,$get_phpbb_dir,$robotstxt,$get_username,$get_password,$get_use_rewrite,$get_banner,$get_style,$smarty_debugging,$get_language);

	$smarty->clear_cache('panel.tpl');

	if($saved) $_SESSION['UPDATED'] = true;

	redir('panel','panel'); die();


// :: Elements (templates) Update mode

// Update the Template
}elseif(isset($_GET['TEMPLATE_SAVE'])){

	$content = stripslashes($_POST['content']);
	$file = $_POST['file'];
	
	if(file_exists("smarty/templates/$name")) $save = template_save($file,$content);

	if($save) $_SESSION['TEMPLATE_UPDATED'] = true;
	else $_SESSION['ERROR'] = true;

	$smarty->clear_cache('panel.tpl');

	redir('panel','panel'); die();


// Edite Template mode
}elseif($_GET['template_file'] != null){

	// Redir to Panel if template does not exist
	if(!file_exists("smarty/templates/".$_GET['template_file']) && $_GET['template_file'] != 'panel.tpl'){
		$_SESSION['TEMPLATE_NO_EXIST'] = true;
		redir('panel','panel');
	}

	// Redirs for Fancy URL
	if(preg_match("/(\?template_file)/",basename($_SERVER['REQUEST_URI'])) && $use_rewrite){ header('location:'.DPORTAL_PATH.'/panel/template:'.$_GET['template_file']); die(); }

	$name = $_GET['template_file'];
	$file = "smarty/templates/$name";

	$smarty->assign('NAME',$name);
	$smarty->assign('FILE',$file);

	$smarty->display('template_edit.tpl'); die();

// Clrear Smarty Cache	
}elseif(isset($_GET['CLR_CACHE'])){
	$smarty->clear_all_cache();
	$smarty->clear_compiled_tpl();	
	$_SESSION['CLEANED'] = true;
	redir('panel','panel'); die();

 // Backup mode
}elseif(isset($_GET['BACKUP'])){

	$mode = $_POST['mode'];
	$download = $_POST['download'];

	if(backup($mode)) $_SESSION['BACKED_UP'] = true;
	else $_SESSION['NOT_BACKED_UP'] = true;

	$smarty->clear_cache('panel.tpl');

	redir('panel','panel'); die();

}elseif(isset($_GET['RESTORE'])){
	
	$absolute_path = $_SERVER['DOCUMENT_ROOT'].$path;

	$zip = new ZipArchive;
	$archive = $zip->open($_FILES['filename']['tmp_name']);

	if($archive){
		$zip->extractTo($absolute_path);
		$_SESSION['RESTORED'] = true;
	}else $_SESSION['RESTORE_ERROR'] = true;

	$smarty->clear_all_cache();

	$smarty->clear_cache('panel.tpl');

	redir('panel','panel'); die();

// Download mode
}elseif(isset($_GET['DOWNLOAD_BACKUP'])){

	$filename = $_POST['filename'];

	raw_download("backups/$filename",'application/zip'); die();
	// No more output after the Download!!!

// Delete backups mode
}elseif(isset($_GET['DELETE_BACKUPS'])){

	$no_last = $_POST['no_last'];

	delete_backups($no_last);
	$_SESSION['BACKUPS_DELETED'] = true;

	$smarty->clear_cache('panel.tpl');

	redir('panel','panel'); die();


// :: Images mode

// Create gallery mode
}elseif(isset($_GET['CREATE_GALLERY'])){

	$name = $_POST['name'];
	$title = $_POST['title'];
	$max = $_POST['max'];
	if($max == null) $max = 10;

	$created = create_gallery($name,$title,$max);

	if($created) $_SESSION['GALLERY_CREATED'] = true;
	else $_SESSION['GALLERY_CREATE_ERROR'] = true;

	$smarty->clear_cache('panel.tpl');

	redir('panel','panel'); die();


// Upload images for Gallery mode
}elseif(isset($_GET['UPLOAD_GALLERY'])){

	if(is_writable('images/gallery/'.$_POST['gallery'].'/.name')){

		$dir = 'images/gallery/'.$_POST['gallery'].'/';

		// This reads the Directory, in order to obtain the number of Files.
		// If the number of files is too large, this method can consume
		// much resources. This method will be cached in file, or the CSV
		if(file_exists("$dir/.files")) $num = file_get_contents("$dir/.files");
		else $num = (count(scandir($dir)) - 3);

		if($_FILES['images']['error'][0] == UPLOAD_ERR_OK &&
		$_FILES['images']['type'][0] == 'application/zip'){

			$zip = new ZipArchive;
			$res = $zip->open($_FILES['images']['tmp_name'][0]);

			if ($res === TRUE) {
					if($zip->extractTo($dir)) $extracted = true;
					$zip->close();
			}else $extracted = false;

		}else{

			$num_images_uploaded = 0;
			foreach ($_FILES['images']['error'] as $key => $error){

				if($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES['images']['tmp_name'][$key];
					$name = $_FILES['images']['name'][$key];
					$mime = $_FILES['images']['type'][$key];

					if($mime == 'image/jpeg' || $mime == 'image/pjpeg' ||
					$mime == 'image/gif' || $mime == 'image/png'){
						move_uploaded_file($tmp_name,"$dir/$num.$name");
						$num_images_uploaded++;
					}
				}
				$num++;
			}

			if($num_images_uploaded >= 1)$copied = true;
			else $copied = 2;
		}
	}else $copied = false;

	count_files_cache($dir);

	if(($copied) || $extracted) $_SESSION['IMAGES_UPLOADED'] = true;
	//elseif($copied == 2) $_SESSION['NO_IMAGES_UPLOADED'] = true;
	else $_SESSION['IMAGES_NOT_SAVED'] = true;

	$smarty->clear_cache('gallery_gallery.tpl',$_POST['gallery']);
	$smarty->clear_cache('gallery.tpl',$_POST['gallery']);

	$smarty->clear_cache('panel.tpl');

	redir('panel','panel'); die();

// Updates via SVN the Working copy of files for update.
// Note: Files in Working directory are hard links to
// the files in Application directory instead of copy them.
// This is more practical, but if you use non-UNIX server
// (as Windows), you should create hard links to these files
// manually. See README_UPDATES for details.
}elseif(isset($_GET['SVN_UPDATE'])){

	if(!file_exists(UPDATES_PATH.'/.svn')) $checkout = svn_checkout($conf['updates_url'],UPDATES_DIR);
	else $update = svn_update(UPDATES_PATH);

	if($checkout || $update) $_SESSION['UPDATED_SVN'] = true;
	else $_SESSION['UPDATE_ERROR'] = true;

	redir('panel','panel'); die();

}elseif(isset($_GET['SVN_COPY'])){

	if($dir1 = opendir(UPDATES_PATH)) {
			while (false !== ($file = readdir($dir1))) {
				if(nofakedir($file) && !is_dir($file)) copy(UPDATES_PATH."/$file",DPORTAL_ABSOLUTE_PATH."/$file");
			}
		closedir($dir1);
	}

	if($dir2 = opendir(UPDATES_PATH."/includes")) {
			while (false !== ($file = readdir($dir2))) {
				if(nofakedir($file) && !is_dir($file)) copy(UPDATES_PATH."/includes/$file",DPORTAL_ABSOLUTE_PATH."/includes/$file");
			}
		closedir($dir2);
	}

	if($dir3 = opendir(UPDATES_PATH."/includes/functions")) {
			while (false !== ($file = readdir($dir3))) {
				if(nofakedir($file) && !is_dir($file)) copy(UPDATES_PATH."/includes/functions/$file",DPORTAL_ABSOLUTE_PATH."/includes/functions/$file");
			}
		closedir($dir3);
	}

	if($dir4 = opendir(UPDATES_PATH."/smarty/templates")) {
			while (false !== ($file = readdir($dir4))) {
				if(nofakedir($file) && !is_dir($file)) copy(UPDATES_PATH."/includes/functions/$file",DPORTAL_ABSOLUTE_PATH."/includes/functions/$file");
			}
		closedir($dir4);
	}

	if($dir5 = opendir(UPDATES_PATH."/lang")) {
			while (false !== ($file = readdir($dir5))) {
				if(nofakedir($file) && !is_dir($file)) copy(UPDATES_PATH."/lang/$file",DPORTAL_ABSOLUTE_PATH."/lang/$file");
			}
		closedir($dir5);
	}

	copy(UPDATES_PATH."/config.php",DPORTAL_ABSOLUTE_PATH."/config.php");

	if(!$error) $_SESSION['UPDATERS_COPIED'] = true;
	else $_SESSION['UPDATE_ERROR'] = true;

	redir('panel','panel');die();

// :: Normal mode

}else{

	$smarty->register_function('PANEL_MESSAGE','get_panel_message',false);

	$smarty->caching = true;

	if(!$smarty->is_cached('panel.tpl')){

		// Gets the Sections and Templates list
		$sections = get_sections("all");
		$categories = get_categories(true);
		$templates = get_templates();
		$galleries = get_galleries();
		$backups = get_backup();

		// Get list of files to be updated
		$files = diff_updated_files();

		// Iteration for select num of Images per page
		for($num = 10; $num <= 50;$num++)	$max[] = $num;

		$smarty->assign('MAX',$max);
	
		$smarty->assign('USE_REWRITE',$use_rewrite);
		$smarty->assign('PHPBB_DIR',$phpbb_dir);
	
		$smarty->assign('SECTIONS',$sections);
		$smarty->assign('CATEGORIES',$categories);		
		$smarty->assign('TEMPLATES',$templates);
		$smarty->assign('GALLERIES',$galleries);
		$smarty->assign('BACKUPS',$backups);

		$smarty->assign('SIDEBAR_TEMPLATE','smarty/templates/sidebar_c.tpl');
		$smarty->assign('FOOTER_TEMPLATE','smarty/templates/footer_c.tpl');
	}

	$smarty->display('panel.tpl');
}

require_once('includes/footer.php');

?>
