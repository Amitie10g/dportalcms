<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Index/main portal (index.php)               #
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

// :: Start the Application

$get_section = $_GET['section'];
$url = $_SERVER['REQUEST_URI'];
	
if(!isset($_GET['section']) && $_GET['section'] != 'home'){
	header('HTTP/1.1 307 Redirection');
	redir('index','home');
	die();
}

// If filename give no exixts
if(!file_exists("content/$get_section")){
	header('HTTP/1.0 404 Not found');

	if(!$smarty->is_cached('404.tpl',$section)){
				
		$title = '404: Not found';

		$smarty->assign('TITLE',$title);
		$smarty->assign('SECTION',$section);		
	}

	$smarty->display('404.tpl'); die();
}


if(strpos($url,'_')&&$use_rewrite){
	header('Location:'.str_replace('_','/',$url),TRUE,301);
	die();
}


// Check if the File exists and is readable
if(file_exists("content/$get_section")&&isset($get_section)){

	$smarty->caching = true;

	$section = $get_section;
	
	$getlist = getlist($section);
	
	$title = $getlist['title'];
	$exclusive = $getlist['exclusive'];
	$timestamp = $getlist['timestamp'];

	$last_mod = gmdate("D, d M Y H:i:s", $timestamp);
	header("Last-Modified: $last_mod GMT");

	$smarty->assign('FILENAME',"content/$section");
	$smarty->assign('TITLE',$title);}

$smarty->assign('SECTION',$section);
$smarty->assign('EDITABLE',true);

$smarty->caching = false;
$smarty->display('header.tpl',$section);
$smarty->display('header_more.tpl');

$smarty->display('sidebar_h.tpl');
$smarty->display('sidebar_user_data.tpl');
$smarty->display('sidebar_c.tpl');
$smarty->display('sidebar_f.tpl');

if(($exclusive&&$loged_in)||!$exclusive){
	$smarty->caching = 2;$smarty->cache_lifetime = 262800;
	$smarty->display('content.tpl',$section);
}else{
	$smarty->caching = false;
	$smarty->display('login.tpl');
}

$smarty->display('footer.tpl');

require_once('includes/footer.php');

?>
