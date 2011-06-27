#!/usr/bin/php -c /etc/php5/apache2/php.ini
<?php

	##############################################
	#                                            #
	# DPortal CMS; subproject codename Peachtown #
	#                                            #
	# Alert authors tha have pending comments    #
	# (alert_pending_messages.sh)                #
	#                                            #
	#	Copyright (c) Davod                     #
	#	This program is published under the     #
	#	GNU General Public License              #
	#                                            #
	# This script  is intended  to be user  with #
	# 'cron', to  check  every hour if a Chapter #
	# contain comments pending for Moderation    #
	# and aler via phpBB Private Message them,   #
	# and ONLY once, per Chapter.                #
	#                                            #
	# This script should be called fromm CLI and #
	# NOT from Apache;  this will be  killed if  #
	# user  attemps  to  call this  file   from  #
	# Browser, but, because this file is stored  #
	# outter of DocumentRoot, is not accessable. #
	# By extension, the file will be downloaded, #
	# and the first line to call the Shell, will #
	# cause a fatal error if called form Browser #
	#                                            #
	# Also,  this file  should be  called  with  #
	# lower priority ($ nice -n 10 ./foo.sh)     #
	#                                            #
	##############################################
	
// Kill if script is not called from CLI ($_SERVER['SERVER_SOFTWARE'] should be NULL).
if(!empty($_SERVER['SERVER_SOFTWARE'])) die;

// Try to connect to Local MySQL Server, to check in not the prettyest way if Server is up.
$connect = @mysql_connect('localhost','nobody','nobody');
if(mysql_errno() == 2002) die(mysql_errno() . ": " . mysql_error() . "\n");

// Set Error reporting.
error_reporting(E_ALL & ~E_NOTICE);
ignore_user_abort(true);

// Define the Includes check
define('DPORTAL',true);
define('IN_PHPBB',true);

// :: Functions

// mixed get_user(mixed user[, mixed mode])
function get_user($user, $mode = null){

	if(is_numeric($user)) settype($user, 'int'); // Convert STRING to INTEGER if needed
	
	if(is_numeric($mode)) settype($mode,'int');
	elseif($mode === true) $mode = true;
	else $mode = 0;

	// Declare the pointer to the Database, declared in phpBB
	global $db;

	if(is_int($user)) $sql = "SELECT `user_id`, `username`, `user_type` FROM `" . USERS_TABLE . "` WHERE `user_id` = $user and (`user_type` = 0 or `user_type` = 3)"; // here, the id is INTEGER and is not necesary to use mysql_real_escape_string()	
	elseif(is_string($user) && is_int($mode)) $sql = "SELECT `user_id`, `username`, `user_type` FROM `" . USERS_TABLE . "` WHERE `username` = '".mysql_real_escape_string($user)."' and (`user_type` = 0 or `user_type` = 3)";
	elseif(is_string($user) && $mode == true) $sql = "SELECT `user_id`, `username`, `user_type` FROM `" . USERS_TABLE . "` WHERE `username` LIKE '".mysql_real_escape_string($user)."' and (`user_type` = 0 or `user_type` = 3)";

	// Perform the Query against the database
	$result = $db->sql_query($sql);
	
	if(!empty($result)) $count = mysql_num_rows($result);

	if($count == 1) $row = $db->sql_fetchrow($result);
	elseif($count > 1) $row = $db->sql_fetchrowset($result);

	if(empty($row)) return false;

	// Perform the actions based in mode
	if((is_int($mode) || $mode === null) || ($mode === true && $count == 1)){
		
		if($mode === true) $mode = null;
	
		switch($mode){
			case 1: $value = $row['user_id']; break; // ID
			case 2: $value = $row['user_type']; break; // Type
			case 3: $value = $row['user_email']; break; // Website
			case 4: $value = $row['user_website']; break; // Email
			case 5: $value = PHPBB_URL_PATH . "memberlist.php?mode=viewprofile&u=$id"; // User Profile URL
			case 6: $value = array('username'=>$row['username'],$row['user_email'],$row['user_website'],$row['user_type']); break; // More data as Array
			default:$value = $row['username']; break; // Default, Username
		}

		// If the $value is Numeric, set as INTEGER.
		if(is_numeric($value)) settype($value,'int');

		// And finally, return the value
		if($row['user_type'] == 3 || $row['user_type'] == 1 || $row['user_type'] == 0) return $value;
		else return false;
	
	}elseif($mode === true && $count > 1){
	
		return $row;
	
	}else return false;
}


