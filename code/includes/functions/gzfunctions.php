<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Functions for handle zlib (gzfunctions.php) #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

/* 
 * Smarty {fetch2} plugin, a modified version of {fetch} plugin.
 *
 *   Features:
 *
 * * Support for zlib uncompress. File, if is compressed with zlib/gzip, them will be
 *   uncompressed to Output. If file is not uncompressed with zlib, file will be output
 *   will be output as well.
 *
 * * Truncate option in the Function. This option allow to the Template designer to
 *   Truncate the contents and strip HTML tags, for summary pages (ideal for Newsletters).
 *
 * Please see function_fetch.php in Smarty plugins directory for more information
 * 
 */

// smarty_function fetch2(array params(file,truncate = false), class $smarty)
function fetch2($params, &$smarty)
{
    if (empty($params['file'])) {
        $smarty->_trigger_fatal_error("[plugin] parameter 'file' cannot be empty");
        return;
    }

    $content = '';
        
    $truncate = $params['truncate'];

    // Fetch files ONLY in DPORTAL_ABSOLUTE_PATH, for non-fancy security.
    if($zd = gzopen($params['file'],'r')) {
    	while (!gzeof($zd)) {
	   $content .= gzgets($zd, 4096);
	   }
	gzclose($zd);

	if(is_integer($truncate) && $truncate >= 10) return truncate(strip_tags($content),$truncate," (...)");
	else return $content;

    } else {
	$smarty->_trigger_fatal_error('[plugin] fetch cannot read file \'' . $params['file'] .'\'');
	return;
    }

    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'],$content);
    }
}

?>
