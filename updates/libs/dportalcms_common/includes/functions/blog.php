<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Functions for Blog (blog.php)               #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

/* Get the Entries for Index and Feed Index
 *
 * get_blog_entries() will get the List of entries and check if the Entry file (id) exists,
 * Reverse the order of data and return the Array.
 *
 * Parameters:
 *
 *	* int limit
 *	   The limit of entries displayed per page
 *
 * Returned values
 *
 *	This function will return an Array of the data, or NULL if no data is present
 *
*/

// array get_blog_entries([int limit])
function get_blog_entries($limit = 0){

	if(!is_integer($limit)) $limit = 0;

	$num = 0;
	$handle = fopen(ENTRIES_PATH.'.entries', "rb") or die('Missing or inaccessible entries file');
	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		if(!empty($data[0]) && file_exists(ENTRIES_PATH . $data[0]))
			$entries[] = array('id'=>$num,'file' =>ENTRIES_PATH.$data[0],'name'=>$data[1],'title'=>$data[2],'tags'=>$data[3],'user'=>$data[4],'created'=>$data[5],'updated'=>filemtime(ENTRIES_PATH.$data[0]),'atom_id'=>sha1($ents[0]));
		$num++;
	}	
	fclose($handle);

	// Reverse the order of Array
	if($entries != null) rsort($entries);
	
	// Eliminates the elements of the Array from the Offset limit.
	if($limit > 0) array_splice($entries,$limit);

	if($entries != null) return $entries;
	else return null;
}


/* Get the metadata of the Entry
 *
 * get_blog_entry() will return the metadata of a Entry by passing their Name.
 *
 * Parameters
 *
 *
 *
*/

// array get_blog_entry(string name)
function get_blog_entry($entry_name){
	
	$handle = fopen(ENTRIES_PATH.'.entries', "rb") or die('Missing or inaccessible entries file');
	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		if($entry_name == $data[1]){
			$entry = array('id'=>$data[0],'file'=>ENTRIES_PATH.$data[0],'name'=>$data[1],'title'=>$data[2],'tags'=>$data[3],'user'=>$data[4],'created'=>$data[5],'updated'=>filemtime(ENTRIES_PATH.$data[0]));
		}
	}
	fclose($handle);

	if($entry != null && file_exists(ENTRIES_PATH.$data[0])) return $entry;
	else return null;
}


/* ABOUT THIS FUNCTION:
 *
 * This Functions is used when a new Entry is created
 *
 * When a Entry is updated, a parameter 'Name' is required.
 * The Edidor sends these parameters, but in this case,
 * the Name is not defined and sended, and them must be
 * parsed from the Title recived by the Editor.
 *
 * Title is converted to a Alphanumerical-only string,
 * without spaces or any spececial characters.
 *
 * Also, and more impprtant, checks if Name (once parsed) exist
 * in Filelist. Especifically, finds in Rows if Field 'name'
 * coincids with the Name parsed. If them, breaks the operation,
 * and sets the Name adding a Random number between 10 to 99
 * at the end of String. If not, Name is passes without more changes.
 * 
 * Parameters
 *
 *	String title: The Title recived from the Form.
 *
 * Returned values:
 *
 *	The Name converted string from Title
 *
 * Note: If List file does not exists,Function outputs a 'Fatal error'
 *
*/

// string title2name(string title)
function title2name($title){

	// Sets the Name, replacing any non-ASCII character, and delete HTML entities
	$name = substr_replace(strtolower(
	preg_replace("/([-]{2,})/","-",preg_replace(array("/([^\w\s]*(&)*((acute|grave|tilde|sup|edill|umi|slash|eth|circ|cedil|);)*)*/","/[\s]/"),array("","-"),htmlentities(utf8_decode($title))))),'',30);
	
	die($name);
	
	// Check if entry Name exist
	$chkentries = fopen(ENTRIES_PATH.'.entries', "rb") or die('Missing or inaccesible entries file');
	while (($data = fgetcsv($chkentries, 1000, ";")) !== FALSE) {
		if($name == $data[1]) { $name = $name . rand(10,99); break; }
	}
	fclose($chkentries);

	return $name;

}


