<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Built-in Authentation (auth.php)            #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

/* INI file based Login
 *
 * This function checks the data recived form LOGIN, and compare
 * with the User and Password in the Config file.
 *
 * Parameters:
 *
 *	String get_user: Username recived from the Form.
 *
 *	String password: The Password recived form the Form.
 *
 * Return values:
 *
 *	If Username and Password coincids with the data stored,
 *	this function returns BOLLEAN true. Elsewhere, return
 *	BOOLEAN false.
 *
 */

// bool auth_login(string user, string password
function ini_login($get_user,$get_pass){

    // User and Password declared as GLOBAL
    global $admin_user;
    global $admin_password;

    if($get_user == $admin_user && sha1($get_pass) == $admin_password) return true;
		else return false;
}

// I will create more functions for authentication in the future
?>