// array get_books(int book)	
function get_book($book){

	if(!is_integer($book)) return false;

	global $db;

	$sql = "SELECT `name`,`title` FROM `book_books` WHERE `id` = $book LIMIT 1"; // Specific book (use $db->sql_fetcrow()!!!

	// Perform the Query against the database
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	if(empty($row)) return false;
	else return $row;
}


function get_chapter($book,$chapter){

	global $db;
	
	$sql = "SELECT `name`,`title` FROM `book_chapters` WHERE `book` = $book AND `name` = $chapter LIMIT 1";
	$result = $db->sql_query($sql);
	$name = $db->sql_fetchrow($result);
	
	if(!empty($name)) return $name;
	else return false;
}



// bool alert_pending_pm()
function alert_pending_pm($author,$book,$chapter){
	$getbook = get_book($book);
	$bookname = $getbook['name'];
	$booktitle = $getbook['title'];
	
	$getchapter = get_chapter($book,$chapter);
	$chaptername = $getchapter['name'];
	$chaptertitle = $getchapter['title'];
	
	//$chaptername = get_chapter($author,$book,$chapter);
	if(empty($bookname)) return false;

	include_once(PHPBB_ROOT_PATH.'includes/functions_privmsgs.php');
	
	$message = utf8_normalize_nfc($pmmessage);
	$uid = $bitfield = $options = ''; // will be modified by generate_text_for_storage
	$allow_bbcode = true;
	$allow_smilies = false;
	$allow_urls = true;
	
	$author_name = get_user($author);
	$url = '[url]http://localhost/'.DPORTAL_PATH."/stories/~".$author_name.'/'.$bookname.'/'.$chaptername.'.html#comments[/url]';
	$author_name = '[b]'.$author_name.'[/b]';
	
	$pmsubject = "You have comments pending for moderation";
	// The Message, using HEREDOC syntax!
	$message = <<<MESS
$author_name, you have stories with comments pending for moderation. Please review them.

[b]Book:[/b]	"$booktitle"
[b]Chapter:[/b] $chaptername "$chaptertitle"
[b]URL:[/b]	$url

[i]This message has been sended [b]Automatically[/b], and NOT from an Administrator (human).
If you already checked all comments from their Chapter, please ignore this message.[/i]
MESS;

	generate_text_for_storage($message, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);
	$pm_data = array(
	'from_user_id'        => 55, // The User if of the Robot
	'from_user_ip'        => "127.0.0.1", // Always 127.0.0.1
	'enable_sig'            => false,
	'enable_bbcode'        => true,
	'enable_smilies'        => false,
	'enable_urls'        => true,
	'icon_id'            => 0,
	'bbcode_bitfield'    => $bitfield,
	'bbcode_uid'         => $uid,
	'message'            => $message,
	'address_list'        => array('u' => array($author => 'to')),
	);
	 
	//Now We Have All Data Lets Send The PM!!
	$submit = submit_pm('post', $pmsubject, $pm_data, false, false);
	
	if($submit !== false) return true;
}

// This function should be called each four hour to synchronize all the comments pending,
// for moderation and set the Flag `pending` in `book_chapters` to 1. When sending Comments,
// also this Flag is set, but is better than update in this form to avoid send repetidelly PMs. 
// int update_pending_chapters_table([bool verbose])
function update_pending_chapters_table($verbose = false){

	global $db;

	// First, get the Chapters with comments pending for Moderation
	if($verbose) echo "  * Finding comments pending for Moderation...\n";
	$sql_check = "SELECT `book`,`chapter` FROM `book_comments`\n     WHERE `moderated` = 0\n     ORDER BY `author` ASC , `book` ASC , `chapter` ASC";
	if($verbose) echo "    SQL check:\n    \"$sql_check\"\n";
	$result_check = $db->sql_query($sql_check);
	$rows_check = $db->sql_fetchrowset($result_check);

	if(empty($rows_check)) return false;

	foreach($rows_check as $row){
		$book = $row['book'];
		$chapter = $row['chapter'];
		
		$book_chapter = "$book;$chapter";
		
		if($book_chapter != $last_book_chapter) $count = 1;
		
		settype($book,'int');
		settype($chapter,'int');
	
		$getcomments[$book_chapter] = $count;
		
		$count++;
		$last_book_chapter = $book_chapter;
	}

	$count = 0;
	foreach($getcomments as $key=>$value){
	
		if($value > 0){
			$getkey = explode(';',$key);
			$book = $getkey[0];
			$chapter = $getkey[1];
	
			if(empty($count)) $where .= "        (`book` = $book AND `name` = $chapter)\n";
			else $where .= "        OR (`book` = $book AND `name` = $chapter)\n";
			$count++;
		}
	}
	
	// Set Pending flag to 1
	if($verbose) echo "  * Updating Chapters flag...\n";
	$sql_update_one = "UPDATE `book_chapters` SET `pending` = 1 WHERE (\n$where      ) AND `pending` = 0";
	$sql_update_zero = "UPDATE `book_chapters` SET `pending` = 0 WHERE `pending` = 2;";
	if($verbose) echo "    SQL update One:\n     \"$sql_update_one\"\n    SQL update Zero:\n    \"$sql_update_zero\"\n";
	$db->sql_query(str_replace(array("\n",'        ','      ','    ','  '),' ',$sql_update_one));
	$chapters_updated = mysql_affected_rows();
	$db->sql_query(str_replace(array("\n",'        ','      ','    ','  '),' ',$sql_update_zero));
	
	return $chapters_updated;
}

