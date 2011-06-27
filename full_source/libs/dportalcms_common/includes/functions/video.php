<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Functions for Media Player (video.php)      #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License.                 #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

/* Get the Playlist data.
 *
 * This function get the Playlist.
 *
 * The directory 'videos' contains sub-directories that are
 * the 'Playlists'. Inside them (the sub-directories) has the Videos.
 *
 * This function performs two operation in the same way:
 *
 * Parameters:
 *
 *	*	String dirname: that is the Fullpath to
 *		the Directory containing Videos.
 *
 * Returned values:
 *
 *	*	An Array with the Videos and data are returned.
 *	
 *	*	If no data found, the Array is null and Function
 *		returns these value.
 *	
 *	*	If an error occurrs (as Directory does not exists),
 *		this Function returns BOOLEAN false.
 *
*/

// array getplaylist(string playlist)
function getplaylist($playlist){

	if(!is_dir(VIDEOS_PATH . $playlist) && !is_readable(VIDEOS_PATH . $playlist)) return false;

	$dir = opendir(VIDEOS_PATH . $playlist);
	while ($filename = readdir($dir)){

		if(nofakedir($filename) && !strpos($filename,"_hq") && ext($filename) == 'flv'){
			$split_file = explode('.',$filename);
			$uri = base64_encode(strrev(base64_encode("$playlist;$filename")));
			$info = getvideoinfo(VIDEOS_PATH . "$playlist/$filename");
			$list[] = array('title'=>$split_file[0],'uri'=>$uri,'duration'=>$info['duration'],'filesize'=>$info['filesize'],'filesize_hq'=>$info['filesize_hq'],'rate'=>$info['rate'],'rate_hq'=>$info['rate_hq']);
		}
	}

	if($list != null) sort($list);								 
	return $list;
}

/* Get the Showcase (playlists) data.
 *
 * This function is similar to Playlist. The only difference,
 * is than is formely 'Showcase', or 'Playlist of Playlists'
 *
 * This function open the Directory that contains sub-directories
 * of the Videos.
 *
 * Parameters:
 *
 *	*	No parameters are needed
 *
 * Returned values:
 *
 *	*	This function return an Array of data.
 *
 *	*	If the Array is null, these value are returned.
 *
*/

// array getshowcase (void)
function getshowcase(){

	global $user_admin;

	$dir = opendir(VIDEOS_PATH);
	while ($dirname = readdir($dir)){
		if(!nofakedir($dirname)) continue;
		if(is_file(VIDEOS_PATH."$dirname/.name")){
			$img = get_filename_rand(VIDEOS_PATH.$dirname,"flv","_hq");
			$dirsize = dircontents_size(VIDEOS_PATH.$dirname,2,"flv","_hq");
			$title = file_get_contents(VIDEOS_PATH."/$dirname/.name");
			if($dirsize != null || $user_admin) $list[] = array('dirname'=>$dirname,'title'=>$title,'dirsize'=>$dirsize['dirsize'],'numfiles'=>$dirsize['numfiles'],'img'=>base64_encode(strrev(base64_encode("$dirname;$img"))));
		}
	}
	closedir($dir);

	if($list != null) natsort($list);
	return $list; // Arrray or null
}


//bool delete_videos(string playlist, array videos)
function delete_videos($playlist, $videos){

	global $smarty;

	if(!is_array($videos)) return false;

	$num = 0;
	foreach($videos as $item){
	
		$video = explode(';',base64_decode(strrev(base64_decode($item))));
		$video = VIDEOS_PATH . $video[0] . '/' . $video[1];
		$video_hq = str_ireplace('.flv','_hq.flv',$video);
		
		if(is_readable($video)) unlink($video);
		else break;
		if(is_readable($video_hq)) unlink($video_hq);
		@unlink(IMAGES_PATH . 'thumbs/' . base64_encode(basename($video)));
		
		
		$smarty->clear_cache(null,"player|$item");
		$smarty->clear_cache('header_title.tpl',$item);
		
		$num++;
	}
	if($num > 0) return true;
	else return false;
}


// bool delete_playlist(string playlist)
function delete_playlist($playlist){

	if(is_dir(VIDEOS_PATH . $playlist)){
		if($dir = opendir(VIDEOS_PATH . $playlist)){
			while(($file = readdir($dir)) !== false){
				if($file != '.' && $file != '..'){
					if(!@unlink(VIDEOS_PATH . "$playlist/$file")) return false;
					@unlink(IMAGES_PATH . 'thumbs/' . base64_encode(basename($file)));
				}
			}
			if(rmdir(VIDEOS_PATH . $playlist)) return true;
			else return false;
		}
		else return false;
	}
	else return false;
}

