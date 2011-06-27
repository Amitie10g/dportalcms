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
function getgallerycontents($gallery,$page,$images_per_page) {

	if(is_dir(GALLERY_PATH . $gallery) && file_exists(GALLERY_PATH . "$gallery/.name")){

		$dir_resource = opendir(GALLERY_PATH . $gallery);
		while ($filename = readdir($dir_resource)){

			if(nofakedir($filename)){
				$uri = base64_encode(strrev(base64_encode("$gallery;$filename")));
				$name = explode('.',$filename);
				$mime = get_mime_fallback(GALLERY_PATH . "$gallery/$filename");
				$list[] = array('filename'=>$filename,'desc'=>$name[0],'ext'=>$name[1],'uri'=>$uri,'mimetype'=>$mime,'updated'=>filemtime(GALLERY_PATH . "$gallery/$filename"));
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

	global $user_admin;

	if(!is_dir(GALLERY_PATH)) return false;
	
	$galleries_res = opendir(GALLERY_PATH);
	while ($gallery = readdir($galleries_res)){
		if(nofakedir($gallery)){

			$dirsize = dircontents_size(GALLERY_PATH . $gallery,1);
			
			if($dirsize == null && !$user_admin) continue;
			
			if($dirsize != null){
			
				$gallery_res = opendir(GALLERY_PATH . $gallery);

				while($file = readdir($gallery_res)){
					if(nofakedir($file)){
						$image = explode('.',$file);
						$uri = base64_encode(strrev(base64_encode("$gallery;$file")));
						$image_title = $image[0];
						$ext = $image[1];
						break;
					}
				}
				closedir($gallery_res);
			}

			$conf = explode('|',file_get_contents(GALLERY_PATH."$gallery/.name"));
			$galleries[] = array('gallery_title'=>str_replace("\"","",$conf[0]),'uri'=>$uri,'image_title'=>$image_title,
			'ext'=>$ext,'dirname'=>$gallery,'dirsize'=>$dirsize['dirsize'],'num'=>$dirsize['numfiles']);
		}
	}

	closedir($galleries_res);

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
	
		$file = fopen(GALLERY_PATH."$name/.name",'xb') or die('<strong>Fatal error:</strong> The Gallery config file exists or is inaccesible.');
		$output = "\"$title\"|$max"; // Delimiter is '|' instead ';' or ','!

		if(fwrite($file,$output)) $created = true;
		fclose($file);

		if($created === true) return $created;
		else return false;

	}else return false;
}

// bool delete_gallery(string gallery)
function delete_gallery($gallery){

	if(!is_dir(GALLERY_PATH . $gallery)) return false;
	
	if($dir = opendir(GALLERY_PATH . $gallery)){
		while($file = readdir($dir)){
			if($file != '.' && $file != '..') unlink(GALLERY_PATH . $gallery . '/' . $file);
		}
		closedir($dir);
	}
	
	if(rmdir(GALLERY_PATH . $gallery)) return true;
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
function get_image_extension($mimetype = null, $include_dot = false){

	if($mimetype == null) return false;

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

// bool delete_image(string gallery, array &images)
function delete_image($gallery,$images){

	if(!file_exists(GALLERY_PATH . "$gallery/.name")) return false;

	foreach($images as $image){
		if(!unlink(GALLERY_PATH . "$gallery/$image")) return false;
	}
	return true;
}

function get_mime_fallback($filename){

	if(is_callable("exif_imagetype") and is_callable("image_type_to_mime_type")){
		$mime = image_type_to_mime_type(exif_imagetype(GALLERY_PATH . "$gallery/$filename"));
	}else{
		$file_ext = end(explode(".", $filename));
	
		switch($file_ext){
		case 'jpg' : $mime = 'image/jpeg'; break;
		case 'jpg' : $mime = 'image/pjpg'; break;
		case 'gif' : $mime = 'image/gif'; break;
		case 'png' : $mime = 'image/png'; break;
		}	
	}
	
	return $mime;
	
}

?>
