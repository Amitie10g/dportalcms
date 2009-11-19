<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Script for manage phpBB session (phpBB3.php)#
		#                                              #
		#  This is Third party code. The author don't  #
		#  display a License, then, I licensed this    #
		#  under the GPL.
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

define('IN_PHPBB', true);

/* NOTE:
 *
 * DOCUMENT_ROOT eas be deniden in config.php as Constant,
 * because the Superglobal variable $_SERVER['DOCUMENT_ROOT']
 * may no reflect the REAL DocumentRoot path, to the Script.
 *
 * These Superglobal Variable are declared -or defined- in 
 * apache2.conf, and if Scripts resides in a different path
 * problems are ovious.
 *
*/

// Absolute path to Forum!
$phpbb_root_path = DOCUMENT_ROOT . $phpbb_dir;

// URL Path
$phpbb_url_path = 'http://'.$_SERVER['SERVER_NAME'].$phpbb_dir;

$phpEx = substr(strrchr(__FILE__, '.'), 1);

require_once($phpbb_root_path.'common.'.$phpEx);
require_once($phpbb_root_path.'config.'.$phpEx);

// Starts the session 
$user->session_begin(); 
$auth->acl($user->data); 
$user->setup();

// If the users started Session
if($user->data['is_registered']){ 
	$loged_in = true;
	$smarty->assign('LOGED_IN',true);
	
	// And, if the User is Admin
	if($user->data['user_type']){
		$user_admin = TRUE;
		$smarty->assign('IS_ADMIN',true);
	}
}

$userid = $user->data['user_id'];
$username = $user->data['username'];
$sessionid = $user->data['session_id'];

// Smarty
$smarty->assign('PHPBB_URL_PATH',$phpbb_url_path);
$smarty->assign('PHPBB_USER_ID',$userid);
$smarty->assign('PHPBB_USERNAME',$username);
$smarty->assign('PHPBB_SESSION_ID',$sessionid);

?>
