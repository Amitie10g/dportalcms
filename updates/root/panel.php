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
	
	redir('panel','sections/create_section'); die();

// Wrapper to Editor, to avoid problem with Form
}elseif(isset($_GET['EDIT'])){

	$file = $_POST['file'];
	if(!empty($_POST['panel'])) $_SESSION['PANEL'] = true;
	
	if($file != null) redir('edit',$file);
	else redir ('panel','sections');

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
		redir('panel','sections'); die();
	}

	if(delete_section($filename)){
		$_SESSION['DELETED_SECTION'] = true; // Boolean
		$_SESSION['SECTION_DELETED'] = $filename; // The filename
	}else $_SESSION['SECTION_NOT_DELETED'] = true;

	$smarty->clear_cache('menu_dynamic.tpl',$category);
	$smarty->clear_cache('category.tpl',$category);
	$smarty->clear_cache(null,"$category|$filename");	
	$smarty->clear_cache('categories.tpl');
	$smarty->clear_cache('panel.tpl');

	redir('panel','sections'); die();
	
}elseif(isset($_GET['DELETE_CATEGORY'])){

	$category = $_POST['category'];
	
	$deleted = delete_category($category);
	
	if(delete_section($filename)){
		$_SESSION['DELETED_CATEGORY'] = true; // Boolean
		$_SESSION['CATEGORY_DELETED'] = $filename; // The filename
	}else $_SESSION['CATEGORY_NOT_DELETED'] = true;

	$smarty->clear_cache('menu_dynamic.tpl',$category);
	$smarty->clear_cache('category.tpl',$category);
	$smarty->clear_cache(null,$category);	
	$smarty->clear_cache('categories.tpl');
	$smarty->clear_cache('panel.tpl');
	
	redir('panel','sections'); die();	

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
		redir('panel','panel'); die();
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
	if(!isset($get_use_rewrite)) $get_use_rewrite = $use_rewrite;
	if(!isset($get_memcached_server)) $get_memcached_server = $memcached_server;
	if(!isset($get_memcached_port)) $get_memcached_port = $memcached_port;

	$saved = update_config($get_sitename,$get_sitedesc,$get_admin_email,$get_admin_nick,$get_language,$get_robotstxt,$username,$password,$get_phpbb_dir,$get_cse_key,$get_use_rewrite,$smarty_debugging,$get_memcached_server,$get_memcached_port);

	$smarty->clear_cache('panel.tpl');

	// If User or Password is changed successfully, Close de session (unless you are using phpBB)
	if($saved && ($check_user_pass_change === 2 || $check_user_pass_change === 3 || $check_user_pass_change === 4) && !$use_phpbb) session_destroy();
	if($saved) $_SESSION['UPDATED'] = true;

	if(!empty($_SERVER['HTTP_REFERER'])) header('location:' . $_SERVER['HTTP_REFERER']);
	else redir('panel','general');
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

	redir('panel',"style/template:$file"); die();


// Clear Smarty Cache/ Templates and Thumbnails of Videos (optional)
}elseif(isset($_GET['CLR_CACHE'])){
	$smarty->clear_all_cache();
	$smarty->clear_compiled_tpl();
	// Uncomment only if you want to clear thumbs here
	//clear_thumbs();
	$_SESSION['CLEANED'] = true;
	if(!empty($_SERVER['HTTP_REFERER'])) header('location:' . $_SERVER['HTTP_REFERER']);
	else redir('panel','general');
	die();

 // Backup mode
}elseif(isset($_GET['BACKUP'])){

	$mode = $_POST['mode'];
	$download = $_POST['download'];

	if(backup($mode)) $_SESSION['BACKED_UP'] = true;
	else $_SESSION['NOT_BACKED_UP'] = true;

	$smarty->clear_cache('panel.tpl');

	if(!empty($_SERVER['HTTP_REFERER'])) header('location:' . $_SERVER['HTTP_REFERER']);
	else redir('panel','general');
	die();

// Restore Backups
}elseif(isset($_GET['RESTORE'])){
	
	$zip = new ZipArchive;
	$archive = $zip->open($_FILES['filename']['tmp_name']);

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
	
			// Content
			if(is_dir(DPORTAL_TEMP_PATH.'/content/')){
				if(($dir = opendir(DPORTAL_TEMP_PATH.'/content/')) !== false){
					while(($file = readdir($dir)) !== false){
						if(nofakedir($file)){
							if(is_file(CONTENT_PATH . $file)) unlink(CONTENT_PATH . $file);
							copy(DPORTAL_TEMP_PATH.'/content/' . $file, CONTENT_PATH . $file);
							unlink(DPORTAL_TEMP_PATH.'/content/' . $file);
						}
					}
				}
			}
			
			// Entries
			if(is_dir(DPORTAL_TEMP_PATH.'/entries/')){
				if(($dir = opendir(DPORTAL_TEMP_PATH.'/entries/')) !== false){
					while(($file = readdir($dir)) !== false){
						if(nofakedir($file)){
							if(is_file(ENTRIES_PATH . $file)) unlink(ENTRIES_PATH . $file);
							copy(DPORTAL_TEMP_PATH.'/entries/' . $file, ENTRIES_PATH . $file);
							unlink(DPORTAL_TEMP_PATH.'/entries/' . $file);
						}
					}
				}
			}
			
			// Comments
			if(is_dir(DPORTAL_TEMP_PATH.'/comments/')){
				if(($dir = opendir(DPORTAL_TEMP_PATH.'/comments/')) !== false){
					while(($file = readdir($dir)) !== false){
						if(nofakedir($file)){
							if(is_file(COMMENTS_PATH . $file)) unlink(COMMENTS_PATH . $file);
							copy(DPORTAL_TEMP_PATH.'/comments/' . $file, COMMENTS_PATH . $file);
							unlink(DPORTAL_TEMP_PATH.'/comments/' . $file);
						}
					}
				}
			}
			
			// Templates
			if(is_dir(DPORTAL_TEMP_PATH.'/templates/')){
				if(($dir = opendir(DPORTAL_TEMP_PATH.'/templates/')) !== false){
					while(($file = readdir($dir)) !== false){
						if(nofakedir($file)){
							if(is_file(SMARTY_TEMPLATES_PATH . "templates/$file")) unlink(SMARTY_TEMPLATES_PATH . "templates/$file");
							copy(DPORTAL_TEMP_PATH.'/templates/' . $file, SMARTY_TEMPLATES_PATH . "templates/$file");
							unlink(DPORTAL_TEMP_PATH.'/templates/' . $file);
						}
					}
				}
			}
	

			// Remove the directories
			rmdir(DPORTAL_TEMP_PATH.'/config/');
			rmdir(DPORTAL_TEMP_PATH.'/comments/');
			rmdir(DPORTAL_TEMP_PATH.'/content/');
			rmdir(DPORTAL_TEMP_PATH.'/entries/');
			rmdir(DPORTAL_TEMP_PATH.'/templates/');

			$_SESSION['RESTORED'] = true;
		}else{
				$_SESSION['RESTORE_ERROR'] = true;
				redir('panel','panel'); die();
		}
	}else $_SESSION['RESTORE_ERROR'] = true;

	$smarty->clear_all_cache();

	$smarty->clear_cache('panel.tpl');

	if(!empty($_SERVER['HTTP_REFERER'])) header('location:' . $_SERVER['HTTP_REFERER']);
	else redir('panel','backup');
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

	if(!empty($_SERVER['HTTP_REFERER'])) header('location:' . $_SERVER['HTTP_REFERER']);
	else redir('panel','backup');
	die();


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

	$smarty->clear_cache(null,'gallery');
	$smarty->clear_cache('panel.tpl');

	redir('panel','gallery'); die();


