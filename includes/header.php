<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Header include file (header.php)            #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// This script contains the Headers of ally Scripts in DPortal CMS

// For timing debug purposes only
$timea = microtime(true);

//if(!defined('DPORTAL')) die();

// Starts the session
session_start();

// Gets the Config file
require_once('config/config.php');

// Add your custom headers here, but with care.

?>
