#!/usr/bin/php -c /etc/php5/apache2/php.ini
<?php

	##############################################
	#                                            #
	# DPortal CMS; subproject codename Peachtown #
	#                                            #
	# Scheduled update points script (update.sh) #
	#                                            #
	#	Copyright (c) Davod                     #
	#	This program is published under the     #
	#	GNU General Public License              #
	#                                            #
	# This script  is intended  to be user  with #
	# 'cron', to perform  scheduled  Updates for #
	# Points  to  every   Book  each  12   hours #
	#                                            #
	# This script should be called from CLI and  #
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

// Define the Includes check
define('DPORTAL',true);
define('IN_PHPBB',true);

// :: Functions

// :: Copy of get_user() in phpbb3.php
// This Function should be called ONLY from other Functions.

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


// :: Modified version of get_points() that don't accept parameters
// This Function should be called ONLY from other Functions.

// int get_points()
function get_points_books(){

	// We assume than the User has been already checked in update_points_book_table()

	global $db;

	// :: Query for Comments
	
	// Set the SQL Query
	$sql_comments = "SELECT `note`,`user`,`author`,`book` FROM `book_comments` WHERE `moderated` = 1 ORDER BY `timestamp` DESC";
	$result_comments = $db->sql_query($sql_comments);
	$row_comments = $db->sql_fetchrowset($result_comments);

	if(!empty($row_comments)){

		// Add the Note of Comments to the Points to get the final result (default: 2).
		foreach($row_comments as $row){
			$author = $row['author'];
			$user = $row['user'];
			$book = $row['book'];
			$note = $row['note'];
			
			settype($author,'int');
			settype($book,'int');
			settype($note,'int');
		
			// Don't count comments from the same Author or Admin.
			if($user != $author) $num_comments[$book] += $note;
		}
	}

	// Unset unused array
	unset($row_comments);
	
	
	// :: Query for reads

	$sql_reads = "SELECT `book`,`author`,`ip`,`timestamp` FROM `book_reads` ORDER BY `timestamp` DESC , `author` ASC , `ip` DESC";
	$result_reads = $db->sql_query($sql_reads);
	$row_reads = $db->sql_fetchrowset($result_reads);
	$num_books = count($row_reads);

	// At least one read should be stored. if not, return FALSE
	if(empty($row_reads)) return false;

	// Get the data form Query and create a new Array with the Book and IP
	foreach($row_reads as $row){

		// Get the variablles from Row
		$author = $row['author'];
		$book = $row['book'];
		$ip = $row['ip'];
		$timestamp = strtotime($row['timestamp']);
		
		// If current IP is different than the Last IP, rewind the Num Key to 0
		// (first time to itearte, Num Key is 0 by default, because Last IP is null).
		if($ip != $last_ip) $num = 0;
		
		// Don't consider the reads from Owner or Admin
		if($author != $row['author'] || !$user_admin) $row_reads_filtered[$book][$ip][$num] = $timestamp; // New method, Array with IP and Num as Keys
		$num++; // Increment Num Key
		$last_ip = $ip; // Set Last IP to compare to the next
	}

	// Once again, if no valid results, return FALSE.
	if(empty($row_reads_filtered)) return false;

	// Unset unused array
	unset($row_reads);

	// Iterate each Book
	foreach($row_reads_filtered as $book_key=>$reads_by_ip_key){
		$num_reads = 0;
		// Iterate each IP form given Book
		foreach($reads_by_ip_key as $reads_key=>$reads_value){
			//$num_reads = 0;
			// Reads for each IP. Don't consider reads under 1 hour or repedidelly loads.
			foreach($reads_value as $timestamp){
				/*if((($last_timestamp - $row_filter) > 3600))*/ $num_reads++;
				$last_timestamp = $timestamp;
			}
		}
		// Declare the Points for each Book, and add the Points form Comments
		$num_reads_global[$book_key] = $num_reads + $num_comments[$book_key];
	}
	
	// Return the value
	return $num_reads_global;
}


// :: Modified version of update_points_book_table() that don't accept parameters
// This Function should be called ONLY from other Functions.

// void update_points_book_table(void)
function update_points_books_table(){

	global $db;

	$books_points = get_points_books();
	
	if(empty($books_points)) return false;
	
	foreach($books_points as $book_key=>$book_points){
		if(is_int($book_key) && is_int($book_points)){
			$sql_update = "UPDATE `book_books` SET `points` = $book_points WHERE `book_books`.`id` =$book_key;";
			$result_update = $db->sql_query($sql_update);
			
			// If any Error when writing to the DB, break there and return FALSE.
			if($result_update === false){
				echo "\t\t" . mysql_errno($result_update) . ": " . mysql_error($result_update) . "\n";
				echo "\t\tSQL: $sql_update";
				return false;
			}
		}
	}
	return true;
}

// :: Function to Update the Total Points of the Author and their Books.
// Note: This Function should be call AFTER calling update_points_books_table()

