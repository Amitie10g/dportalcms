<?php

/* :: Define the Paths as Constants.
 *
 * Here is defined the Paths to different directories as consants.
 * For security reasons, you can place the sensible directories in another place
 * (for example '/var/www/dportalcms' for public, '/var/local/dportalcms/smarty' for Smarty Templates,
 * '/usr/lib/dportalcms' for functions, '/usr/lib/smarty' for Smarty class, etc).
 *
 * Originally, Paths are defined in the public directory, but I strongly recommended
 * to move sensible directories and place changes here. In Debian package,
 * directories was already moved to these directories.
 *
 * And finally, I declared a constant called REAL_DOCUMENT_ROOT, that
 * should reflect the Actual DocumentRoot. Because DOCUMENT_ROOT is defined in apache2.conf,
 * these configuration may not reflect the actual path, and may cause problems (serious!).
 *
 */

// All should be SECURE forms to obtain Directory names
define('DPORTAL_ABSOLUTE_PATH',dirname(dirname(__FILE__))); // public_instalation (absolute!)
define('DPORTAL_PATH',preg_replace("/^\/$/",'',dirname($_SERVER['PHP_SELF']))); // public access (relative)
define('REAL_DOCUMENT_ROOT',str_replace(DPORTAL_PATH,'',DPORTAL_ABSOLUTE_PATH)); // Actual DocumentRoot (absolute!)

// Absolute paths for Inclusion (replace ABSOLUTE_PATH to place another paths for security purposes!).
define('CONFIG_PATH',DPORTAL_ABSOLUTE_PATH.'/config/'); // Don't modofy!!!
define('LANG_PATH',DPORTAL_ABSOLUTE_PATH.'/lang/');
define('SMARTY_LIBRARIES_PATH',DPORTAL_ABSOLUTE_PATH.'/libs/smarty/');
define('FPDF_PATH',DPORTAL_ABSOLUTE_PATH.'/libs/fpdf/');
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
define('DPORTAL_TEMP_PATH',DPORTAL_ABSOLUTE_PATH.'/.htmp/');

?>