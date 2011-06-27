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
	$secs = @fopen(CONTENT_PATH."/.list", "rb") or die('<b>'.$LANG['fatal_error'].':</b> '.$LANG['missing_lists_file']);
	while (($data = fgetcsv($secs, 1000000, ";")) !== FALSE) {	
		$name = $data[1];
		if(strpos($name,'_')){
			$name_category = explode('_',$name);
			$category = $name_category[0];
		}
		$title = $data[2];
		$timestamp = $data[4];
		$sections[$category][] = array('name'=>$name,'timestamp'=>$timestamp,'title'=>$title);
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
			$title = file_get_contents(GALLERY_PATH . $dirname . '/.name');
			$title = explode('|',$title);
			$galleries[] = array('dirname'=>$dirname,'title'=>str_replace('"','',$title[0]));
		}
	}

	closedir($dir_resource);

	return $galleries;
}

function getentries_sitemap(){

	$handle = fopen(ENTRIES_PATH.'.entries', "rb");
	while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
		if($data[0] != null && file_exists(ENTRIES_PATH . $data[0])){
			$entries[] = array('name'=>$data[1],'title'=>$data[2],'updated'=>filemtime(ENTRIES_PATH . $data[0]));
		}
	}
	fclose($handle);

	if($entries != null){
		krsort($entries);
		return $entries;
	}else return null;
}

function getshowcase_sitemap(){

	global $user_admin;

	$dir = opendir(VIDEOS_PATH);
	while ($dirname = readdir($dir)){
		if(!nofakedir($dirname)) continue;
		if(is_file(VIDEOS_PATH."$dirname/.name")){
			$title = file_get_contents(VIDEOS_PATH."/$dirname/.name");
			$videos = getplaylist_sitemap($dirname);
			$list[$dirname] = array('title'=>$title,'videos'=>$videos);
		}
	}
	closedir($dir);

	if($list != null) natsort($list);
	return $list; // Arrray or null
}


function getplaylist_sitemap($playlist){

	if(!is_dir(VIDEOS_PATH . $playlist) && !is_readable(VIDEOS_PATH . $playlist)) return false;

	$dir = opendir(VIDEOS_PATH . $playlist);
	while ($filename = readdir($dir)){

		if(nofakedir($filename) && !strpos($filename,"_hq") && ext($filename) == 'flv'){
			$split_file = explode('.',$filename);
			$uri = base64_encode(strrev(base64_encode("$playlist;$filename")));
			$list[] = array('title'=>$split_file[0],'uri'=>$uri);
		}
	}

	if($list != null) sort($list);
	return $list;
}



?>