// bool blog_new_entry(string timestamp, string title, mixed user, string content[,string tags])
function blog_new_entry($timestamp,$name,$title,$content, $tags = null){

	global $use_phpbb;
	
	$user = PHPBB_USER_ID;

	if($name == null) return false;
	
	$id = sha1(uniqid($timestamp,true));
	if(file_exists(ENTRIES_PATH.$id)) return false;

	// Crate a new File with content and compress (Create mode fails!!!)
	if($entrie_file = gzopen(ENTRIES_PATH.$id,'wb9')){
		flock($entrie_file,LOCK_EX);
		if(gzwrite($entrie_file,$content)) $write_file = true;
		gzclose($entrie_file);
	}else return false;

	// string id, string name, string title, string tags, mixed user, int timestamp
	$metadata = "$id;$name;\"$title\";\"$tags\";\"$user\";$timestamp\n";

	// Write to List the new entry metadata
	$metadata_writen = file_put_contents(ENTRIES_PATH.'.entries',$metadata,FILE_APPEND);
	
	// Create the new Comments file, also, gzipped
	$comments_file = fopen(COMMENTS_PATH.$id,'xb') or die('Missing or inaccessible entry file');
	fclose($comments_file);

	if($write_file !== false && $update_list !== false && $metadata_writen !== false){
		unset_global_var('title');
		unset_global_var('content');
		unset_global_var('title_empty');
		return true;
	}
}


// bool blog_update_entry(string id, string name, string title, string content[, string tags])
function blog_update_entry($id,$name,$title,$content,$tags = null){

	$tags = preg_replace("/[^\w\s,]/",'',$tags);
	$timestamp = time();

	// Write to Entrie file
	$entrie_file = gzopen(ENTRIES_PATH.$id,'wb9') or die('Missing or inacessible entry file.');
	flock($entrie_file,2);
	if(gzwrite($entrie_file,$content)) $write_file = true;
	gzclose($entrie_file);
	 
	// Set the String for replace in the Sections file
	// string id, string name, string title, string tags, mixed user, int timestamp
	$list_update = "$id;$name;\"$title\";\"$tags\";\"$user\";$timestamp";

	// Open the List file for read, and replace the line with new content
	$list_file = fopen(ENTRIES_PATH.'.entries', "rb") or die();
	while (($data = fgetcsv($list_file, 1000, ";")) !== FALSE) {

		if($data[0] == $id) $put_list .= $list_update . "\n";
		else $put_list .= $data[0] . ';' . $data[1] . ';"' . $data[2] . '";"' . $data[3] . '";"' . $data[4] . '";' . $data[5] . "\n";

	}
	fclose($list_file);

	// Open the same List file, now for Writing, with new data
	$list_file = fopen(ENTRIES_PATH.'.entries','wb');
	flock($list_file,LOCK_SH);
	if(fwrite($list_file,$put_list)) $update_list = true;
	fclose($list_file);

	if($write_file && $update_list) return true;
}


