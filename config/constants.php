<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Defined constants (constants.php)           #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################


/* :: Define the Paths as Constants.
 *
 * Here is defined the Paths to different directories as consants.
 * For portability reasons, you can place the sensible directories in another place
 * (/var/www/dportalcmd for public, '/var/local/dportalcms/' for Smarty Templates,
 * '/usr/lib/dportalcms' for functions, '/usr/lib/smarty' for Smarty class, etc).
 *
 * Originally, Paths are defined in the public directory, but I strongly recommended
 * to move sensible directories and place changes here. In Debian package,
 * directories was already moved to these directories.
 *
 */

// All should be SECURE forms to obtain Directory names
define('DPORTAL_ABSOLUTE_PATH',dirname(dirname(__FILE__))); // public_instalation (absolute)
define('DPORTAL_PATH',preg_replace("/^\/$/",'',dirname($_SERVER['PHP_SELF']))); // public access (relative)
define('DOCUMENT_ROOT',str_replace(DPORTAL_PATH,'',DPORTAL_ABSOLUTE_PATH)); // Document root (absolute)

// Absolute paths for Inclusion (remove ABSOLUTE_PATH to place another different paths).
define('CONFIG_PATH',DPORTAL_ABSOLUTE_PATH.'/config/');
define('LANG_PATH',DPORTAL_ABSOLUTE_PATH.'/lang/');
define('SMARTY_LIBRARIIES_PATH',DPORTAL_ABSOLUTE_PATH.'/libs/smarty/');
define('SMARTY_TEMPLATES_PATH',DPORTAL_ABSOLUTE_PATH.'/smarty/');
define('INCLUDES_PATH',DPORTAL_ABSOLUTE_PATH.'/includes/');
define('FUNCTIONS_PATH',DPORTAL_ABSOLUTE_PATH.'/includes/functions/');
define('UPDATES_PATH',DPORTAL_ABSOLUTE_PATH.'/updates/');
define('CONTENT_PATH',DPORTAL_ABSOLUTE_PATH.'/content/');
define('COMMENTS_PATH',DPORTAL_ABSOLUTE_PATH.'/comments/');
define('ENTRIES_PATH',DPORTAL_ABSOLUTE_PATH.'/entries/');
define('BACKUPS_PATH',DPORTAL_ABSOLUTE_PATH.'/content/');
define('IMAGES_PATH',DPORTAL_ABSOLUTE_PATH.'/images/');
define('GALLERY_PATH',DPORTAL_ABSOLUTE_PATH.'/images/gallery/');
define('VIDEOS_PATH',DPORTAL_ABSOLUTE_PATH.'/videos/');

?>