<?php

		################################################
		#                                              #
		#		DPortal CMS, CMS without Database engine 	 #
		#																							 #
		#	Functions for Blog (blog.php)							   #
		#																							 #
		#	Copyright Davod.														 #
		#																							 #
		#	This program is published under the				   #
		#	GNU general Public License									 #
		#																							 #
		#	Please see README and LICENSE for details	   #
		#																							 #
		################################################


/* Get the Entries for Index
 *
 * This function get the List of entries and check if the Entry file (id) exists.
 * Reverse the order of data, form the last to firts and return the Array.
 *
 * The function fgetcsv return NULL if no data is present, and this function
 * return NULL if no comments are passed.
*/

// array get_blog_entries(int blog_entries, int size_limit = null)
function get_blog_entries($entries_index = 5, $size_limit = 0){

	if(!is_integer($size_limit)) $size_limit = 0;

	$handle = fopen(ENTRIES_PATH.'.entries', "r");
	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		if($data[0] != null	&& file_exists(ENTRIES_PATH . $data[0])){
			$entries[] = array('id'=>$data[0],'file' =>ENTRIES_PATH.$data[0],
								 		'name'=>$data[1],'title'=>$data[2],
								 		'tags'=>$data[3]);
		}
	}
	fclose($handle);

	if($entries != null) rsort($entries);

	if($entries != null) return $entries;
	else return null;
}


/* Get the Entries for the Feed
 *
 * This function is the same as the Get entries, but this
 * is inteded to be used for Atom Feed distribution.
 *
 * Max size of the Entrie is implicit.
 *
 * Parameters:
 *
 *	None
 *
 * Return values:
 *
 *	If Entries exists in List and Files, this function
 *	return an ARRAY with these data. The entrie content
 *	is obtained with {fetch}. If no entries exist,
 *	this functioon return BOOLEAN false.
 *
*/

// array get_blog_entries_feed(int max = null)function get_blog_entries_feed(){

	$getentries = fopen(ENTRIES_PATH.'.entries', "r") or die();
	while (($ents = fgetcsv($getentries, 1000, ";")) !== FALSE) {
		if($ents[0] != null && file_exists(ENTRIES_PATH . $ents[0])){			$entries[] = array('id'=>$ents[0],'name'=>$ents[1],
			'title'=>$ents[2],'file'=>ENTRIES_PATH . $ents[0]);
		}
	}
	fclose($getentries);

	if($entries != null){ rsort($entries); return $entries; }
	else return null;
}


/* ABOUT THIS FUNCTION
 *
 * This function takes a entry name, and gets the
 * ID and the rest of the data.
 * 
 * Returns Array if is correct. Elsewhere, returns false
 *
*/

// array get_blog_entry(string id[, string name])
function get_blog_entry($entry_name){
	
	$handle = fopen(ENTRIES_PATH.'.entries', "r");
	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		if($entry_name == $data[1]){
			$entry = array('id'=>$data[0],'file'=>ENTRIES_PATH.$data[0],
							'name'=>$data[1],'title'=>$data[2],
							'tags'=>$data[3]);
		}
	}
	fclose($handle);

	if($entry != null && file_exists(ENTRIES_PATH.$data[0])) return $entry;
	else return null;
}


// array get_blog_entry_feed(string id[, string name])
function get_blog_entry_feed($entry_name){

		$handle = fopen(ENTRIES_PATH.'.entries', "r") or die();
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			if($entry_name == $data[1]){
				$id = $data[0];
				$file = ENTRIES_PATH . $id;
				$name = $data[1];
				$title = $data[2];
			}
		}
		fclose($handle);
	
	if(is_file(COMMENTS_PATH.$id)){
		$comments_file = fopen(COMMENTS_PATH.$id, "r");
		while (($com = fgetcsv($comments_file, 1000, ";")) !== FALSE) {
			$comments[] = array('timestamp'=>$com[0],'name'=>$com[1],
			'comment'=>$com[2],'email'=>$com[3],'url'=>$com[4]);
		}
		fclose($comments_file);	
	}
	
	if($id != null) $entry = array('id'=>$id,'name'=>$name,'title'=>$title,'file'=>$file,'content'=>$content,'comments'=>$comments);

	 	if($entry !== null) return $entry;
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

	// Sets the Name
	$name = substr_replace(strtolower(
	preg_replace("/([\s]*(&)*(acute;|grave;|tilde;|sup;)*)*/","",htmlentities(utf8_decode($title)))),'',20);
	
	// Check if entry Name exist
	$chkentries = fopen("entries/.entries", "r") or die('<b>Fatal error:</b> Missing or inaccesible Entries filelist!');
	while (($data = fgetcsv($chkentries, 1000, ";")) !== FALSE) {
		if($name == $data[1]) { $name = $name . rand(10,99); break; }
	}
	fclose($chkentries);

	return $name;

}