// bool blog_post_comment(string entry_id, mixed nick, string comment[, string url[, string url]])
function blog_post_comment($entry_id,$user,$comment,$email,$url = null){

	global $use_phpbb;
	global $user_admin;
	global $loged_in;
	global $time_left_greace_period;
	global $use_phpbb;
	
	if(is_numeric($user)) $user = +$user; // Convert STRING to INTEGER
	
	if($use_phpbb && $loged_in){
		// User 53 and later is Norma users. User between 2 and 52 are Bots; 2 is Founder and 1 is Anonymous!
		if(is_integer($user) && ($user == 2 || $user > 52)) $getusername = get_user_by_id($nick); // Will return FALSE if User does not exist
	}
	
	// Check if effectivelly entry exists, and check Email, first
	if(!is_file(ENTRIES_PATH . $entry_id) || preg_match(PREG_EMAIL_STRING,$email) == 0) return false;
	
	$ip = $_SERVER['REMOTE_ADDR'];

	$time_published = get_blog_comment_timestamp_by_ip($entry_id,$ip);
	$get_left = get_left($time_published,$time_left_greace_period);
	
	// Only Administrator can post messages repetidelly without waiting
	if($get_left !== true) return false;
	
	if($user_admin || ($user == PHPBB_USER_ID && $getusername !== false)) $moderated = 2; // Admin or Same user: 2 means special colour in posts
	elseif($loged_in && !$user_admin) $moderated = null; // Registered user: Post inmediatelly
	else $moderated = 1; // Anonymous user: Moderate comment (Admin will publish them)

	if(preg_match(PREG_URL_STRING,$url) > 0){
		if(strpos($url,"http://") !== false) $url = $url;
		else $url = 'http://' . $url;
	}else $url = null;
	
	// string nick; string url; string IP; int timestamp; bool moderated; DEFLATE string comment;
	$output = '"'.$user.'";"'.$url.'";"'.$ip.'";'.time().';'.$moderated.';';
	$output.= '"' . gzdeflate(preg_replace(array('/&lt;/','/&gt;/','/"/'),array('<','>','&quot;',''),nl2br(htmlentities(strip_tags($comment,'<b><i><u><s>'),null,'UTF-8',false))),9) . '"' . "\n";
	
	$writen = file_put_contents(COMMENTS_PATH . $entry_id,$output,FILE_APPEND);	

	if($writen != false) return true;
	else return false;
}



// array get_comments_post(string id)
function get_comments_post($id){

	global $user_admin;
	global $use_phpbb;

	if(file_exists(COMMENTS_PATH.$id)){

		$handle = fopen(COMMENTS_PATH.$id, 'rb');
		$count = 0;
		while (($data = fgetcsv($handle, 1000, ";")) !== false) {
			if(get_user_by_id($data[0]) !== false){
				$username = get_user_by_id($data[0]);
				$website = get_user_by_id($data[0],3);
			}else{
				$username = $data[0];
				$website = $data[1];
			}
			
			if(($data[4] != 1 && !$user_admin) || $user_admin) $comments[] = array('id'=>$count,'nick'=>$username,'website' =>$website,'ip'=>$data[2],'timestamp'=>$data[3],'moderate'=>$data[4],'comment'=>gzinflate($data[5]));
			$count++;
		}
		fclose($handle);
		
		// Inverts the order (last to first comment)
		if(!empty($comments)) rsort($comments); // Review the Sorting!
		else $comments = false;
	}else $comments = false;

	return $comments;
}

// int get_blog_comment_timestamp_by_ip(int id[, string ip])
function get_blog_comment_timestamp_by_ip($id,$ip = null){

	$filename = COMMENTS_PATH.$id;
	
	if(is_file($filename) && is_readable($filename) && (filesize($filename) > 0)){
	
		// Que soy weón!
		// Puse 'wb' en el Modo de apertura en fopen(), y con razón se vacía el archivo.
		$file = fopen($filename,'rb'); // Modificado a 'rb'

		if(preg_match(PREG_IP_STRING,$ip) == 0) $ip = $_SERVER['REMOTE_ADDR'];

		// This will check the IP, and gets the last message by checking the Timestamp against
		// the current Timestamp (time()). If current time is greater than the time, it assumes than
		// these is the last message. This is not really secure, but is faster.
		while (($data = fgetcsv($file, 10000, ";")) !== FALSE){
			if($ip == $data[2] && time() >= $data[3]) $timestamp = $data[3];
		}
		
		fclose($file);
		return $timestamp;
	}else return false;
}


// bool delete_entry(string id)
function delete_entry($id){

	// If entry exists
	if(is_file(ENTRIES_PATH.$id)){
		
		// Open the File for read
		$list_file = fopen(ENTRIES_PATH.'.entries', "rb") or die();
		while (($data = fgetcsv($list_file, 1000, ";")) !== FALSE) {
			if($data[0] == $id) $put_list .= null;
			else $put_list .= $data[0] . ';"' . $data[1] . '";"' . $data[2] . '";"' . $data[3] . '";"' . $data[4] . '";' . $data[5] . "\n";
		}
		fclose($list_file);

		//clearstatcache();

		if(unlink(ENTRIES_PATH.$id) && unlink(COMMENTS_PATH.$id) && file_put_contents(ENTRIES_PATH.'.entries',$put_list,LOCK_EX) !== false) return true;
		else return false;
	}else return false;
}