// This function will check if Chapters have comments pending for Moderation by watching the
// flag `pending` in `book_chapters`, and send PM alertin of them. Once message is sended,
// Flag is turned to 0.
// This function will be called every one hour
// int check_pending_chapters_table_to_send_mp(bool verbose)
function check_pending_chapters_table_to_send_mp($verbose = false){

	global $db;

	if($verbose) echo "  * Checking for Chapters with comments pending for Moderation...\n";
	$sql_check = "SELECT `author`,`book`,`name` FROM `book_chapters` WHERE `pending` = 1";
	if($verbose) echo "    SQL check:\n    \"$sql_check\"\n";
	$result_check = $db->sql_query($sql_check);
	$row_check = $db->sql_fetchrowset($result_check);

	if(empty($row_check)) return 0;

	// Iterate trhoug Chapters with Flag 1 and sedn MP to their Authors
	if($verbose) echo "  * Sending Private Messages for Authors that have comments pending for moderation...\n";
	foreach($row_check as $chapters){
		$author = $chapters['author'];
		$book = $chapters['book'];
		$chapter = $chapters['name'];
		
		settype($author,'int');
		settype($book,'int');
		settype($chapter,'int');
		
		// Call alert_pending_pm() to send PM to users
		alert_pending_pm($author,$book,$chapter);
		
		// And set the Query to reset the Flag to 0.
		if(empty($count)) $where .= "      (`book` = $book AND `name` = $chapter)\n";
		else $where .= "      OR (`book` = $book AND `name` = $chapter)\n";
		$count++;
	}
	
	
	// Reset `pending` flag to 0
	if($verbose) echo "  * Setting Flag to 2 (already sended)...\n";
	$sql_update = "UPDATE `book_chapters` SET `pending` = 2 WHERE(\n$where    ) AND `pending` = 1";
	if($verbose) echo "    SQL check:\n    \"$sql_update\"\n";
	$db->sql_query($sql_update);

	return mysql_affected_rows();
}


// :: Limited version config scripts

	// :: 'constanst.php'

	// All should be SECURE forms to obtain Directory names
	define('DPORTAL_ABSOLUTE_PATH',dirname(dirname(__FILE__))); // Path of Installation (absolute!!!)
	define('DPORTAL_PATH',basename(DPORTAL_ABSOLUTE_PATH)); // public access (relative)
	define('REAL_DOCUMENT_ROOT',dirname(DPORTAL_ABSOLUTE_PATH)); // Actual DocumentRoot (absolute!!!)

	// Absolute paths for Inclusion (replace ABSOLUTE_PATH to place another paths for security purposes!).
	define('CONFIG_PATH',DPORTAL_ABSOLUTE_PATH.'/config/'); // Don't modify!!!

	// :: 'config.php'

	// Starts the Session
	//session_set_cookie_params(1800); // Enable if you want to use them
	session_name('DPORTALID');
	session_start();

	// Gets the values in the 'config/site.ini' file
	$conf = parse_ini_file(CONFIG_PATH . 'site.ini') or die('Missing or inaccesible Configuration file!');
	
	// Set the configuration
	$phpbb_dir = $conf['phpbb_dir']; // String


	// :: 'phpbb3.php'

	$phpbb_root_path = REAL_DOCUMENT_ROOT . $phpbb_dir;
	define('PHPBB_ROOT_PATH',$phpbb_root_path);

	// URL Path (DON'T CHANGE THE VARIABLE AND CONSTANT NAMES!!!)
	$phpbb_url_path = 'http://'.$_SERVER['SERVER_NAME'].$phpbb_dir;
	define('PHPBB_URL_PATH',$phpbb_url_path);

	$phpEx = 'php';

	require_once($phpbb_root_path.'common.'.$phpEx);
	require_once($phpbb_root_path.'config.'.$phpEx);

	// Starts the phpBB session 
	$user->session_begin(); 
	$auth->acl($user->data); 
	$user->setup();