// bool blog_new_entry(string timestamp, string title, string content[,string tags])
function blog_new_entry($timestamp,$name,$title,$content, $tags = null){

	if($name == null) return false;

	// Crate a new File
	$entrie_file = fopen(ENTRIES_PATH.$timestamp,'x') or die('Entrie file exists!');
	flock($entrie_file,LOCK_EX);
	if(fwrite($entrie_file,$content)) $write_file = true;
	fclose($entrie_file);

	$list_file = fopen(ENTRIES_PATH.'.entries','a');
	flock($list_file,LOCK_SH);
	if(fwrite($list_file,"$timestamp;$name;\"$title\";\"$tags\"\n")) $update_list = true;
	fclose($list_file);

	$comments_file = fopen(COMMENTS_PATH.$timestamp,'x');
	fclose($comments_file);

	if($write_file && $update_list){
		unset($_SESSION['title']);
		unset($_SESSION['content']);
		unset($_SESSION['title_empty']);
		return true;
	}
}


// bool blog_update_entry(string id, string name, string title, string content[, string tags])
function blog_update_entry($id,$name,$title,$content, $tags = null){

	$tags = preg_replace("/[^\w\s,]/",'',$tags);

	$entrie_file = fopen(ENTRIES_PATH.$id,'w');
	flock($entrie_file,2);
	if(fwrite($entrie_file,$content)) $write_file = true;
	fclose($entrie_file);
	 
	// Set the String for replace in the Sections file
	$list_update = "$id;$name;\"$title\";\"$tags\"";

	// Open the File for read
	$list_file = fopen(ENTRIES_PATH.'.entries', "r") or die();
	while (($data = fgetcsv($list_file, 1000, ";")) !== FALSE) {

		if($data[0] == $id) $put_list .= $list_update . "\n";
		else $put_list .= $data[0] . ';' . $data[1] . ';"' . $data[2] . '";' . $data[3] . "\n";

	}
	fclose($list_file);

	// Update the Entries file in Write mode
	$list_file = fopen(ENTRIES_PATH.'.entries','w');
	flock($list_file,LOCK_SH);
	if(fwrite($list_file,$put_list)) $update_list = true;
	fclose($list_file);

	if($write_file && $update_list) return true;
}


// bool post_comment(string entry_id, string nick, string email, string post[, string url])
function blog_post_comment($entry_id,$timestamp,$nick,$comment,$email,$url = null){

	global $email_string;
	global $url_string;

	if(file_exists(COMMENTS_PATH.$entry_id)){

		// Fill the Form if data are false
 		$_SESSION['nick'] = $nick;
		if(!$_SESSION['invalid_email']) $_SESSION['email'] = $email;
		if(!$_SESSION['invalid_url']) $_SESSION['url'] = $url;

		// Ask if data are valid
		if($nick == null) { $_SESSION['nick_empty'] = true; return false; }
		if(!preg_match($email_string,$email)){ $_SESSION['invalid_email'] = true; return false; }
		//if(!checkdnsrr(array_pop(explode("@",$email)),"MX")){ $_SESSION['invalid_email'] = true; return false; }		if(!preg_match($url_string,$url) && $url != null) { $_SESSION['invalid_url'] = true; return false; }
		if($comment == null) { $_SESSION['comment_empty'] = true; return false; }
		if(strlen($comment) > 5000) { $_SESSION['comment_exceeds'] = true; return false; }

		$comment_file = fopen(COMMENTS_PATH.$entry_id,'a') or die();
		$timestamp = time();
				
		$output = "$timestamp;";
		$output.= "\"" . str_replace('"','',htmlentities(strip_tags($nick),null,'UTF-8')) . "\";";
		$output.= "\"" . preg_replace("/^(([\w]+\.)*([\w]+\.[\w]+)){1}$/","http://$url",$url) . "\";"; // Adds 'http://' if them is not given in URL, if is valid.
		$output.= "\"" . preg_replace(array('/&lt;/','/&gt;/','/"/',"/[\r\n]*/"),array('<','>','&quot;',''),nl2br(htmlspecialchars(strip_tags($comment,'<b><i><u><s>'),null,'UTF-8',false))) . "\"\n";
		
		if(fwrite($comment_file,$output)) $written = true;

		fclose($comment_file);

		if($written){
			unset($_SESSION['nick']);
			unset($_SESSION['email']);
			unset($_SESSION['url']);
			return true;
		}
	}else return false;
}