// bool create_playlist(string name, string title)
function create_playlist($name,$title){

	global $single_string;
	global $name_string;

	$checkname = preg_match($single_string,$name);
	$checktitle = preg_match(htmlentities($name_string),$name);	
	if(!is_writable(VIDEOS_PATH) && $checkname == 0) return false;
	
	if(mkdir(VIDEOS_PATH . $name)){
		$title_file = VIDEOS_PATH . $name . '/.name';
		$output = "$title";
		$write = file_put_contents($title_file,$output);
	}
	if($write != false) return true;

}


/* Download Video with or without Streaming support
 *
 * This function only redirect to 1 of 2 functions, if one is available.
 * The first function is related to SWFVideoStreamclass, and the second,
 * is rawdownload().
 *
 * Parameters:
 *
 *	String Filename: The fullpath to the Video file.
 *
 *	Bool use_streaming: If you want to use Streaming.
 *
 * Returned values:
 *
 *	The return value are the Returned value
 * of the correspondient Function.
 *
 */

// bool get_video(string filename[, bool use_streaming = true])
function getvideo($filename,$use_streaming = true){

	if($use_streaming) return streaming_download($filename);
	else return raw_download($filename,'video/x-flv');
}

/* Get information about a Video
 *
 * This function get Information about a particular Video
 * as duration, Bitrate, etc, using FFMPEG functions.
 *
 * Parameters:
 *
 *	String filename: The Fullpath to Video.
 *
 * Returned values:
 *
 *	An Array with information is returned.
 *
 *	If an error ocurrs (as Filename does not exists,
 *	or FFMPG Class not found), this function return BOOLEAN false.
 *
 * Note:
 *
 *	These features can consume much resources, but the result
 *	are 'Smarty Cahed' in template. If Cached template exist,
 *	this Function will not be called.
 *
 */

// array getvideoinfo(string filename)
function getvideoinfo($filename){

	if(!class_exists("ffmpeg_movie")) return false;

	if(!is_readable($filename) || !is_file($filename)) return false;

	$filename_hq = str_replace('.flv','_hq.flv',$filename);

	$movie = new ffmpeg_movie($filename);
	$duration = $movie->getDuration();
	$filesize = round((filesize($filename)/1048576),1);
	$bitrate = round($movie->getBitRate() / 1024);
	
	if(file_exists($filename_hq) && sha1_file($filename) != sha1_file($filename_hq)){
		$movie_hq = new ffmpeg_movie($filename_hq);
		$filesize_hq = round((filesize($filename_hq)/1048576),1);
		$bitrate_hq = round($movie_hq->getBitRate()/1024);
	}

	return array('duration'=>$duration,'filesize'=>$filesize,'filesize_hq'=>$filesize_hq,'rate'=>$bitrate,'rate_hq'=>$bitrate_hq);
}

/* Generate and output a Thumbnail of a Video.
 *
 * This function generates a Thumbnail of a Video.
 * This feature is supported only if GD and FFMPEG are
 * are instaled and enabled as PHP Modules.
 *
 * Parameters:
 *
 *	*	String video: A Full path of the Video
 *
 *	* int frame: A particular Frame where you want to obtain
 *		an Image form these Frame. Valid values are form 1 to infinite.
 *
 *		If the value given is greater	than the 'Number of Frames of the Movie'
 *		[using $movie->getFrameCount()] or these value are not INTEGER,	these value
 *		is silenty ignored and the default value are passed	to $movie->getFrame().
 *
 *		If these value are INTEGER 0 (zero), a Random number between 1 and
 *		'Number of frames' is passed to Function for generate Frame.
 *
 *	
 *	*	Bool to_file: If you want to dump the image resultant, leave empty
 *		these parameter. Elsehwere, put BOOLEAN false.
 *
 *		If an Image is dumped in File, the function get the Image
 *		using readfile() instead to call FFMPEG functions (see bellow).
 *
 *	Warning:
 *
 *		Depending of the number of Videos (or Playlist) uploaded, Image generation
 *		can take few moments and consum a lot of porcessor resources
 *		(but not much memory). Once created and Dumped to a File, the function call the
 *		image using readfile() instead of using FFMPEG functions (and is faster,
 *		really RERALLY faster). This slould be the default behaviour.
 *
 */
 
