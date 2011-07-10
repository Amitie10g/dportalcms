<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  HTML and XML Sitemap gen (sitemap.php)      #
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
	
	$getentries = get_blog_entries();

	if(!$smarty->is_cached('sitemap_xml.tpl')){
		$smarty->assign('ENTRIES',$getentries);
		$smarty->assign('LAST_ENTRY',$getentries[0]['updated']);
	}
	
	$smarty->display('sitemap_xml.tpl');
}else{

	// Get the entries for the Sidebar, and order by Year and date
	$smarty->caching = true;
	if(!$smarty->is_cached('sitemap_html.tpl') && !$smarty->is_cached('sidebar_blog.tpl')){
		
		if(($entries = get_blog_entries()) != null){
		
			foreach($entries as $item){
				$year = date('Y',$item['created']);
				$month = date('m',$item['created']);
				$entries_sidebar[$year][$month][] = $item;
			}
			
			$smarty->assign('TITLE','Sitemap');
			
			$smarty->assign('ENTRIES_SIDEBAR',$entries_sidebar);
		}
	}
	$smarty->caching = false;

	$smarty->display('header.tpl');
	$smarty->display('header_title.tpl');
	
	if(!isset($_GET['PRINT'])) $smarty->display('header_more.tpl');
	$smarty->display('header_close.tpl');
	$smarty->display('body_h.tpl');
	if(!isset($_GET['PRINT'])){
		$smarty->display('container.tpl');
		$smarty->display('sidebar_h.tpl');
		$smarty->display('sidebar_user_data.tpl');
		
		$smarty->is_cached = 2; $smarty->cache_lifetime = 1296000;
		$smarty->display('sidebar_blog.tpl');
		$smarty->caching = false;
		
		$smarty->display('sidebar_c.tpl');
		$smarty->display('sidebar_f.tpl');
	}
	
	if(!isset($_GET['PRINT'])) $smarty->display('content_h.tpl');
	$smarty->caching = 2;$smarty->cache_lifetime = 262800;
	$smarty->display('sitemap_html.tpl');
	$smarty->caching = false;
	
	if(!isset($_GET['PRINT'])) $smarty->display('content_f.tpl');
	if(!isset($_GET['PRINT'])) $smarty->display('footer_page.tpl');
	
	$smarty->display('footer.tpl');
}
require_once(INCLUDES_PATH.'/footer.php');
?>
