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

/* ABOUT THIS FUNCTION:
 *
 * This function performs a RAW Download from Server, in binary format.
 * 
 * First parameter, 'path_to_file' is required.
 * Second parameter, 'mime_type' is optional.
 * 
 * The second parameter is the MIME type of the file, given by the
 * Developer directly. These MIME type should be coincide than the
 * file that you want to download. Ex 'application/zip',
 * 'video/x-flv', 'application/vnd.oasis.opendocument.text', etc
 *
 * If the second parameter is not given, MIME type is
 * 'application/octet-stream' by default
 *
 */
 
// stream raw_download(string path_to_file[, string MIME type])
function raw_download($file, $mimetype = null){

	if (file_exists($file)) {
    header('Content-Description: File Transfer');
    if($mimetype == null) header('Content-Type: application/octet-stream');
    else header('Content-Type: '.$mimetype);
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
		$file = fopen("$dir/.htfiles",'w');
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
function dircontents_size($directory, $pow = 0, $pattern = null){

	if(!is_dir($directory)) return false;
	if(!is_integer($pow)) return false;

	$dir_resource = opendir($directory);
	$filesize = 0;
	while($filename = readdir($dir_resource)){
		if(nofakedir($filename) && ((preg_match("/$pattern/",basename($filename))) || $pattern = null)){
			$filesize = filesize("$directory/$filename") + $filesize;
			$num++;
		}
	}
	closedir($dir_resource);

	$filesize = round($filesize / pow(1024,$pow),2);
	return array('dirsize'=>$filesize,'numfiles'=>$num);
}

// string get_filename_rand(string path, bool use_base64)
function get_filename_rand($dirname, $pattern = null){
	if(!is_dir($dirname) || !is_readable($dirname)) return false;

	$dir = opendir($dirname);
	while($gfilename = readdir($dir)){
		if(nofakedir($gfilename) && preg_match("/$pattern/",$gfilename)) $filename[] = $gfilename;
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
function dynamic($param, $content, &$smarty) {
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

?>
