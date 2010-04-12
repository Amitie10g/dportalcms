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
	
// Edit mode
if(isset($filename)&&!isset($_GET['SAVE'])&&!isset($_GET['SAVED'])){

	if(!is_writable("content/$filename")){
		$_SESSION['SECTION_NOT_EXIST'] = true;
		redir('panel','panel');die();
	}

	$file = "content/$filename";

	$list = @fopen("content/.list", "r") or die("<b>Fatal error:</b> Missing or inaccesible List file! Please be sure that the file exist and is writable");
	while (($data = fgetcsv($list, 1000, ";")) !== FALSE) {	
		if($data[1] == $filename){
			$title = $data[2];
			$exclusive = $data[3];
			$category = $data[0];
		}
	}
	fclose($list);

	$smarty->assign('SITENAME',$sitename);
	$smarty->assign('TITLE',$title);
	$smarty->assign('FILE',$file);
	$smarty->assign('FILENAME',$filename);
	$smarty->assign('EXCLUSIVE',$exclusive);
	$smarty->assign('SID',$user->data['session_id']);

	$smarty->display('editor_h.tpl');	
	$smarty->display('editor_f.tpl');	


// Save mode
}elseif(isset($_GET['SAVE'])&&!isset($_GET['SAVED'])){

	$filename = $_POST['file'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	$exclusive = $_POST['exclusive'];
	$category = $_POST['category'];
	$timestamp = time();

	if($content == null){
		$_SESSION['content_empty'] = true;
		redir('edit',$filename);die();
	}else	if($title == null){
		$_SESSION['title_empty'] = true;
		redir('edit',$filename);die();
	}

	if(edit_section($filename,$title,$content,$timestamp,$exclusive)) {

		$_SESSION['SAVED'] = true;
		$_SESSION['section'] = $filename;

		$_SESSION['title_empty'] = null;
		$_SESSION['title_empty'] = null;

		$smarty->clear_cache('content.tpl',$filename);
	}

	header('location:'.$_SERVER['PHP_SELF'].'?SAVED');


}elseif(isset($_GET['SAVED'])){
	$smarty->assign('UPDATED',$_SESSION['SAVED']);
	$smarty->assign('SECTION',$_SESSION['section']);
	$smarty->assign('SITENAME',$sitename);	
	$smarty->display('saved.tpl');
	session_unregister('SAVED');
	session_unregister('section');
}

include_once('includes/footer.php');

?>
