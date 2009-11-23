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
require_once('includes/header.php');

header('content-type:text/xml');

$smarty->caching = true;

if(!$smarty->is_cached('sitemap_xml.php')){
	$smarty->assign('SECTIONS',getlist_sitemap());
	$smarty->assign('GALLERIES',getgal_sitemap());
}

$smarty->display('sitemap_xml.tpl');

require_once('includes/footer.php');

?>