// Upload images for Gallery mode
}elseif(isset($_GET['UPLOAD_GALLERY'])){

	$gallery = $_POST['gallery'];

	if(is_writable(GALLERY_PATH . $gallery . '/.name')){

		$dir = GALLERY_PATH . $gallery . '/';

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
				for($id=0; $id<$zip->numFiles;$id++) {
					$name = $zip->getNameIndex($id);
					// Check if name inside is valid. Only Aplhanumerical, '-' and '_' are allowed, and ONE dot plus the Extension.
					// Unicode Characters should be allowed, too, but checking for Unicode characters is too slow for PCRE.
					// Solution, is use urlencode() to check if file contain valid special characters
					if(preg_match("/^([\w-_+]*)(%[\d]+)*\.(GIF|PNG|JPG|JPEG|PNG|gif|jpg|jpeg|png)$/",urlencode($name)) >= 1) $acepted_name[] = $name;
				}
				if($acepted_name != null) $extracted = $zip->extractTo($dir,$acepted_name);
				else $extracted = false;

				$zip->close();
				
				// Do an aditional check against MIME type of image. If image is not an acepted MIME
				// (image/jpeg; image/pjpeg;image/gif; image/ing), will be deleted.
				foreach($acepted_name as $name){
					$mime = image_type_to_mime_type(exif_imagetype(GALLERY_PATH . "$gallery/$name"));
					if(!get_image_extension($mime,true)) unlink(GALLERY_PATH . "$gallery/$name");
				}
			}
		}else{

			$num_images_uploaded = 0;
			foreach ($_FILES['images']['error'] as $key => $error){

				if($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES['images']['tmp_name'][$key];
					$name = preg_replace(array("/[^\w\s-_]*/","/(gif|jpeg|jpg|png|GIF|JPG|JPEG|PNG)/"),'',$_FILES['images']['name'][$key]);
					//$mime = image_type_to_mime_type(exif_imagetype($_FILES['images']['tmp_name'][$key]));
					$mime = "image/png";
					$ext = get_image_extension($mime,true); // Alternative to image_type_to_extension
					if(file_exists($dir . $name . $ext)) $name = $name . '_' . rand(10,99);
					
					if($ext !== false) move_uploaded_file($tmp_name,$dir . $name . $ext);
				}
				$num_images_uploaded++;
			}

			if($num_images_uploaded >= 1) $copied = true;
			else $copied = false;
		}
	}else $copied = false;

	if($copied || $extracted) $_SESSION['IMAGES_UPLOADED'] = true;
	else $_SESSION['IMAGES_NOT_SAVED'] = true;

	// Only solution to clear caches that aren't cleaned. Investigating
	$smarty->clear_all_cache();

	$smarty->clear_cache(null,"gallery_gallery|$gallery");
	$smarty->clear_cache(null,"gallery_goto|$gallery");
	$smarty->clear_cache(null,"gallery_gallery|index");
	$smarty->clear_cache('gallery_feed.tpl',$gallery); // Gallery page
	$smarty->clear_cache('panel.tpl');

	redir('panel',"gallery/edit:$gallery"); die();


