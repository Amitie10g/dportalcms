<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Functions for Main Portal (main.php)        #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU General Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

/* This function return the List of sections, form the List file.
 *
 * 'section' parameter are required. Elsewhere, return Error.
*/
// array getlist(string section)
function getlist($section){

	// Gets the data of the CVS file list
	$list = fopen(CONTENT_PATH.'.list', "rb") or die('<b>Fatal error:</b> Missing or inaccesible List file! Please be sure that the file exist or have the proper permissions!!!');
		
	while (($data = fgetcsv($list, 1000, ";")) !== FALSE) {
		if($data[1] == $section) $set_list = array('title'=>$data[2],'exclusive'=>$data[3],'timestamp'=>$data[4]);
	}
	fclose($list);

	return $set_list;
}


// void get404(string section)
function get404($section){

	global $smarty; global $getsidebar; global $sitename; global $description;

	if(!$smarty->is_cached('404.tpl',$section)){
				
		$title = '404: Not found';

		$smarty->assign('TITLE',$title);
		$smarty->assign('SECTION',$section);		
	}
}

/* ABOUT THIS FUNCTION
 * 
 * This function get the List of Sections in order to be displayed in Section selection
 *
 */

// array get_sections([string category])
function get_sections($category = null){

	if($category == "all") $all = true;
	
	$secs = @fopen(CONTENT_PATH . ".list", "rb") or die('Missing list file!');
	while (($data = fgetcsv($secs, 1000, ";")) !== FALSE){
		$name = $data[1];
		$title = $data[2];
		$exclusive = $data[3];
		if((strpos($name,"_") !== false) && $category != null && $category != "all"){
			$category_file = explode("_",$name);
			$category_file = $category_file[0];
		}
	
		if((($category == $category_file && $category != null) || ($category == null && strpos($name,"_") === false)) || $all) $sections[] = array('name'=>$name,'title'=>$title,'filename'=>CONTENT_PATH . $name,'custom_icon_path'=>DPORTAL_ABSOLUTE_PATH.'images/'.$name.'_logo.png','exclusive'=>$exclusive,'custom_icon'=>basename(DPORTAL_ABSOLUTE_PATH.'images/'.$name.'_logo.png'));
	}
	fclose($secs);
 
	return $sections;
}

/* ABOUT THIS FUNCTION
 * 
 * This function get the List of Sections in order to be displayed in Section selection
 *
 * Database for Sections and Categories are not linked.
 *
 */

// array get_categories([bool anywrere])
function get_categories($anywhere = false){
  
	$cats = @fopen(CONTENT_PATH . ".categories", "rb") or die('Missing list file!');
	while (($data = fgetcsv($cats, 1000, ";")) !== FALSE){
		if(get_sections($data[0]) != null || $anywhere) $categories[] = array('name'=>$data[0],'title'=>$data[1]);
	}
	fclose($cats);
 
	return $categories;
}

// string get_category_title([string category_name])
function get_category_title($category_name = null){

	if($category_name == null) return "Main";

	// Get Title form Database
	$category = fopen(CONTENT_PATH . ".categories",'rb') or die('Missing list file!');
	while(($data = fgetcsv($category, 1000, ";")) !== false){
		if($category_name == $data[0]) $category_title = $data[1];
	}
	return $category_title;
}

?>
