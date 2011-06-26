<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  General functions (general.php)             #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

/* Perform a raw download of a given file
 *
 * raw_download() performs a RAW Download from Server, in binary format.
 *
 * Parameters:
 *
 *	* string file
 *	   The path to the file
 *
 *	* string mime
 *	   The MIME type of the file if expected.
 *	   If not given (or FALSE), default is "application/octet-stream"
 *	   If TRUE, this function will attemp to get automatically the MIME type (see bellow).
 *
 * Returned values:
 *
 *	Nothing. This function will transfer the file if all is OK,
 *	give a 404 header and a text as "File does not exist"
 *
 * Observations:
 *
 *	If mime parameter is set to TRUE, this function will attemp to get automatically
 *	the MIME type using Fileinfo functions. This extension is only available in
 *	PHP >= 5.3.0 (included) or the PECL extension fileinfo >= 0.1.0 (not maintained there).
 *	See PHP Documentation of Fileinfo for details.
 *
 *	If is not possible to get the MIME through Fileinfo, the MIME will be the default.
 *
 */
 
// void raw_download(string path_to_file[, mixed MIME type = false])
function raw_download($file, $mimetype = false){

	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		
		// Attemp to get automatically the MIME using Fileinfo functions
		if($mimetype !== false && ((version_compare(PHP_VERSION,'5.3.0','>=') && version_compare(phpversion(fileinfo),'0.1.0','>=')) && is_callable('finfo_file'))){

			$finfo = finfo_open(FILEINFO_MIME);
			$mimetype = substr_replace(finfo_file($finfo,$file),'',strpos(finfo_file($finfo,$file),';'));

		// If MIME is not provided (false by default), MIME will be "application/octet-stream"
		}elseif($mimetype === false || preg_match("/[\w\/\.-]/",$mimetype) == 0) $mimetype = 'application/octet-stream';
		
		header('Content-Type: '.$mimetype);

		header('Content-Disposition: attachment; filename='.str_replace(' ','_',basename($file)));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	}else{
		header('HTTP/1.1 404 Not found');
		die($LANG['file_does_not_exist']);
	}
}

// string ext($filename)
function ext($filename){
	return substr(strrchr($filename, '.'), 1);
}


/* ABOUT THIS FUNCTION:
 *
 * This function reads the content of a directory given, with
 * scandir(), and gets the numbre of elements with count()
 *
 * The result is stored in a File called '.htfiles', that contain only
 * the number of files contained (except hidden files, fakedir and self).
 *
 * Why?
 *
 * This function is usefull to Caching the number of files in a
 * directory with a very large number of files, that if is called
 * scandir or another similar fucntion, these can consume resources.
 *
 */

// bool (count_files_cache(string dir)
function count_files_cache($dir){
	if(is_dir($dir) && is_writable($dir)){
		// 4 Files are 'fake_dir', then, the result rests 3
		$num = (count(scandir($dir)) - 3);
		$file = fopen("$dir/.htfiles",'wb');
		if(fwrite($file,$num)) $written = true;
		fclose($file);
	}
	if($written) return $written;
	else return false;
}

/* ABOUT THIS FUNCTION:
 *
 * This function get the Total size of files and the mumber of them
 * in a Directory, by performing a Loop with opendir()
 *
 * The two values are returned in a Arrray
 *
 * This function contain three parameters: 
 *
 *	- First, the Path to Directory, that should be a Directory
 *	These parameter is Obligatory, and return false is the
 *	path given is no a Directory
 *
 *	These value are String
 *
 *	- Second parameter is related to Powers of '1024',
 *	where $pow are the Exponent of the Base '1024'
 *
 *	Then, these value are the Divisor of a Division, where
 *	the Divisor are the Total Files sizes.
 *
 *	Posible values (Exponent):
 *	1024^0=1 (Bytes) ; 1024^1=1024 (KiB) ; 1024^2=1048576 (MiB)
 *
 *	Example: 905110 / (1024^1) = 883,9 Kib (aprox)
 *
 *	If these parameter are not given, 0 is default
 *	Remember, X^0=1 (any number exponed to 0 always is 1)
 *
 *	Value, are Float, with 2 decimals.
 *
 *- Third parameter are an Optional Pattern, to find only
 *	files that coincides with the pattern, usning preg_match()
 *	If no Pattern is give, the Check will not be do.
 *	Pattern in String SHOULD DON'T HAVE DELIMITERS, because
 *	the Delimiters are in preg_match function
 *
 */
 
