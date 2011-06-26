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

/* Smarty {fetch2} plugin, a modified version of {fetch} plugin.
 *
 *   Features:
 *
 * * Support for zlib uncompress. File, if is compressed with zlib/gzip, them will be
 *   uncompressed to Output correctly. If file is not uncompressed with zlib,
 *   file will be output as well.
 *
 * * Truncate option in the Function. This option allow to the Template designer to
 *   Truncate the contents and strip HTML tags, for summary pages (ideal for Newsletters).
 *
 * * Limit the number of paragraphs and pages using get_paragraphs()
 *
 * Please see function_fetch.php in Smarty plugins directory for more information
 * 
 */

// smarty_function fetch2(array params(file,truncate = false,page = null,num = null), class $smarty)
function fetch2($params, &$smarty)
{
    if (empty($params['file'])) {
        $smarty->_trigger_fatal_error("[plugin] parameter 'file' cannot be empty");
        return;
    }

    $content = '';
    
    if(!empty($params['strip'])){
	
		if($params['strip'] === true){
			$strip = null;
		}else{
			foreach(explode(',',$params['strip']) as $item){
				$strip[] = '<'.$item.'>';
			}
			$strip = implode(',',$strip);
	    }
    }
       
    if(!empty($params['truncate'])) $truncate = $params['truncate'];
    
    if(!empty($params['page'])) $page = $params['page'];
    if(!empty($params['num'])) $num = $params['num'];
    
    if(!empty($params['wrap'])) $wrap = $params['wrap'];
    else $wrap = 80; // Wrap by default (<pre> may be broken; avoid use them in content!
    

    // Fetch files ONLY in DPORTAL_ABSOLUTE_PATH, for non-fancy security.
    if($zd = gzopen($params['file'],'rb')) {
    	while (!gzeof($zd)) {
	   $content .= gzgets($zd, 8192);
	   }
	gzclose($zd);
	
	// Use get_paragraphs() to limit the number of paragraphs.
	if(is_int($page) && $is_int($num)) $content = get_paragraphs($content,false,$page,$num);

	// Use strip_tags()
	if(isset($strip)) $content = strip_tags(str_ireplace(array('<h1>','</h1>','<h2>','</h2>'),array('<b>','</b>','<b>','</b>'),$content),$tags);

	// Use truncate() to limit the lengh of content
	if(is_int($truncate) && $truncate >= 10) $content = truncate($content,$truncate," (...)");

	// Use wordwrap() to wrap the contents
	if((is_int($wrap) && $wrap >= 10)) $content = wordwrap($content,$wrap);

	return $content;

    } else {
	$smarty->_trigger_fatal_error('[plugin] fetch cannot read file \'' . $params['file'] .'\'');
	return false;
    }
}

/* Compress as tring using the best compression code available
 *
 * customcompress() will check for available compression codes (LZMA, BZIP2, GZIP, etc)
 * and perform the compression of a string.
 *
 * Parameters:
 *
 *	mixed stream:
 *	   The stream to be compressed
 *
 *	int method:
 *	   The method to be used. Possible values are:
 *	   CUSTOMCOMPRESS_LZMA
 *	   CUSTOMCOMPRESS_BZ2
 *	   CUSTOMCOMPRESS_GZIP
 *
 * Returned values:
 *
 *	This function will return the compressed stream form the used function,
 *	or FALSE in case of error.
 *
 */

?>
