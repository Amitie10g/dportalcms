<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Function for proper                         #
		#  Directorie listing (fakedir.php)            #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

/* ABOUT THIS FUNCTION:
/*
/* This function only check for a Dirname provided by a LOOP
/* value from read_dir()function. An INCORRECT VALUE of them, are
/* '.' and '..' (Parent dir), and MUST BE NOT passed for any
/* declaration inside the Loop.
/* 
/* This function only take the value and check if is not
/* incorrect, but can be extended with user-defined values
/* for these.
/*
/* If the file is not a 'Fake dir', returns <true>. 
*/
// bool nofakedir(string file_dir_name[, int type, bool allow_list])
function nofakedir($file,$type = 0, $allow_list = true){

	if($file != '.htaccess' && $file != '.' &&	$file != '..' && (($allow_list && nolistfile($file))||!$allow_list))	return true;
}

function nolistfile($file){
	if($file != '.htfiles' && $file != ".svn" &&
	$file != '.list' && $file != '.name') return true;
}

?>
