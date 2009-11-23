<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Functions for Main Portal (main.php)        #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
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
	$list = @fopen(CONTENT_PATH.'/.list', "r") or die('<b>Fatal error:</b> Missing or inaccesible List file! Please be sure that the file exist or have the proper permissions');
		
	while (($data = fgetcsv($list, 1000, ";")) !== FALSE) {
		if($data[1] == $section) $set_list = array('title'=>$data[2],'exclusive'=>$data[3],'timestamp'=>$data[4]);
	}
	fclose($list);

	return $set_list;
}


/* This function return the Contents of the Section and
 * data provided to Smarty variables *
 * This function is DEPRECATED and is replaced
 * with {fetch} in Template. Please don't call.
*/
/*
// Smarty_variables getcontent(string section, string title, string content, bool esclusive, int timestamp)
function getcontent($section,$title,$exclusive,$timestamp){

	global $smarty; global $sitename; global $description; global $loged_in;

	// If session is not started, dont parse
	if(($exclusive&&$loged_in)||!$exclusive){
		if(!$smarty->is_cached('content.tpl',$section)){
			$content = fopen(CONTENT_PATH."/$section",'r');
			$filesize = filesize(CONTENT_PATH."/$section");
			$readed = true;
		}
	}

	$smarty->assign('TITLE',$title);
	if(!$smarty->is_cached('content.tpl',$section)){
	if($readed) $smarty->assign('CONTENT',@fread($content,$filesize));@fclose($content);}
	
	$last_mod = gmdate("D, d M Y H:i:s", $timestamp);
	header("Last-Modified: $last_mod GMT");
}
*/

// This function is DEPRECATED
// void get404(string section)
function get404($section){

	global $smarty; global $getsidebar; global $sitename; global $description;

	if(!$smarty->is_cached('404.tpl',$section)){
				
		$title = '404: Not found';

		$smarty->assign('TITLE',$title);
		$smarty->assign('SECTION',$section);		
	}
}

?>
