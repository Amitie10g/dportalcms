<?php
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Built-in session manager                    #
		#  (session_built-in.php)                      #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// Gets the Session variables for Administration
if(isset($_SESSION['is_admin'])) $user_admin = $_SESSION['is_admin'];
else $user_admin = false;
$sessionid = session_id();

// Default Greace period for Comments
$time_left_greace_period = 900;

// If the Administrator is loged in
if($user_admin){

	$loged_in = true;
	$user_admin = true;
	$username = $admin_user;
	$user_website = 'http://' . $_SERVER['SERVER_NAME'] . DPORTAL_PATH;
	$user_email = $admin_email;
	$user_nick = $admin_nick;
	
	$time_left_greace_period = 0;
	
	define('PHPBB_USERNAME',$username);
	
	// Why ID is 2?
	// Because in phpBB User ID 1 is Anonymous, any user may be allowed to edit the chapters.
	// For backwards compatibility, ID 2 is the first user (Administrator and Founder) in phpBB.
	// If enabled, Author's Name will be the First Administrator.
	define('PHPBB_USER_ID',2);
	define('PHPBB_USER_EMAIL',$user_email);
	define('PHPBB_USER_WEBSITE',$user_website);
	
	$smarty->assign('LOGED_IN',true);
	$smarty->assign('IS_ADMIN',true);
	$smarty->assign('PHPBB_USERNAME',PHPBB_USERNAME);
	$smarty->assign('PHPBB_USER_NICK',$user_nick);
}

// LOGIN mode
if(isset($_GET['LOGIN']) && !$is_admin){

	$get_user = $_POST['username'];
	$get_pass = $_POST['password'];
	$redir = $_POST['redir'];

	if(ini_login($get_user,$get_pass)){

		$_SESSION['is_admin'] = true;
		$_SESSION['loged_in'] = true;
		$_SESSION['loged_ok'] = true;
		     
	}else{
		$_SESSION['not_loged_in'] = true;
	}

	if(!empty($redir)) header("location: $redir");
	else redir('blog','blog');
	die();

// LOGOUT mode
}elseif(isset($_GET['LOGOUT']) && $loged_in){

	// Don't destroy the Session with session_destroy(),
	// because the Administrator can't be login again!

	$_SESSION[] = array();
	session_unset();
	redir('index','home');die();

}

// string get_user_by_id(void)
function get_user_by_id($id = null,$mode = null){

	if($id != '2') return false;

	global $admin_user;
	global $admin_nick;
	global $admin_email;
	global $admin_website;
	
	// Perform the actions based in mode
	switch($mode){
		case 1: $value = $admin_user; // Username
		case 2: $value = 3; break; // Type
		case 3: $value = $admin_email; break; // Website
		case 4: $value = $admin_website; break; // Email
		default:$value = $admin_nick; break; // Default, Nick
	}
	
	return $value;
}
?>
