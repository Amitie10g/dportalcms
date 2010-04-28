<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Index/main portal (index.php)               #
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

// :: Handling data

$url = $_SERVER['REQUEST_URI'];

// If canonical URLs is enabled, redir if the Section name have a "_"
if(strpos($url,'_') && $use_rewrite){
	header('location:'.str_replace('_','/',$url),TRUE,301);
	die();
}

if(!isset($_GET['section']) && $_GET['section'] != 'home' && !isset($_GET['CATEGORIES']) && !isset($_GET['category'])){
	header('HTTP/1.1 307 Redirection');
	redir('index','home');
	die();
}


if($_GET['section'] != null){
	$get_section = $_GET['section'];
	if(strpos($get_section,'_') !== false){
		$category = explode('_',$get_section);
		$category_name = $category[0];
	}
}else $category_name = $_GET['category'];


// If filename give no exixts
if(!file_exists(CONTENT_PATH . $get_section)){
	header('HTTP/1.0 404 Not found');

	if(!$smarty->is_cached('404.tpl',$section)){
				
		$title = '404: Not found';

		$smarty->assign('TITLE',$title);
		$smarty->assign('SECTION',$section);		
	}

	$smarty->display('404.tpl'); die();
}



// Check if the File exists and is readable
if(file_exists(CONTENT_PATH . $get_section) && isset($get_section)){

	$smarty->caching = true;

	$section = $get_section;
	
	$getlist = getlist($section);
	
	$title = $getlist['title'];
	$exclusive = $getlist['exclusive'];
	$timestamp = $getlist['timestamp'];

	$last_mod = gmdate("D, d M Y H:i:s", $timestamp);
	header("Last-Modified: $last_mod GMT");

	$smarty->assign('FILENAME',CONTENT_PATH . $section);
	
	if(!$smarty->is_cached('category.tpl',$category_name)){
		$items = get_sections($category_name);
		$category_title = get_category_title($category_name);
	}
	
	$is_index = true;
	
	$smarty->assign('SECTION',$section);
	$smarty->assign('EDITABLE',true);

// Category page
}elseif(isset($_GET['category'])){
	
	$smarty->caching = true;
	
	$items = get_sections($category_name);
	$category_title = get_category_title($category_name);
	
	if($category_title == null) redir('index','home');

	$title = $category_title;

	$is_category = true;

// Categories page	
}elseif(isset($_GET['CATEGORIES'])){

	$smarty->caching = true;

	$is_categories = true;
	if(!$smarty->is_cached('categories.tpl')) $categories = get_categories();
	
	$title = "Categories on this site";  // Replace with Language
}

$smarty->assign('CATEGORY_NAME',$category_name);
$smarty->assign('CATEGORY_TITLE',$category_title);

$smarty->assign('TITLE',$title);

$smarty->assign('ITEMS',$items);

$smarty->assign('IS_CATEGORY',$is_category);
$smarty->assign('IS_CATEGORIES',$is_categories);

$smarty->display('header.tpl');
$smarty->caching = 2;$smarty->cache_lifetime = 262800;
$smarty->display('header_title.tpl',"$category_name|$section");
$smarty->caching = false;

$smarty->display('header_more.tpl');
$smarty->display('menu_h.tpl');
$smarty->caching = 2;$smarty->cache_lifetime = 262800;
if($is_index || $is_category ) $smarty->display('menu_dynamic.tpl',$category_name);
$smarty->caching = false;
$smarty->display('menu_f.tpl');

$smarty->display('header_f.tpl');

$smarty->display('sidebar_h.tpl');
$smarty->display('sidebar_user_data.tpl');
$smarty->display('sidebar_c.tpl');
$smarty->display('sidebar_f.tpl');

// If is the All Categories page
if($is_categories){

	$smarty->assign('CATEGORIES',$categories);
	$smarty->assign('IS_CATEGORIES',true);

	$smarty->caching = 2;$smarty->cache_lifetime = 262800;
	$smarty->display('categories.tpl');	
	$smarty->caching = false;

// This is Section in Category
}elseif($is_category){

	$smarty->assign('IS_CATEGORY',$is_category);
	
	$smarty->caching = 2;$smarty->cache_lifetime = 262800;
	$smarty->display('category.tpl',$category_name);
	$smarty->caching = false;

// This is Conntent page
}else{

	if(($exclusive&&$loged_in)||!$exclusive){
		$smarty->caching = 2;$smarty->cache_lifetime = 262800;
		$smarty->display('content.tpl',$section);
	}else{
		$smarty->caching = false;
		$smarty->display('login.tpl');
	}

}
$smarty->display('footer.tpl');

require_once('includes/footer.php');

?>