/* Moderate comments
 *
 * moderate_comments() will moderate or delete, by passing the ID (timestamp)
 * of the comment. Then, ID recived is converted to String with
 * delimiters to be used with preg_replace().
 *
 * Now, preg_replace() finds the ID recived. If ID recived is
 * the same as ID in the Comments file, correspondient line
 * is null; then, if not, recreate the Line with data in CSV.
 *
 * Finally, write the lines with file_put_contents()
 *
 * Warning: This can be hardy for server if Data is too big.
 * I' working in alternative Write methods, inside the while.
 *
 */

//int moderate_comments(string entry, mixed comments)
function moderate_comments($id,$comments,$action){

	// Check if file exists and is readable
	if(!is_readable(COMMENTS_PATH . $id) &&
	   !is_writable(COMMENTS_PATH . $id) &&
	   !is_file(COMMENTS_PATH . $id)) return false;
	   
	$file = fopen(COMMENTS_PATH . $id,'rb');
	flock($file,LOCK_SH);
	
	$comments_preg = "/(" . implode("|",$comments) . ")/";
	
	while($line = fgetcsv($file,8192,";")){

		if($action == 0){
			//string nick, string url, string ip, int timestamp, int moderated, string comments
			if(preg_match($comments_preg,$line[3]) == 0) $output .= '"'.$line[0] . '";"' . $line[1] . '";"' . $line[2] . '";' . $line[3] . ';' . $line[4] . ';"' . $line[5] . '"' . "\n";
		}elseif($action == 1){
			if((preg_match($comments_preg,$line[3]) == 0) || $line[4] == 2) $output .= '"'.$line[0] . '";"' . $line[1] . '";"' . $line[2] . '";' . $line[3] . ';' . $line[4] . ';"' . $line[5] . '"' . "\n";
			else $output .=  '"'.$line[0] . '";"' . $line[1] . '";"' . $line[2] . '";' . $line[3] . ';;"' . $line[5] . '"' . "\n";
		}

	}
	
	//clearstatcache(true,COMMENTS_PATH . $id);
	
	fclose($file);
	
	// And, put contents
	if(file_put_contents(COMMENTS_PATH . $id,$output,LOCK_EX) !== false) return ($action + 1); // Action + 1 (1: delete; 2: moderate)
	else return 0; // 0 is False
}

/* Get the name of the entry by ID
 *
 * get_post_name() will return the Name of the entry by passing the ID (or Filename)
 *
 * Parameters:
 *
 *	* string id
 *	   The ID (Filename) of the entry (see bellow)
 *
 * Returned values:
 *
 *	This function will return the Name of the post as String, or FALSE in case of error.
 *
*/
// string get_post_name(siting id)
function get_post_name($id){

	if(!file_exists(ENTRIES_PATH . $id)) return false;
	
	$file = fopen(ENTRIES_PATH . ".entries",'rb');
	while($line = fgetcsv($file,8192,";")){
		if($id == $line[0]){
			$name = $line[1];
			break;
		}
	}
	
	fclose($file);
	
	if($name != null) return $name;
	else return false;
}

/* Get the ID of the entry by Name
 *
 * get_post_id() will return the ID (Filename) of the entry by passing the Name
 *
 * Parameters:
 *
 *	* string name
 *	   The Name of the entry
 *
 * Returned values:
 *
 *	This function will return the ID of the entry as String, or FALSE in case of error.
 *
*/
// string get_post_name(siting id)
function get_post_id($name){

	if(!file_exists(ENTRIES_PATH . ".entries")) return false;
	
	$file = fopen(ENTRIES_PATH . ".entries",'rb');
	while($line = fgetcsv($file,8192,";")){
		if($name == $line[1]){
			$id = $line[0];
			break;
		}
	}
	
	fclose($file);
	
	if(!empty($id)) return $id;
	else return false;
}

?>
