<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Footer include script (footer.php)          #
		#                                              #
		#  Copyright Davod.                            #
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
require_once('includes/erase_session_vars.php');

// Optionals

// For debug purposes only
$timeb = microtime(true);
//echo $timeb - $timea;

die();

?>