// Delete Image from Gallery
}elseif(isset($_GET['DELETE_IMAGE'])){

	$gallery = $_POST['gallery'];
	$images = $_POST['images'];
	
	$deleted = delete_image($gallery,$images);
	
	if($deleted) $_SESSION['IMAGES_DELETED'] = true;
	else $_SESSION['IMAGES_NON_DELETED'] = true;
	
	$smarty->clear_cache(null,"gallery_gallery|$gallery");
	$smarty->clear_cache(null,"gallery_goto|$gallery");
	$smarty->clear_cache(null,"gallery_gallery|index");
	$smarty->clear_cache('gallery_feed.tpl',$gallery); // Gallery page	
	$smarty->clear_cache('panel.tpl');

	redir('panel',"gallery/edit:$gallery");

// Delete Gallery
}elseif(isset($_GET['DELETE_GALLERY'])){

	$gallery = $_POST['gallery'];
	
	if(delete_gallery($gallery)) $_SESSION['GALLERY_DELETED'] = true;
	else $_SESSION['GALLERY_NOT_DELETED'] = true;
	
	$smarty->clear_cache("panel.tpl");
	
	redir('panel','panel'); die();

// :: Video features

// Upload Video mode
}elseif(isset($_GET['UPLOAD_VIDEO'])){

	$playlist = $_POST['playlist'];
	
	if(is_writable(VIDEOS_PATH . $playlist) && $playlist != null){

		$dir = VIDEOS_PATH . $playlist . '/';

		$num_videos_uploaded = 0;
		foreach ($_FILES['video']['error'] as $key => $error){
			if($error == UPLOAD_ERR_OK) {
				$tmp_name = $_FILES['video']['tmp_name'][$key];
				$name = $_FILES['video']['name'][$key];
				// If file is different, but have the same name, append a random number to the filename
				if(file_exists($dir . str_ireplace('.flv','.flv',$name))){
					// Check if file uploaded is identical to the file in server, by using sha1_file()
					if(@md5_file($tmp_name) == @md5_file($dir . str_ireplace('.flv','.flv',$name))) continue;	
					$name = $name . '_' . rand(10,99);
				}
				move_uploaded_file($tmp_name,$dir . str_ireplace('.flv','.flv',$name));
				getvideothumb($dir . str_ireplace('.flv','.flv',$name),true,false);
			}
			$num_videos_uploaded++;
		}
		
		foreach ($_FILES['video_hq']['error'] as $key => $error){
			if($error == UPLOAD_ERR_OK) {
				$tmp_name = $_FILES['video_hq']['tmp_name'][$key];
				$name = $_FILES['video_hq']['name'][$key];
				if(file_exists($dir . str_ireplace('_hq.flv','_hq.flv',$name))){
					if(md5_file($tmp_name) == md5_file($dir . str_ireplace('_hq.flv','_hq.flv',$name))) continue;
					$name = $name . '_' . rand(10,99);
				}
				move_uploaded_file($tmp_name,$dir . str_ireplace('_hq.flv','',$name) . '_hq.flv');
			}
		}
		if($num_videos_uploaded > 0) $copied = true;

	}else $copied = false;

	$smarty->clear_cache('header_title.tpl',$playlist);
	$smarty->clear_cache(null,"playlist|$playlist");
	$smarty->clear_cache(null,"showcase");

	if($copied) $_SESSION['VIDEO_UPLOADED'] = true;
	else $_SESSION['VIDEO_NOT_SAVED'] = true;

	redir('panel',"videos/upload:$playlist");
	
	die();
	
// Create Playlist
}elseif(isset($_GET['CREATE_PLAYLIST'])){

	$name = $_POST['name'];
	$title = $_POST['title'];

	$created = create_playlist($name,$title);

	$smarty->clear_cache(null,"showcase");
	$smarty->clear_cache("panel.tpl");

	if($created){
		$_SESSION['PLAYLIST_CREATED'] = true;
		redir('panel',"videos/upload:$name"); die();
	}else{
		$_SESSION['PLAYLIST_NOT_CREATED'] = true;
		redir('panel','panel'); die();
	}
	

// Delete Video(s)
}elseif(isset($_GET['DELETE_VIDEO'])){

	$playlist = $_POST['playlist'];
	$videos = $_POST['video'];	

	$deleted = delete_videos($playlist,$videos);
	
	$smarty->clear_cache('header_title.tpl',$playlist);
	$smarty->clear_cache(null,"playlist|$playlist");
	$smarty->clear_cache(null,'showcase');	
	$smarty->clear_cache('player.tpl',$playlist);
	$smarty->clear_cache('player_hq.tpl',$playlist);
	
	if($_POST['playlist'] != null) redir('panel',"videos/upload:$playlist");
	else redir('panel','videos');

// Delete Playlist	
}elseif(isset($_GET['DELETE_PLAYLIST'])){

	$playlist = $_POST['playlist'];

	$deleted = delete_playlist($playlist);
	
	$smarty->clear_cache('header_title.tpl',$playlist);
	$smarty->clear_cache(null,"playlist|$playlist");
	$smarty->clear_cache(null,"showcase");
	$smarty->clear_cache("panel.tpl");

	if($deleted) $_SESSION['PLAYLIST_DELETED'] = true;
	else $_SESSION['PLAYLIST_NOT_DELETED'] = true;

	redir('panel',"videos");
	
	die();

// :: Update

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

	if(!empty($_GET['template_file'])){
	
		// Redir to Panel if template does not exist
		if(!file_exists(SMARTY_TEMPLATES_PATH."templates/".$_GET['template_file']) && $_GET['template_file'] != 'panel.tpl'){
			$_SESSION['TEMPLATE_NO_EXIST'] = true;
			redir('panel','panel');
		}
	
		// Redirs for Fancy URL
		if(preg_match("/(\?template_file)/",basename($_SERVER['REQUEST_URI'])) && $use_rewrite){ header('location:'.DPORTAL_PATH.'/panel/style/template:'.$_GET['template_file']); die(); }
	
		$smarty->register_function('PANEL_MESSAGE','get_panel_message',false);
	
		$name = $_GET['template_file'];
		$file = SMARTY_TEMPLATES_PATH."templates/$name";
	
		$smarty->assign('NAME',$name);
		$smarty->assign('FILE',$file);
	
	}
	
	if(!empty($_POST['gallery'])){
		redir('panel','gallery/edit:' . $_POST['gallery']);
	}
	
	if(!empty($playlist)){
		if(is_readable(VIDEOS_PATH . "$playlist/.name")){
			$smarty->assign('GET_PLAYLIST',getplaylist($playlist));
			$smarty->assign('PLAYLIST',$playlist);
		}
	}
	
	if(!empty($_POST['playlist'])){
		redir('panel','videos/upload:' . $_POST['playlist']);
	}



	$tab = $_GET['tab'];
	$mode = $_GET['mode'];
	$gallery = $_GET['gallery'];
	$playlist = $_GET['playlist'];
	
	switch($tab){
		// general mode by default
		default :
			$smarty->assign('TAB','general');
			switch($mode){
				default		 : $smarty->assign('MODE','site_conf'); break;
				case 'robotstxt' : $smarty->assign('MODE','robotstxt'); break;
				case 'robotstxt' : $smarty->assign('MODE','site_conf'); break;
				case 'phpbb'	 : $smarty->assign('MODE','phpbb'); break;
				case 'memcached' : $smarty->assign('MODE','memcached'); break;
				case 'cse'	 : $smarty->assign('MODE','cse'); break;
			}
			break;
		
		case 'user_pass' :
			$smarty->assign('TAB','user_pass');
			break;
	
		case 'sections' :
			$sections   = get_sections("all");
			$categories = get_categories(true);
			$smarty->assign('SECTIONS',$sections);
			$smarty->assign('CATEGORIES',$categories);	
		
			$smarty->assign('TAB','sections');
			
			if(empty($categories)){
				switch($mode){
					default			 		: $smarty->assign('MODE','edit_sections'); break;
					case 'create_section'	: $smarty->assign('MODE','create_section'); break;
					case 'create_category'	: $smarty->assign('MODE','create_category'); break;
				}
			}else{
				switch($mode){
					default			 		: $smarty->assign('MODE','edit_sections'); break;
					case 'create_section'	: $smarty->assign('MODE','create_section'); break;
					case 'create_category'	: $smarty->assign('MODE','create_category'); break;
					case 'edit_category'	: $smarty->assign('MODE','edit_category'); break;
		
				}
			}
			break;
	
		case 'gallery' :
		
			$get_galleries = get_galleries();
			$smarty->assign('GALLERIES',$get_galleries);

			$smarty->assign('TAB','gallery');
			if(empty($get_galleries)){
				$smarty->assign('MODE','create');
			}else{
	
				switch($mode){
					default	:
						if(is_readable(DPORTAL_ABSOLUTE_PATH . "/images/gallery/$gallery/.name")){
							$get_gallery = explode("|",file_get_contents(DPORTAL_ABSOLUTE_PATH . "/images/gallery/$gallery/.name"));
							$gallery_title = str_replace('"','',$get_gallery[0]);
							
							$dircontents = getgallerycontents($gallery,null,null);
	
							$smarty->assign('IMAGELIST',$dircontents['list']);
							$smarty->assign('GALLERY_NAME',$gallery);
							$smarty->assign('GALLERY_TITLE',$gallery_title);
						}
						$smarty->assign('MODE','edit');
						break;
					case 'create' : $smarty->assign('MODE','create'); break;
				}
			}
			break;
			
		case 'videos' :
			$playlists = getshowcase();
			$smarty->assign('PLAYLISTS',$playlists);
			$smarty->assign('TAB','videos');
			
			if(empty($playlists)){
				$smarty->assign('MODE','create');
			}else{
				$get_playlist = getplaylist($playlist);
				$smarty->assign('PLAYLIST',$playlist);
				$smarty->assign('GET_PLAYLIST',$get_playlist);
				switch($mode){
					default			: $smarty->assign('MODE','upload'); break;
					case 'edit'		: $smarty->assign('MODE','edit'); break;
					case 'create'	: $smarty->assign('MODE','create'); break;
				}
			}
			break;
	
		case 'style' :
			$smarty->assign('TAB','style');
			switch($mode){
				default			: $smarty->assign('MODE','edit_style'); break;
				case 'template' :
					$templates = get_templates();
					$smarty->assign('TEMPLATES',$templates);
					$smarty->assign('MODE','template');
					break;
			}
			break;
	
		case 'backup' :
			$backups   = get_backup();
			$smarty->assign('BACKUPS',$backups);
			$smarty->assign('TAB','backup');
			break;
	}
	
	$langfiles = get_lang_files();
	$smarty->assign('LANGFILES',$langfiles);

	$smarty->register_function('PANEL_MESSAGE','get_panel_message',false);

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