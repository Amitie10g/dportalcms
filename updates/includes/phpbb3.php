<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Script for manage phpBB session (phpBB3.php)#
		#                                              #
		#  This is Third party code. The author don't  #
		#  display a License, then, I licensed this    #
		#  under the GPL.                              #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

define('IN_PHPBB', true);

/* NOTE:
 *
 * REAL_DOCUMENT_ROOT has been defided in constants.php as Constant,
 * in replacement of DOCUMENT_ROOT and $_SERVER['DOCUMENT_ROOT'],
 * because these may no reflect the REAL DocumentRoot path, to the Script.
 *
 * These Superglobal Variable are declared -or defined- in 
 * apache2.conf, and if Scripts resides in a different path
 * problems are obvious.
 *
*/

// Absolute path to Forum!
$phpbb_root_path = REAL_DOCUMENT_ROOT . $phpbb_dir;

// URL Path (DON'T CHANGE THE VARIABLE AND CONSTANT NAMES!!!)
$phpbb_url_path = 'http://'.$_SERVER['SERVER_NAME'].$phpbb_dir;
define('PHPBB_URL_PATH',$phpbb_url_path);

$phpEx = substr(strrchr(__FILE__, '.'), 1);

require_once($phpbb_root_path.'common.'.$phpEx);
require_once($phpbb_root_path.'config.'.$phpEx);

// Starts the phpBB session 
$user->session_begin(); 
$auth->acl($user->data); 
$user->setup();

$time_left_greace_period = 900;

// If the user is registered and starts session
if($user->data['is_registered']){ 
	$loged_in = true;
	$smarty->assign('LOGED_IN',true);
	
	$time_left_greace_period = 60; // 60 seconds is time for waiting in posting commonts for registered users
	
	// And, if the User is Administrator
	if($user->data['user_type'] == 3){
		$user_admin = true;
		$smarty->assign('IS_ADMIN',true);
		$time_left_greace_period = 0;
	// or, if user is Global Moderator. Currently, no features with these permission are implemented
	}elseif($user->data['user_type'] == 2){
		$user_moderator = true;
		$smarty->assign('IS_MODERATOR',true);
		$time_left_greace_period = 15;
	}
}

// Variables
$user_id = $user->data['user_id'];
$username = $user->data['username'];
$user_email = $user->data['user_email'];
$user_website = $user->data['user_website'];
$sessionid = $user->data['session_id'];

// Constants
define('PHPBB_USER_ID',$user_id);
define('PHPBB_USERNAME',$username);
define('PHPBB_USER_EMAIL',$user_email);
define('PHPBB_USER_WEBSITE',$user_website);
define('PHPBB_SESSION_ID',$sessionid);
define('PHPBB_USER_PROFILE',PHPBB_URL_PATH . 'memberlist.php?mode=viewprofile&u=' . PHPBB_USER_ID);


// Smarty variables
$smarty->assign('PHPBB_URL_PATH',$phpbb_url_path);
$smarty->assign('PHPBB_USER_ID',$userid);
$smarty->assign('PHPBB_USERNAME',$username);
$smarty->assign('PHPBB_SESSION_ID',$sessionid);

$use_phpbb = true;
$smarty->assign('USE_PHPBB',true);

/* Multipurpose function to get Username or another data from them, by their ID
 *
 * get_user_by_id() is very similar to a function in phpBB for the same purpose, but simplified.
 * This function will return a String or an Array based on the value of mode.
 *
 * Parameters:
 *
 *	* Mixed id
 *	   The phpBB User ID. It should be INTEGER, but it can be a Numerical STRING.
 *	   Then, it will be converted to INTEGER and checked against if is valid.
 *
 *	* int mode
 *	    The Mode (see bellow). Possible values are:
 *
 *		1, Return the User's type as INTEGER
 *		2, Return the User's Email address (user_email) as STRING
 *		3, Return the User's Website (user_website) as STRING
 *		4, Return some data of User as Array
 *		0, NULL or another value.- The User name (username) as STRING
 *
 * Returned values:
 *
 *	This function will return the data above based on mode (STRING, INTEGER or ARRAY).
 *	In case of error (invalid result or invalid user) will return FALSE
 *
 * Observations:
 *
 *	This function should return ONLY a result from a Valid username.
 *	This is, the Founder (with ID 2), or a normal user (NOT Robots or Anonymous user
 *	that have ID 1!!!).
 * 
*/
// mixed get_user_by_id(int id, int mode)
function get_user_by_id($id, $mode = null){

	if(is_numeric($id)) $id = +$id; // Convert STRING to INTEGER if needed
	if((!is_integer($id) || $id < 2)) return false; // If ID is not Integer, return FALSE. Anonymous or  SHOULD not be returned

	// Declare the pointer to the Database, declared in phpBB
	global $db;

	// The SQL Query. We should filter against the user_type, 0 is Registered user and 3  is moderator. 2 is Anonymous or Robots!
	$sql = "SELECT user_id, username, user_type FROM " . USERS_TABLE . " WHERE user_id = $id and (user_type = 0 or user_type = 3)";			

	// Perform the Query against the database
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	// And check if the result is valid. If not, return FALSE
	if(($result == false || $row == false)) return false;

	// Perform the actions based in mode
	switch($mode){
		case 1: $value = $row['user_type']; break; // Type
		case 2: $value = $row['user_email']; break; // Website
		case 3: $value = $row['user_website']; break; // Email
		case 4: $value = PHPBB_URL_PATH . "memberlist.php?mode=viewprofile&u=$id"; // User Profile URL
		case 5: $value = array('username'=>$row['username'],$row['user_email'],$row['user_website'],$row['user_type']); break; // More data as Array
		default:$value = $row['username']; break; // Default, Username
	}

	// And finally, return the value
	if($row['user_type'] == 3 || $row['user_type'] == 1 || $row['user_type'] == 0) return $value;
	else return false;
}

function get_id_by_user($username){

	// Declare the pointer to the Database, declared in phpBB
	global $db;

	$sql = "SELECT user_id, username FROM " . USERS_TABLE . " WHERE username = '$username' LIMIT 1";			

	// Perform the Query against the database
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	// And check if the result is valid. If not, return FALSE
	if(($result == false || $row == false)) return false;
	return $row['user_id'];
}

?>
