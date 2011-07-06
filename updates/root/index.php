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
require_once('config/config.php');

// :: Handling data

$url = $_SERVER['REQUEST_URI'];

// If canonical URLs is enabled, redir if the Section name have a "_"
if(strpos($url,'_') && $use_rewrite){
	header('location:'.str_replace('_','/',$url),true,301);
	die();
}

if($_GET['section'] == null && $_GET['section'] != 'home' && !isset($_GET['CATEGORIES']) && !isset($_GET['category'])){
	header('HTTP/1.1 301 Redirection',true,301);
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
	$smarty->assign('EXCLUSIVE',$exclusive);

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

// PDF version (NEW!). Available but not used. You can add a link to PDF version using my function
if(isset($_GET['PDF'])){

	$file = gzopen(CONTENT_PATH . $get_section,'r');
	
	$referer = 'http://'.$_SERVER['SERVER_NAME'].str_replace(array('&PDF','.pdf'),array('','.html'),$_SERVER['REQUEST_URI']);
	
	//class HTML2FPDF declared in config.php as $pdf
	
	$pdf->setAuthor($admin_user);
	$pdf->setTitle($title);
	$pdf->setCompression(true);
	
	$pdf->SetMargins(15,15,10);
	
	$pdf->SetURLReferer($referer);
	
	$pdf->SetHeaderContent(utf8_decode($title),true);
	$pdf->SetFooterContent(utf8_decode('<center>'.$LANG['from'] . '<a href="' . $referer . '">' . $sitename . '</a>. '), utf8_decode("© $admin_user. All rights reserved</center>"),true);

	// Configure the Page and Font for Title
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',10);
	// Print the PDF content
	//Uncompresed text up to 1 MiB (neither page should be greater than 500 KiB, generally).
	$pdf->WriteHTML(gzread($file,1048576));
	// Output the PDF to STDOUT
	$pdf->Output("$title.pdf",'D');
	die();
}

$smarty->assign('CATEGORY_NAME',$category_name);
$smarty->assign('CATEGORY_TITLE',$category_title);

if(($exclusive&&$loged_in)||!$exclusive) $smarty->assign('TITLE',$title);
else $smarty->assign('TITLE',$LANG['please_login']);

$smarty->assign('ITEMS',$items);

$smarty->assign('IS_CATEGORY',$is_category);
$smarty->assign('IS_CATEGORIES',$is_categories);

$smarty->display('header.tpl');
if(($exclusive&&$loged_in)||!$exclusive){
	$smarty->caching = 2;
	$smarty->cache_lifetime = 262800;
	$smarty->display('header_title.tpl',"$category_name|$section");
	$smarty->caching = false;
}else{
	$smarty->caching = false;
	$smarty->display('header_title.tpl');
}
if(!isset($_GET['PRINT'])) $smarty->display('header_more.tpl');
$smarty->display('header_close.tpl');
$smarty->display('body_h.tpl');
if(!isset($_GET['PRINT'])){
	$smarty->display('container.tpl');
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
}
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
		if(!isset($_GET['PRINT'])) $smarty->display('content_h.tpl');
		$smarty->caching = 2;$smarty->cache_lifetime = 262800;
		$smarty->display('content.tpl',$section);
		$smarty->caching = false;
		if(!isset($_GET['PRINT'])) $smarty->display('content_f.tpl');
	}else{
		$smarty->caching = false;
		$smarty->display('login.tpl');
	}

}
if(!isset($_GET['PRINT'])) $smarty->display('footer_page.tpl');
$smarty->display('footer.tpl');

require_once(INCLUDES_PATH . 'footer.php');

?>
