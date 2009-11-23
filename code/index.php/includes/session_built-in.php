<?php
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Built-in session manager                    #
		#  (session_built-in.php)                      #
		#                                              #
		#  Copyright Davod.                            #
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

// If the Administrator is loged in
if($user_admin){

	$loged_in = true;
	$user_admin = true;

	$smarty->assign('LOGED_IN',true);
	$smarty->assign('IS_ADMIN',true);
	$smarty->assign('PHPBB_USERNAME','Administrator');
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

	header("location:$redir");die();

// LOGOUT mode
}elseif(isset($_GET['LOGOUT']) && $loged_in){

	// Don't destroy the Session with session_destroy(),
	// because the Administrator can't be login again!

	$_SESSION[] = array();
	session_unset();
	header('location:index.php?seccion=home');die();

}
?>
