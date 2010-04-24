<?php
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Sections editor (edit.php)                  #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

define('DPORTAL',true);
require_once('includes/header.php');

// If the user is not the Administrator, redir to Home
if(!$user_admin){
	// Colocar un Estado 403 y/o redirigir
	header($LANG['403']);
	redir('home','index');
	die();
}

/* NOTE:
 *
 * $filename stands for the File Name recived from the URL, and
 * $file is the Variable with the Path, four use in {fetch}
 *
 */

$filename = $_GET['section'];

// Mode Edit
if(isset($filename)&&!isset($_GET['SAVE'])&&!isset($_GET['SAVED'])){

	if($filename == null || !is_writable(CONTENT_PATH . "$filename")){
		$_SESSION['SECTION_NOT_EXIST'] = true;
		redir('panel','panel');die();
	}

	if(strpos($filename,"_")){
		$category = explode('_',$filename);
		$category = $category[0];
	}

	$file_absolute_path = CONTENT_PATH . "$filename";

	$list = getlist($filename);
	
	$title = $list['title'];
	$exclusive = $list['exclusive'];

	$smarty->assign('SITENAME',$sitename);
	$smarty->assign('TITLE',$title);
	$smarty->assign('FILE',$file_absolute_path);
	$smarty->assign('FILENAME',$filename);
	$smarty->assign('CATEGORY',$category);
	$smarty->assign('EXCLUSIVE',$exclusive);
	$smarty->assign('SID',$user->data['session_id']);

	$smarty->display('editor_h.tpl');	
	$smarty->display('editor_f.tpl');	


// Mode Save
}elseif(isset($_GET['SAVE'])&&!isset($_GET['SAVED'])){ 

	$filename = $_POST['file'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	$exclusive = $_POST['exclusive'];
	$category = $_POST['category'];
	$timestamp = time();
	
	if($content == null){
		$_SESSION['content_empty'] = true;
		redir('edit',$filename); die();
	}elseif($title == null){
		$_SESSION['title_empty'] = true;
		redir('edit',$filename); die();
	}

	if(edit_section($filename,$title,$content,$timestamp,$exclusive)) {

		$_SESSION['SAVED'] = true;
		$_SESSION['section'] = $filename;
	}
	
	$smarty->clear_cache('menu_dynamic.tpl');
	$smarty->clear_cache('menu_dynamic.tpl',$category);
	$smarty->clear_cache('category.tpl');
	$smarty->clear_cache('category.tpl',$category);
	$smarty->clear_cache('categories.tpl');
	$smarty->clear_cache('content.tpl',$filename);

	redir('saved','saved');

// Mode Saved
}elseif(isset($_GET['SAVED'])){
	$smarty->assign('UPDATED',$_SESSION['SAVED']);
	$smarty->assign('SECTION',$_SESSION['section']);
	$smarty->assign('SITENAME',$sitename);	
	$smarty->display('saved.tpl');
	unset_global_var('SAVED');
	unset_global_var('section');
}

include_once('includes/footer.php');

?>