// void update_points_users_table(void)
function update_points_users_table(){

	global $db;

	$sql_get = "SELECT `author`,`id`,`points` FROM `book_books` ORDER BY `author` DESC";
	$result_get = $db->sql_query($sql_get);
	$rows_get = $db->sql_fetchrowset($result_get);

	if(empty($rows_get)){
		echo "\t\t" . mysql_errno($result_get) . ": " . mysql_error($result_get) . "\n";
		echo "\t\tSQL: $sql_get\n";
		echo "\t\tFatal error: Empty Books table!";
		return false;
	}

	foreach($rows_get as $row){
	
		$author = $row['author'];
		$book = $row['id'];
		$points = $row['points'];
		
		settype($author,'int');
		settype($book,'int');
		settype($points,'int');
		
		$rows_points[$author][$book] = $points;
	}
	
	foreach($rows_points as $row_author_key=>$row_author_value){
		$author = $row_author_key;
		$book_points = 0;
		foreach($row_author_value as $key=>$value){
			$book_points += $value + 10;
		}
		
		$sql_update = "UPDATE `" . USERS_TABLE . "` SET `points` = $book_points WHERE `user_id` =$author\n";
		$result_update = $db->sql_query($sql_update);
		// If any Error when writing to the DB, break there and return FALSE.
		if($query_update === false){
			echo "\t\t" . mysql_errno($result_update) . ": " . mysql_error($result_update) . "\n";
			echo "\t\tSQL: $sql_update";
			return false;
		}
	}
	return true;
}

// :: Limited version config scripts

	// :: 'constanst.php'

	// All should be SECURE forms to obtain Directory names
	define('DPORTAL_ABSOLUTE_PATH',dirname(dirname(__FILE__))); // Path of Installation (absolute!!!)
	define('DPORTAL_PATH',basename(DPORTAL_ABSOLUTE_PATH)); // public access (relative)
	define('REAL_DOCUMENT_ROOT',dirname(DPORTAL_ABSOLUTE_PATH)); // Actual DocumentRoot (absolute!!!)

	// Absolute paths for Inclusion (replace ABSOLUTE_PATH to place another paths for security purposes!).
	define('CONFIG_PATH',DPORTAL_ABSOLUTE_PATH.'/config/'); // Don't modify!!!
	define('SMARTY_TEMPLATES_PATH',DPORTAL_ABSOLUTE_PATH.'/smarty/');


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

if($argv[1] == "--verbose" || $argv[2] == "--verbose") $verbose = true;

// Help mode
if(in_array($argv[1],array("--help","--usage","-h","-?"))){
echo <<<USAGE
"update.sh", script to schedule updates the Points for Books and Authors.

Usage:

  No arguments, perform the update.

  --help, -h, -? --usage
    This text.
    
  --verbose
    Verbose output, including every SQL query (successfull and error).

  --version, -v
    Prints the version and author of this program
    (--verbose bellow --version outputs more information).

USAGE;

// Version mode
}elseif(in_array($argv[1],array("--version","-v"))){
echo <<<VERSION
Project:  DPortal CMS; subproject codename Peachtown.
Filename: update.sh
Summary:  Scheduled Updates of Points for Books and Authors.

Copyright (c) Davod.
This program is published under the GNU General Public License.

VERSION;

if($verbose){
echo <<<DESCRIPTION

This script is intended to be user with 'cron', to perform scheduled Updates for
Points to every Book each 12 hours.

This script should be called form CLI  and NOT from Apache;  this will be killed
if user  attemps  to  call this  file  from Browser,  but,  because this file is
stored outter of DocumentRoot, is not accessable. By extension, the file will be
downloaded,  and the first  line to call the Shell,  will cause a fatal error if
is called form Browser.

Also, this file  should be called with  lower priority  ($ nice -n 10 ./foo.sh).

DESCRIPTION;

}

// Update mode
}else{
	// First, update points for each Book
	if($verbose) echo "  * Updating Books Points in `book_books`.`points`\t\t\t";
	$books_points_update = update_points_books_table();
	if($books_points_update === true && $verbose) echo "[OK]";
	elseif(empty($books_points_update) && $verbose) echo "[Fail]";
	if($verbose) echo "\n";

	// Second, update the `phpbb_users` table with the Points updated
	if($verbose) echo "  * Updating Users Points in `".USERS_TABLE."`.`points`\t\t\t";
	$users_points_update = update_points_users_table();
	if($users_points_update === true && $verbose) echo "[OK]";
	elseif(empty($users_points_update) && $verbose) echo "[Fail]";
	if($verbose) echo "\n";
	
	// And finally, try to drop the Smarty Cache of files that store this information
	if($verbose) echo "  * Trying to clean the Cache files...\n";
	$filelist = scandir(SMARTY_TEMPLATES_PATH.'cache');
	foreach($filelist as $file){
		if(preg_match("/^books_(featured|author|category){1}[\w^%]+(stories_index|sidebar_book){1}\.tpl$/",$file) > 0){
			if($verbose) echo "    Cleaning $file...";
			unlink(SMARTY_TEMPLATES_PATH."cache/$file");
			if($verbose && !is_file(SMARTY_TEMPLATES_PATH."cache/$file")) echo "\t[OK]\n";
			elseif($verbose && is_file(SMARTY_TEMPLATES_PATH."cache/$file")) echo "\t[Error]\n";
			$count++;
		}
	}
	if(empty($count)) echo "    No Cache files cleaned\n";
	
	$timestamp = time();
	$time = strftime("%c",$timestamp);
	
	file_put_contents('file:///var/www/peachtown/source/update.sh/log',"$timestamp;$time;Update points\n",FILE_APPEND);
}

// And finally, end the Script.
die;
?>