// array get_comments_post(string id)
function get_comments_post($id){

	if(file_exists(COMMENTS_PATH.$id)){

		$handle = fopen(COMMENTS_PATH.$id, 'r');
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$comments[] = array('timestamp'=>$data[0],'nick' =>$data[1],
								 'website'=>$data[2],'comment'=>$data[3]);
		}
		fclose($handle);
		
		// Inverts the order
		if($comments != null) rsort($comments);
	}

	// Return the Array
	if($comments != null) return $comments;
}



// bool delete_entry(string entry_name)
function delete_entry($entry_name){
 
	// Open the file in READ ONLY and check if exists
	$file = fopen(ENTRIES_PATH.'.entries','r');
	flock($file,2);
	while (($data = fgetcsv($file, 1000, ";")) !== FALSE) {
		if($entry_name == $data[1]){
			$id = $data[0];
			$name = $data[1];
			$title = $data[2];
			$tags = $data[3];
			$exists = true;
		}
	}
	fclose($file);
	
	if($exists === true){
		
		// Open the File for read
		$list_file = fopen(ENTRIES_PATH.'.entries', "r") or die();
		while (($data = fgetcsv($list_file, 1000, ";")) !== FALSE) {

			if($data[0] == $id) $put_list .= null;
			else $put_list .= $data[0] . ';' . $data[1] . ';"' . $data[2] . '";' . $data[3] . "\n";

		}
		fclose($list_file);

		$file = fopen(ENTRIES_PATH.'.entries','w');	
		if(fwrite($file,$put_list)) $removed = true;
		fclose($file);
		
		if(unlink(ENTRIES_PATH.$id) && unlink(COMMENTS_PATH.$id)) $deleted = true;
	}
	
	if($removed && $deleted) return true;
}



function edit_entry_admin($params, &$smarty){

	global $user_admin; global $LANG;

	$entry = $params['entry'];

	if($user_admin){

		$edit = DPORTAL_PATH.'blog.php?EDIT&entry='.$entry;
		$delete = DPORTAL_PATH.'blog.php?DELETE&entry='.$entry;

		$output = " | ";
		$output.= "<a href=\"".DPORTAL_PATH."/blog.php?EDIT&amp;entry=$entry\">".ucfirst($LANG['edit'])."</a> | ";
		$output.= "<a href=\"".DPORTAL_PATH."/blog.php?DELETE&amp;entry=$entry\" onclick=\"return confirm('".$LANG['delete_entry_warn']."');\">".ucfirst($LANG['delete'])."</a>";

		return $output;

	}else return null;
}



// string blog_message(void);
function get_blog_message(){

	global $LANG;

	if($_SESSION['blog_entry_saved']){ $type = 'entry'; $message = array('ok',$LANG['entry_published']); }
	elseif($_SESSION['blog_entry_error']){ $type = 'entry'; $message = array('error',$LANG['entry_error']); }
	elseif($_SESSION['blog_post_saved']){ $type = 'comment'; $message = array('ok',$LANG['comment_ok']); }
	elseif($_SESSION['blog_post_error']){ $type = 'comment'; $message = array('error',$LANG['comment_error']); }
	elseif($_SESSION['blog_entry_does_not_exist']){ $type = 'index'; $message = array('error',$LANG['entry_doesnt_exist']); }
	elseif($_SESSION['blog_entry_saved']){ $type = 'entry'; $message = array('ok',$LANG['post_ok']); }
	elseif($_SESSION['blog_entry_deleted']){ $type = 'index'; $message = array('ok',$LANG['entry_deleted']); }
	elseif($_SESSION['blog_entry_deleted']){ $type = 'entry'; $message = array('error',$LANG['post_error']);}
	elseif($_SESSION['blog_entry_doesnt_exist']){ $type = 'index'; $message = array('error',$LANG['entry_doesnt_exist']); }

	if($message != null) return array($type,$message);
}

function get_alerts(){

	global $LANG;

	if($_SESSION['nick_empty']) $message = array('type'=>'alert','message'=>$LANG['nick_empty_warn']);
	elseif($_SESSION['invalid_email']) $message = array('type'=>'alert','message'=>$LANG['invalid_email_warn']);
	elseif($_SESSION['invalid_url']) $message = array('type'=>'alert','message'=>$LANG['invalid_url_warn']);
	elseif($_SESSION['comment_empty']) $message = array('type'=>'alert','message'=>$LANG['comment_empty_warn']);
	elseif($_SESSION['comment_exceeds']) $message = array('type'=>'alert','message'=>$LANG['comment_exceeds_warn']); 

	return $message;

}

function blog_message($params,&$smarty){

	$message = $params['message'];
	$stype = $params['stype'];
	$dtype = $params['dtype'];

	if($message != null && $stype == $dtype) return '<div class="message_'.$message[0].'">'.$message[1].'</div>';
	else return null;

}

?>
