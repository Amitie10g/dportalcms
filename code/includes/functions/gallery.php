<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Fuctions for Gallery (panel.php)            #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// array getdircontents(string directory, int page, int images_per_page)
function getgallerycontents($directory,$page,$images_per_page) {

	if(is_dir($directory) && file_exists("$directory/.name")){

		$dir_resource = opendir($directory);
		while ($filename = readdir($dir_resource)){

			if(nofakedir($filename)){
				$uri = base64_encode("$directory;$filename");
				$name = explode('.',$filename);
				$mime = image_type_to_mime_type(exif_imagetype("$directory/$filename"));
				$list[] = array('filename'=>$filename,'desc'=>$name[0],'ext'=>$name[1],'uri'=>$uri,'mimetype'=>$mime,'updated'=>filemtime("$directory/$filename"));
			}
		}
		
		if($list != null){
			sort($list);							 
			return array('list'=>$list,'page'=>$page,'imp'=>$images_per_page);
		}else return null;
	}
}

function getgalconf($directory){
	if(file_exists("$directory/.name")) return explode('|',file_get_contents("$directory/.name"));
	else return false;
}

// array getdircontents (void)
function getgalleries() {

	if(!is_dir(GALLERY_PATH)) return false;
	$dir_resource = opendir(GALLERY_PATH);
	while ($dirname = readdir($dir_resource)){
		if(nofakedir($dirname)){

			$gallery_dir = opendir(GALLERY_PATH.$dirname);

			while($onefilename = readdir($gallery_dir)){
				if(nofakedir($onefilename)){
					$image = explode('.',$onefilename);
					$dirpath = GALLERY_PATH."$dirname/";
					$dirrelpath = str_replace(DPORTAL_PATH.'/','',str_replace(DOCUMENT_ROOT,'',$dirpath));
					$uri = base64_encode("$dirrelpath;$onefilename");
					$image_title = $image[0];
					$ext = $image[1];
					break;
				}

			}
			closedir($gallery_dir);

			$dirsize = dircontents_size($dirpath,1);

			$conf = explode('|',file_get_contents(GALLERY_PATH."$dirname/.name"));
			$galleries[] = array('gallery_title'=>str_replace("\"","",$conf[0]),'uri'=>$uri,'image_title'=>$image_title,
			'ext'=>$ext,'dirname'=>$dirname,'dirsize'=>$dirsize['dirsize'],'num'=>$dirsize['numfiles']);
		}
	}

	closedir($dir_resource);

	return $galleries;
}

// int page(int page, int images_per_page);
function page($page,$imp){
	if($page>0)	return ($page-1) * $imp;	
}

//bool create_gallery(string name, string title, int max)
function create_gallery($name,$title,$max){
	
	$check_name = preg_match("/^[\w]{3,15}$/",$name);
	$check_title = preg_match("/^[\w\W]{3,25}$/",$title);
	$check_max = preg_match("/^[0-9]{1,2}$/",$max);

	$title = preg_replace("/[|<>]*/",'',htmlentities($title,null,'UTF-8'));

	if($check_name && $check_max && $max >= 10 && $max <= 50){

		if(!mkdir(GALLERY_PATH.$name,0755)) die('<strong>Fatal error:</strong> Can not create a Directory in galleries directory. Please check the permissions.');
	
		$file = fopen(GALLERY_PATH."$name/.name",'x') or die('<strong>Fatal error:</strong> The Gallery config file exists or is inaccesible.');
		$output = "\"$title\"|$max"; // Delimiter is '|' instead ';' or ','!

		if(fwrite($file,$output)) $created = true;
		fclose($file);

		if($created === true) return $created;
		else return false;

	}else return false;
}

/* ABOUT THIS FUNCTION
 * 
 * This function is an alternative image_type_to_extension(string MIME type [, bool include_dot])
 * that is available only in PHP5. This function does the same; only difference is than only is
 * required the MIME type instead of Image type, that should be obtained previously by
 * image_type_to_mime_type()
 *
 * If MIME is not an well-known image, return boolean FALSE
 *
 */
// string get_image_extension(string)
function get_image_extension($mimetype, $include_dot = false){

	if($include_dot === true) $dot = '.';

	switch($mimetype){
		case 'image/jpeg' : $ext = 'jpg'; break;
		case 'image/pjpg' : $ext = 'jpg'; break;
		case 'image/gif' : $ext = 'gif'; break;
		case 'image/png' : $ext = 'png'; break;
		// Add more MIME types
	}
	
	if($ext != null) return $dot . $ext;
	else return false;
}

?>
