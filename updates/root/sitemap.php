<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  XML Sitemap generator (sitemap.php)         #
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

$mode = $_GET['mode'];

if($mode == 'XML' || isset($_GET['XML'])){
	header('content-type:text/xml');
	
	$smarty->caching = true;
	
	if(!$smarty->is_cached('sitemap_xml.tpl')){
		$smarty->assign('SECTIONS',getlist_sitemap());
		$smarty->assign('GALLERIES',getgal_sitemap());
		$smarty->assign('ENTRIES',getentries_sitemap());
		$smarty->assign('VIDEOS',getplaylists_sitemap());
	}
	
	$smarty->display('sitemap_xml.tpl');
	
	require_once(INCLUDES_PATH.'/footer.php');
}else{

	if(!$smarty->is_cached('sitemap_html.tpl')){
		$smarty->assign('TITLE','Sitemap');
		$smarty->assign('SECTIONS',getlist_sitemap());
		$smarty->assign('GALLERIES',getgal_sitemap());
		$smarty->assign('ENTRIES',getentries_sitemap());
		$smarty->assign('PLAYLISTS',getshowcase_sitemap());
	}

	$smarty->display('header.tpl');
	$smarty->display('header_title.tpl');
	
	if(!isset($_GET['PRINT'])) $smarty->display('header_more.tpl');
	$smarty->display('header_close.tpl');
	$smarty->display('body_h.tpl');
	if(!isset($_GET['PRINT'])){
		$smarty->display('container.tpl');
		$smarty->display('menu_h.tpl');
		$smarty->display('menu_f.tpl');

		$smarty->display('header_f.tpl');
	
		$smarty->display('sidebar_h.tpl');
		$smarty->display('sidebar_user_data.tpl');
		$smarty->display('sidebar_c.tpl');
		$smarty->display('sidebar_f.tpl');
	}
	
	if(!isset($_GET['PRINT'])) $smarty->display('content_h.tpl');
	$smarty->caching = 2;$smarty->cache_lifetime = 262800;
	$smarty->display('sitemap_html.tpl',$section);
	$smarty->caching = false;
	
	if(!isset($_GET['PRINT'])) $smarty->display('content_f.tpl');
	
	if(!isset($_GET['PRINT'])) $smarty->display('footer_page.tpl');
	$smarty->display('footer.tpl');



}

?>
