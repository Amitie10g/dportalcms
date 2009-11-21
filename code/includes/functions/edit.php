<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Functions for Editor (edit.php)             #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// bool create_section(string filename, string title)
function create_section($filename,$title){

	global $LANG;

	if(file_exists(CONTENT_PATH.$filename)) return 2;

	$timestamp = time();
	
	$check_file = preg_match("/^([\a-z0-9]{3,15}_){0,1}([\a-z0-9]{3,15})$/",$filename);
	$check_title = preg_match("/[\w\W]{3,30}/",$title);

	if($check_file>=1&&$check_title>=1){
	    
		$file = fopen(CONTENT_PATH.$filename,'xb') or die("Can't create the File! Please check if file alredy exists or check the permissions");
		$list = fopen(CONTENT_PATH.'.list', "ab") or die("Missing or inaccesible List file! Please be sure that the file exist and is writable");

		$output_list = "0;\"$filename\";\"$title\";1;$timestamp\n";
		$output_file = $LANG['content_newly_created'];

		if(fwrite($list,$output_list)&&fwrite($file,$output_file)) $created = true;	

		fclose($list);fclose($file);

		if($created) return true;

	}else return false;
}

/* IMPORTANT:
 *
 * Here are a little Bug, when if the Content recived is empty
 * (null), the List file will be empty! This can be solved
 * breaking with return false if the content recived is null
 *
*/

// bool edit_section(string filename, string title, string content, int timestamp[, int exclusive, string category])
function edit_section($filename,$title,$content,$timestamp,$exclusive = null,$category = null){

	// Checks for content. If is null, returns false and
	// break the Function in order to prevent the incorrect
	// deletion of the .list contents.
	// When the file is newly created (see previous function),
	// these is empty and must be filled with the content.
	if($content == null) return false;
	if($title == null) return false;

	// Set the String for replace in the Sections file
	$list_update = "0;$filename;\"$title\";$exclusive;$timestamp";

	// Open the File for read
	$list_file = fopen("content/.list", "rb") or die('Missing or inaccesible Filelist!');
	while (($data = fgetcsv($list_file, 1000, ";")) !== FALSE) {

		// Ask if the filename variable matchs. If match,
		// replace the entry line with de updated information.
		// Elsewhere, parse the entry line.
		// DO NOT	 remove de point before the '='!!!
		if($data[1] == $filename) $put_list .= $list_update . "\n";
		else $put_list .= $data[0] . ';' . $data[1] . ';"' . $data[2] . '";' . $data[3] . ';' . $data[4] . "\n";

	}
	fclose($list_file);

	// Set the Output recived, filtering all content
	$output = preg_replace("/..\/editor\//",$curr_dir.'editor/',
	preg_replace("/target=\"[_\w]+\"/","rel=\"external\"",stripslashes($content)));

	// Open the files for write
	$file = fopen("content/$filename",'wb') or die('Missing or inaccesible File!');
	$list = fopen("content/.list",'wb') or die('Missing or inaccesible Filelist');
	flock($file,2);
	flock($list,2);

	// Ask if the operations are successful
	if(fwrite($file,$output)&&
	fwrite($list,$put_list)) $updated = true;
	
	// Closes the opened files
	fclose($file);
	fclose($list);

	// returns true if success
	if($updated) return true;
}


/* IMPORTANT (see final part of the function):
 *
 * THE FILE MUST BE CLOSED BEFORE RETURNING THE FUNCTION!!!
 *
 * Incorrect:
 *
 * 		if(fwrite($list,$put_list)&&$unlinked) return true;
 * 		else return false;
 *
 *		fclose($list);
 *
 * The file will be not closed, because the return is
 * declared BEFORE closing the file, and, of course,
 * 'brake' (broken) the Function here.
 * 
 */
// bool delete_section(string filename)
function delete_section($filename){

	// Open the File for read
	$list_file = fopen("content/.list", "rb") or die();
	while (($data = fgetcsv($list_file, 1000, ";")) !== FALSE) {

		if($data[1] == $filename) $put_list .= null;
		else $put_list .= $data[0] . ';' . $data[1] . ';"' . $data[2] . '";' . $data[3] . ';' . $data[4] . "\n";

	}
	fclose($list_file);

	$list = fopen("content/.list",'wb');	flock($list,2);

	if(file_exists("content/$filename")) $unlinked = unlink("content/$filename");

	// Ask if the operations are successful before returning.
	if(fwrite($list,$put_list)&&$unlinked) $deleted = true;
	else $deleted = false;
	
	// Now, close the File, and return the value of the
	// last operation (true or false)
	fclose($list); return $deleted; // This is correct

}

?>