// float get_dir_size (string directory[,int pow, string pattern]) 
function dircontents_size($directory, $pow = 0, $extension = null, $exclusion = null){

	if(!is_dir($directory)) return false;
	if(!is_integer($pow)) return false;

	$dir_resource = opendir($directory);
	$filesize = 0;
	while($filename = readdir($dir_resource)){
		if(nofakedir($filename) && ((stripos($filename,".$extension")) || $extension = null)){
			$filesize = filesize("$directory/$filename") + $filesize;
			if(!@stripos($filename,$exclusion)) $num++;
		}
	}
	closedir($dir_resource);

	if($num == 0) return null;
	
	$filesize = round($filesize / pow(1024,$pow),2);
	return array('dirsize'=>$filesize,'numfiles'=>$num);
}

// string get_filename_rand(string path[, string extension[, string exclusion]])
function get_filename_rand($dirname, $extension = null, $exclusion = null){
	if(!is_dir($dirname) || !is_readable($dirname)) return false;

	$dir = opendir($dirname);
	while($gfilename = readdir($dir)){
		if(nofakedir($gfilename) && strpos($gfilename,".$extension") !== false && strpos($gfilename,$exclusion) === false) $filename[] = $gfilename;
	}

	if($filename == null) return false;

	shuffle($filename);
	return $filename[0];
}

/* ABOUT THIS FUNCTION:
 *
 * Smarty don't have a Dynamic Block on their Modifies list!!!
 *
 * This function resolvs the problem with Dynamic Block by
 * simply putting {DYNAMIC} Dynamic Code {/DYNAMIC} in template,
 * if Caching is enabled.
 *
 * Parameters:
 *
 *	Actually, the Parameters are referer form Template
 *
 *	* Content: The content between {DYNAMIC} and {/DYNAMIC}
 *
 * Returned values:
 *
 *	The Content that should not be Cached, if Caching is
 *	enabled for these Tempolate.
 *
 */

// Smarty Registered Block string dynamic($param, $content, &$smarty)
function dynamic($params, $content, &$smarty) {
    return $content;
}

/* ABOUT THIS FUNCTION
 *
 * This Function is intended to create portable Popup messages
 * in Javascript, that code is placed in BODY tag, with 'onload'
 * 
 * Parameters form Template:
 *
 * * Message: The message that you want to popup to Client
 *		
 * *	Type: A Type of Popup message. Values should be
 *		'alert', 'confirm' and <<>>.
 *		If no type is given, 'confirm' is default.
 *
 * Returned values:
 *
 *	Returns a String with a Javascript function with Popups the message.
 *	If Message is null (non-assigned to Template) this function returns null.
 *
*/

// Smarty Registered Function string popup_message(array params, &$smarty
function popup_message($params, &$smarty){

	$message = $params['message'];
	switch($params['type']){
		case 'alert'	: $type = 'alert'; break;
		default				: $type = 'confirm'; break;
	}

	if($message != null) return " onload=\"$type('$message');\"";
	else return null;
}

// int reduce(int size)
function reduce($size,$array = false){
	$pow = 0;
	while($size){
		if($num > 100 || $size < 1024) break;

		$size = $size / 1024;	$pow++;
	}
	return $pow;
}

