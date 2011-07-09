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
require(INCLUDES_PATH . 'unset_session_vars_common.php');

// Optionals

// For timing debug/benchmark purposes only
$timeb = microtime(true);

$total_time = $timeb - $timea;

// End Script safetly here
die();

?>
