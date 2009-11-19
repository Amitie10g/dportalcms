<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  user defined Constants (constants.php)      #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// :: Define the paths as Constants.

// All should be SECURE forms to obtain Directory names
define('DPORTAL_ABSOLUTE_PATH',dirname(dirname(__FILE__)));
define('DPORTAL_PATH',preg_replace("/^\/$/",'',dirname($_SERVER['PHP_SELF'])));
define('DOCUMENT_ROOT',str_replace(DPORTAL_PATH,'',DPORTAL_ABSOLUTE_PATH));

// Absolute paths for Inclusion
define('CONTENT_PATH',DPORTAL_ABSOLUTE_PATH.'/content/');
define('COMMENTS_PATH',DPORTAL_ABSOLUTE_PATH.'/comments/');
define('ENTRIES_PATH',DPORTAL_ABSOLUTE_PATH.'/entries/');
define('BACKUPS_PATH',DPORTAL_ABSOLUTE_PATH.'/content/');
define('LANG_PATH',DPORTAL_ABSOLUTE_PATH.'/content/');
define('IMAGES_PATH',DPORTAL_ABSOLUTE_PATH.'/images/');
define('GALLERY_PATH',DPORTAL_ABSOLUTE_PATH.'/images/gallery/');
define('VIDEOS_PATH',DPORTAL_ABSOLUTE_PATH.'/videos/');
define('FUNCTIONS_PATH',DPORTAL_ABSOLUTE_PATH.'/includes/functions/');
define('INCLUDES_PATH',DPORTAL_ABSOLUTE_PATH.'/includes/');
define('CONFIG_PATH',DPORTAL_ABSOLUTE_PATH.'/config/');
define('SMARTY_DIR',DPORTAL_ABSOLUTE_PATH.'/libs/smarty3/');

?>
