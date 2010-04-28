<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Footer include script (footer.php)          #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// This Script is uded in footer of every Script. This
// contain many functions at the end of Script, as
// Erasing the Session vars. You can add Debug or
// another code.

if(!defined('DPORTAL')) die();

// Obligatory
require('includes/unset_session_vars_common.php');

// Optionals

// For timing debug purposes only
$timeb = microtime(true);

// Show the Time of Execution of the Program in the tail of the page
// for debug purposes (uncomment if you want to show them)
//echo $timeb - $timea;

// End Script safethy here
die();

?>