function truncate($string, $length = 80, $etc = '...', $break_words = false, $middle = false)
{
    if ($length == 0)
        return '';

    if (strlen($string) > $length) {
        $length -= min($length, strlen($etc));
        if (!$break_words && !$middle) {
            $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
        }
        if(!$middle) {
            return substr($string, 0, $length) . $etc;
        } else {
            return substr($string, 0, $length/2) . $etc . substr($string, -$length/2);
        }
    } else {
        return $string;
    }
}

function auto_lower($string){

	if(preg_match("/[A-Z0-9-_]*/",$string) > 0) $string = ucfirst(strtolower($string));

	echo "$string "; // return doesn't work.
}

function auto_ucfirst($string, $uc_digits = null,$auto_lower = false){

	if($auto_lower){
	
		$string_array = array_filter(explode(' ',$string),'auto_lower');
		
		$string = implode(' ',$string_array);
	
	}else $string = ucfirst($string);
	
	return $string;
}

// array get_license(string type, string author)
function get_license($type = '0', $author = PHPBB_USERNAME){

	global $LANG;
	
	// Type may be Numerical, but should be treated as String!!!
	switch($type){
		case '0'		: $note = '&copy; Copyright &quot;' . $author . '&quot;. ' . ucfirst($LANG['all_rights_reserved']) . '.<br />' . ucfirst($LANG['no_copy']) . '.'; break; // Copyright notice, null
		case '1'		: $note = $LANG['CC_by']; $link = $LANG['CC_by_URL']; break; // CC Attribution
		case '2'		: $note = $LANG['CC_by-nc-nd']; $link = $LANG['CC_by-nc-nd_URL']; break; // CC Attribution - Non Commercial - 
		case '3'		: $note = $LANG['CC_by-nc-sa']; $link = $LANG['CC_by-nc-sa_URL']; break; // CC Attribution - Non-Commercial - Share alike
		case '4'		: $note = $LANG['public_domain']; // Public domain
		default: $note = $type; // Custom license
	}
	
	return array($note,$link);
}



/* Get the time remaining of a given Timestamp against current Timestamp
 *
 * get_left() is a simple and multipurpose function that return the time remaning
 * by passing an arbitrary Timestamp plus a Greace Period, against the current Timestamp.
 * Very usefull to control Posting Comments and waiting to avoid repetidely comments (possible Spam).
 *
 * Operation is "($timestamp_published + $greace_period) - $timestamp_now"
 *
 * $timestamp_now can be the curretnt Timestamp using time() or an arbitrary Timestamp.
 *
 *
 * Parameters:
 *
 *	* int timestamp_published
 *	   The Timestamp of the comment
 *
 *	* int greace_period
 *	   * The second to wait. Default is 900 seconds (15 minutes)
 *
 *	* int timestamp_now
 *	   An optional value for Current Timestamp, for past or future checks.
 *	   Default is null and will be the Current Timestamp
 *
 * Returned values:
 *
 *	This function will return the seconds remaning as INTEGER.
 *	If time remaning is 0 or less, or any data recived is not INTEGER,
 *	this function will return boolean TRUE.
 *
*/

// mixed get_left(int timestam_published[, int greace_period])
function get_left($timestamp_published, $greace_period = null, $timestamp_now = null){

	global $user_admin;
	
	if($user_admin) return true;
	
	// If timestamp is null or not a integer value, uncondionately return TRUE
	if(is_numeric($timestamp_published)) $timestamp_published = +$timestamp_published; // Convert to integer
	if(is_numeric($greace_period) || empty($greace_period)) $timestamp_published = +$timestamp_published; // Convert to integer

	if(!is_integer($timestamp_published) || $timestamp_published <= 0) return true;

	if($timestamp_now == null) $timestamp_now = time(); // Default current time
	if($greace_period == null) $greace_period = 900; // Default 15 minutes
	
	if((($timestamp_published + $greace_period) - $timestamp_now) <= 0) return true;
	else return (($timestamp_published + $greace_period) - $timestamp_now);
}

