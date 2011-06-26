<?php

/* :: Define the Paths as Constants.
 *
 * Here is defined the Paths to different directories as consants.
 * For security reasons, you can place the sensible directories in another place
 * (for example "/var/www/dportalcms" for public, "/var/local/dportalcms/smarty" for Smarty Templates,
 * "/usr/lib/dportalcms" for functions, "/usr/lib/smarty" for Smarty class, etc).
 *
 * Originally, Paths are defined in the public directory, but I strongly recommended
 * to move sensible directories and place changes here. In Debian package,
 * directories was already moved to these directories.
 *
 * And finally, I declared a constant called REAL_DOCUMENT_ROOT, that
 * should reflect the Actual DocumentRoot. Because DOCUMENT_ROOT is defined in apache2.conf,
 * these configuration may not reflect the actual path, and may cause problems (serious!).
 *
 * All should be SECURE forms to obtain Directory names
 *
 */

// We assume than this file is installed in "/dportal/config", then get the partent parent dir
// of parent dir of this file. Please edit the following if place is different than default.

// Absolute paths for Inclusion (replace ABSOLUTE_PATH to place another paths for security purposes!).

define("CONFIG_PATH",DPORTAL_ABSOLUTE_PATH."/config/"); // Don"t modify!!!
define("LANG_PATH",HOMEPATH."/.libs/dportalcms_common/lang/");
define("SMARTY_LIBRARIES_PATH",HOMEPATH."/.libs/smarty_libs/");
define("FPDF_PATH",HOMEPATH."/.libs/fpdf/");
define("SMARTY_TEMPLATES_PATH",HOMEPATH."/.libs/dportalcms_$site_id/smarty_templates/");
define("INCLUDES_PATH",HOMEPATH."/.libs/dportalcms_common/includes/");
define("FUNCTIONS_PATH",HOMEPATH."/.libs/dportalcms_common/includes/functions/");
define("UPDATES_PATH",HOMEPATH."/.libs/dportalcms_$site_id/updates/");
define("CONTENT_PATH",HOMEPATH."/.libs/dportalcms_$site_id/content/");
define("COMMENTS_PATH",HOMEPATH."/.libs/dportalcms_$site_id/comments/");
define("ENTRIES_PATH",HOMEPATH."/.libs/dportalcms_$site_id/entries/");
define("BACKUPS_PATH",HOMEPATH."/.libs/dportalcms_$site_id/content/");
define("IMAGES_PATH",DPORTAL_ABSOLUTE_PATH."/images/");
define("GALLERY_PATH",DPORTAL_ABSOLUTE_PATH."/images/gallery/");
define("VIDEOS_PATH",HOMEPATH."/.libs/dportalcms_$site_id/videos/");
define("DPORTAL_TEMP_PATH",DPORTAL_ABSOLUTE_PATH."/.htmp/");

define("MODERATED_ADMIN",3);
define("MODERATED_OWNER",2);
define("MODERATED_USER",1);
define("MODERATED_ANONYMOUS",0);

?>