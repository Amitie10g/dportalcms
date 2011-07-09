<?php

define("CONFIG_PATH",DPORTAL_ABSOLUTE_PATH."/config/"); // Don"t modify!!!
define("LANG_PATH",LIBS_PATH."/dportalcms_common/lang/");
define("SMARTY_LIBRARIES_PATH",LIBS_PATH."/smarty_libs/");
define("FPDF_PATH",LIBS_PATH."/fpdf/");
define("SMARTY_TEMPLATES_PATH",LIBS_PATH."/dportalcms_$site_id/smarty_templates/");
define("INCLUDES_PATH",LIBS_PATH."/dportalcms_common/includes/");
define("FUNCTIONS_PATH",LIBS_PATH."/dportalcms_common/includes/functions/");
define("COMMENTS_PATH",LIBS_PATH."/dportalcms_$site_id/comments/");
define("ENTRIES_PATH",LIBS_PATH."/dportalcms_$site_id/entries/");
define("BACKUPS_PATH",LIBS_PATH."/dportalcms_$site_id/backups/");
define("DPORTAL_TEMP_PATH",LIBS_PATH."/dportalcms_$site_id/temp/");

define("MODERATED_ADMIN",3);
define("MODERATED_OWNER",2);
define("MODERATED_USER",1);
define("MODERATED_ANONYMOUS",0);

?>