// :: We perform the update from here:

if($argv[2] == "--verbose") $verbose = true;

// Update mode
if(in_array($argv[1],array("--update","-u"))){
	// Call update_pending_chapters_table() each 1 hours
	if($verbose) echo "Checking for messages pending for moderation and updating `pending` flag...\n";
	$updated = update_pending_chapters_table($verbose);

	if(!empty($updated) && $verbose) echo "  * Chapters flag updated: $updated\n";
	elseif($updated === false && $verbose) echo "  * No comments pending for Moderation.\n";
	elseif($updated == 0 && $verbose) echo "  * Alerts already sended.\n";
	
	$timestamp = time();
	$time = strftime("%c",$timestamp);
	
	file_put_contents('file:///var/www/peachtown/source/update.sh/log',"$timestamp;$time;Update Moderate pending status\n",FILE_APPEND);
	
// Alert mode
}elseif(in_array($argv[1],array("--alert","-a"))){
	// Call check_pending_chapters_table_to_send_mp() each 10 minutes
	if($verbose) echo "Checking flag `pending` and send alerts...\n";
	$checked = check_pending_chapters_table_to_send_mp($verbose);
	if(!empty($checked) && $verbose) echo "  * Alerts sended: $checked.\n";
	elseif(empty($checked) && $verbose) echo "  * No alerts sended.\n";
	
	$timestamp = time();
	$time = strftime("%c",$timestamp);
	
	file_put_contents('file:///var/www/peachtown/source/update.sh/log',"$timestamp;$time;Checking for Moderate Pending and Sending PM\n",FILE_APPEND);
	
}elseif(in_array($argv[1],array("--version","-v"))){
echo <<<VERSION
Project:  DPortal CMS; subproject codename Peachtown.
Filename: alert_pending_messages.sh
Summary:  Check messages  pending for  Moderation and  alert to Authors of them.

Copyright (c) Davod.
This program is published under the GNU General Public License.

VERSION;

if($verbose){
echo <<<DESCRIPTION

This UNIX shell script is intended  to be user  with 'cron', to check every hour
if a  Chapter contain  comments  pending  for Moderation,  and  alert via  phpBB
Private Message them, and ONLY once, per Chapter, every 10 minutes.

This script should be called from CLI and NOT from Apache;  this will be  killed
if user  attemps  to  call this  file  from Browser, but,  because  this file is
stored outter of DocumentRoot, is not accessable. By extension, the file will be
downloaded, and the  first  line to call the Shell,  will cause a fatal error if
called form Browser.

Also, this file should be called  with  lower priority  ($ nice -n 10 ./foo.sh).

DESCRIPTION;

}

}else{
echo <<<USAGE
"alert_pending_messages.sh", script to check for Messages pending for Moderation
and alert the Authors for them.

Usage:

  No arguments, this text.

  --alert, -a
    Check the table `book_chapters`  for the flag  `pending` in  `book_chapters`
    and send  Private Message to the  Authors that  Chapters  have Messages with
    Pending for  Moderation  (flag 1).  Then,  once  sended  the PM, the flag is
    set  to 2, already  alerted. This  check should  be called every 10 minutes.

  --update, -u
    Check the `book_comments` table to find Messages Pending for Moderation, and
    updates the flag `pending` in `book_chapters`  (of comments pending) with 1.
    This check should be called every 1 hour.
    
  --verbose
    Verbose output (silent is defalt). Output every command executed, including
    SQL queries (successfull and errors).

  --version, -v
    Prints the version and author of this program
    (--verbose bellow --version outputs more information).

USAGE;

}

// And finally, end the Script.
die;
?>