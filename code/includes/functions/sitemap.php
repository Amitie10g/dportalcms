<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  XML Sitemap generator from Sections         #
		#  and others thinks (sitemap.php)             #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU General Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

/* ABOUT THIS FUNCTION
 *
 * This function gets the list of the Sections, to pass to the XML parser
 *
 */

function getlist_sitemap(){
	$secs = @fopen("content/.list", "r") or die('<b>'.$LANG['fatal_error'].':</b> '.$LANG['missing_lists_file']);
	while (($data = fgetcsv($secs, 1000, ";")) !== FALSE) {	
		$name = $data[1];
		$timestamp = $data[4];
		$sections[] = array('name'=>$name,'timestamp'=>$timestamp);
	}
	fclose($secs);

	return $sections;
}

/* ABOUT THIS FUNCTION
 *
 * This function gets the list of the galeries, to pass to the XML parser
 *
 */

function getgal_sitemap(){
	$gal_dir = 'images/gallery';
	if (is_dir($gal_dir)) {
		$gal = opendir($gal_dir);
		  if ($$al) {
		      while (($conf_gal = readdir($gal)) !== false) {
		          if ($conf_gal != '.' && $conf_gal!= '..' && $conf_gal != '.htaccess'){
		              $get_gals[] = $conf_gal;
		          }
		      }
		      closedir($gal);
		  }
	}
	return $get_gals;
}

?>