// bool getvideothumb(string path_to_video[, bool to_file = true[, bool to_stdout = true[, int frame]]])
function getvideothumb($video, $to_file = true, $to_stdout = true, $frame = null){

	// If ffmpeg_frame Chass does not exist, use
	// an alternative, generic image.
	if(!class_exists("ffmpeg_frame") || !class_exists("ffmpeg_movie")) return generic_img();

	if(!is_file($video)) return false;

	header('content-type:image/jpeg');

	// Reads the Dumped Thumbnail instead of calling FFMPEG functions
	$dump_filename = IMAGES_PATH.'thumbs/'.base64_encode(basename($video));

	if(is_readable($dump_filename)){
		if(readfile($dump_filename)) return true;
		else return false;
	}

	$movie = new ffmpeg_movie($video);
	if(!$movie) return false;

	if($frame == null) $frame = mt_rand(90,$movie->getFrameCount());
	elseif(is_integer($frame) && $frame <= $movie->getFrameCount()) $frame = $frame;
	else $frame = round($movie->getFrameCount() /2);

	// Gets a Frame from Movie
	$getframe = $movie->getFrame($frame);

	// Calculates a Factor by Divising Height by 100
	$heigh_fact = ($getframe->getHeight() / 75);

	//$width = round($getframe->getWidth() / $heigh_fact);
	$width = 100;	// 4:3 aspect form Height 100
	$height = round($getframe->getHeight() / $heigh_fact);

	// Gets a GD Image from the Frame
	$image = $getframe->toGDImage();
	$image_r = imagecreatetruecolor($width,$height);
	imagecopyresampled($image_r,$image,0,0,0,0,$width,$height,$getframe->getWidth(),$getframe->getHeight());
	imagedestroy($image);

	if($to_file){
		if(imagejpeg($image_r, $dump_filename,20)) $dumped = true;
		if($to_stdout && is_readable($dump_filename)) @readfile($dump_filename);
	}else{
		if(imagejpeg($image_r,null,20)) $dumped = true;
	}
	return $dumped;
}

/* Delete Thumbnails
 *
 * This function only Delete the files in 'images/thumbs'
 * directory, and returns true if all are correct.
 *
 * Parameters: No parameters are needed.
 *
 *	Returned values: Returns BOOLEAN true if no error ocurrs.
 *	Elsewwere, Return value is BOOLEAN false.
 *
 */

// bool clear_thumbs(void)
function clear_thumbs(){
	
	$dir = opendir(IMAGES_PATH.'thumbs');
	while(($filename = readdir()) !== false){
		if(nofakedir($filename)) $unlinked = @unlink(IMAGES_PATH.'thumbs/' . $filename);
		if(!$unlinked) $num++;
	}
	if($num == null) return true;
	else return false;
}

function generic_img(){
	header('content-type:image/png');
	return readfile(IMAGES_PATH . 'video_generic.png');
}

/* Output a Video with Streamingh support
 *
 * This function performas a Streaming Video, by seeking
 * position of a particular place form Media Player. This
 * function output the Vioeo form these place.
 *
 * This function was be obtained form some examples about
 * Streaming FLV, and I put them into a Function. Please find
 * on Internet for more information.
 *
 * Parameters:
 *
 *	Filename: The full path to the Video.
 *
 * Returned values:
 *
 *	Returns BOOLEAN true if all are correct.
 *	If an error ocurrs (as the Filename does not exists or
 *	can't be opened for Reading) Return value is BOOLEAN false.
 *
 * Note: Position are given form $_GET['pos'], that is Global
 *
 */

// bool streaming_download($filename);
function streaming_download($filename){

	if(!file_exists($filename) && strpos($filename,'_hq.flv')) $filename = str_replace('_hq','',$filename);

	$ext = strrchr($filename, ".");

	if (($filename != "") && (file_exists($filename)) && ($ext==".flv")) {

		// ----- NO CACHE -----
		session_cache_limiter('nocache');

		// General header for no caching
		$now = gmdate('D, d M Y H:i:s') . ' GMT';
		header('Expires: ' . $now); // rfc2616 - Section 14.21
		header('Last-Modified: ' . $now);
		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
		header('Pragma: no-cache'); // HTTP/1.0

		// ----- Seek position -----
		$seekat = 0;
		if (isset($_GET["pos"])) {
			$position = $_GET["pos"];
			if (is_numeric ($position)) {
				$seekat = intval($position);
			}
			if ($seekat < 0) $seekat = 0;
		}

		header("Content-Type: video/x-flv");
		
		//Be sure to post the correct Content Length.
		if ($seekat > 0) header('Content-Length: ' . (filesize($filename)-$seekat));
		else header('Content-Length: ' . filesize($filename));
		
		if ($seekat != 0) {
			print("FLV");
			print(pack('C', 1 ));
			print(pack('C', 1 ));
			print(pack('N', 9 ));
			print(pack('N', 9 ));
		}

		$fh = @fopen($filename, "rb");
		if(!$fh) return false;

		fseek($fh, $seekat);
		fpassthru($fh);
		fclose($fh);

		return true;

	}else{
		header('http/1.1 404: Not found');
		echo 'Not found';
		return false;
	}
}

?>
