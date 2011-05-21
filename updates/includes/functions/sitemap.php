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
	$secs = @fopen("content/.list", "rb") or die('<b>'.$LANG['fatal_error'].':</b> '.$LANG['missing_lists_file']);
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
	if(!is_dir(GALLERY_PATH)) return false;
	$dir_resource = opendir(GALLERY_PATH);
	while ($dirname = readdir($dir_resource)){
		if(nofakedir($dirname)){
			$galleries[] = $dirname;
		}
	}

	closedir($dir_resource);

	return $galleries;
}

function getentries_sitemap(){

	$handle = fopen(ENTRIES_PATH.'.entries', "rb");
	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		if($data[0] != null && file_exists(ENTRIES_PATH . $data[0])){
			$entries[] = array('name'=>$data[1],'updated'=>filemtime(ENTRIES_PATH . $data[0]));
		}
	}
	fclose($handle);

	if($entries != null) rsort($entries);

	if($entries != null) return $entries;
	else return null;

}

function getplaylists_sitemap(){
	$dir = opendir(VIDEOS_PATH);
	while ($dirname = readdir($dir)){
		if(file_exists(VIDEOS_PATH."/$dirname/.name")){
			$list[] = $dirname;
		}
	}
	closedir($dir);

	if($list != null) natsort($list);
	return $list; // Arrray or null
}

?>
