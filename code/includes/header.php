<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Header include file (header.php)            #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// This script contains the Headers of ally Script
// in DPortal CMS, as the Configuration include and 
// the Session manage.

// For debug purposes only
$timea = microtime(true);

if(!defined('DPORTAL')) die();

// Starts the session
session_start();

// Gets the Config file
require_once('config/config.php');

?>