/* Return a paragraph or count paragraphs
 *
 * get_paragraphs() will return a portion of a (large) string, or paragraph,
 * or count the number of paragraphs, by using a regular expresion (see bellow).
 *
 * Parameters:
 *
 *	* string content
 *	   The content to be parsed.
 *
 *	* bool count
 *	   If return a paragraph determinated, or the number of pagagraphs.
 *	   If this parameter is not set (or set true), the rest
 *	   of parameters will be ignored (see bellow).
 *
 *	* int num
 *	   The paragraphs per page (see details bellow).
 *	   If num is explicitely NULL, no limit is set and return the entry content
 *
 *	* int page
 *	   The number of page (see details bellow).
 *
 *
 * Returned values:
 *
 *	This function will return the number of paragraphs by default. If count parameter
 *	is empty (true by default), the rest of the parameters will be ignored. 
 *
 *	If count parameter is FALSE, this function will return a portion of the
 *	String recived, according to the other parameters or default of them. 
 *
 *	If $content is empty, this function will return FALSE.
 *
 * Observations:
 *
 *	We use preg_split() to get an Array with the paragraps (see the pattern).
 *	Afterwards, count these paragraphs with count().
 *
 *	If parameter count is FALSE, this function will attemp to get the
 *	paragraphs by pasing the parameters $page and $num.
 *
*	$page, as it suggets, is the Page that containt a number of iteartions
 *	defined by $num. Then, this function declare $start and $end (see operations).
 *
 *	This function use foreach to iterate through the Array and limiting
 *	by $start and $end and get a String of this iteration.
 *
 * Examples:
 *
 *	Return the number of paragraphs (no more parameters than $content)
 *
 *	   // Will return 25 paragraphs as INTEGER
 *	   $num_paragrapgs = get_paragrapgs($content);
 *
 *	Get a limited number of paragraphs, with default values
 *
 *	   // Will return the content limited to 50 paragraphs
 *	   $content = get_paragraphs($content,false);
 *
 *	If content is very extense, chunk with paragraphs with a custom number
 *	of paragraphs per page, and get them by page.
 *
 *	   // Parameter will be checked for correct type in Function
 *	   $page = $_GET['page']; // foo.php?page=3
 *
 *	   // Will return the content, from paragraph 60 to 80
 *	   $content = get_paragraphs($content,true,20,$page);
 *
 * Note:
 *
 *	Currently I'm not implemented this feature for content scripts yet.
 *
*/
// mixed get_paragraphs(string content[, bool count[, int num[, int page]]])
function get_paragraphs($content,$count = true,$num = 50,$page = 1){

	// Check for Content. This shouldn't be empty
	if(empty($content)) return false;
	
	// If content is greate than 1 MiB or $num is explicity NULL,
	// return the entry content inmediatelly.
	if((strlen($content) > 1048576) || $num === null) return $content;
	
	// Get the Paragraphs of Content as Array
	$paragraphs = preg_split('/[\r\n]+/', $content);
	
	$num_paragraphs = count($paragraphs);
	
	// If $count is false, return the paragraph as String.
	if($count === false){

		// Check for Pages if is Integer and greater than 1
		if(is_int($page) || $page >= 1) $index = $page - 1;
		else $index = 0;
		
		// Check if $num parameter is INTEGER
		if((!is_int($num) || $num <= 1)) $num = 50;
		
		// Set the Start and End of iteration
		$start = $num * $index;
		$end = $start + ($num -1);
		
		// If $start or $end is smaller or greater (respectivelly)
		// than the $num_paragrapgs, return the full Content.
		if(($start > $num_paragraphs) || (($end +1) > $num_paragraphs)) return $content;
		
		// Iterate though the Array and get the paragraphs as String
		foreach($paragraphs as $key=>$value){
			if($key >= $start && $key <= $end) $return_content .= $value;
		}
		
		// Clear memory by unset the Array
		unset($paragraphs);
		
		return $return_content;

	// If $count is true, return the number of paragraphs
	}else return $num_paragraphs;
}

?>
