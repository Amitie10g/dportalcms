<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Class to generate images (gallery.class.php)#
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

class image{

	private $file;
	private $image;
	private $dimensions;
	private $description;

	function __construct($file){
		$this->file = $file;
		$this->split_file = explode('.',$this->file);
		$this->filesize = filesize($file);
		$this->dimensions = getimagesize($file);
		$this->description = $this->split_file[1];
		$this->ext = $this->split_file[2];
		$this->mime = image_type_to_mime_type(exif_imagetype($this->file));

		switch($this->mime){
			case 'image/jpeg'  : $this->image = imagecreatefromjpeg($this->file); break;
			case 'image/pjpeg' : $this->image = imagecreatefromjpeg($this->file); break;
			case 'image/gif'   : $this->image = imagecreatefromgif($this->file); break;
			case 'image/png'   : $this->image = imagecreatefrompng($this->file); break;
		}
	}

	// void original_image(void)
	public function original_image(){

		header('Content-Description: File Transfer');
		header('content-type:'.$this->mime);
		header("content-disposition: attachment; filename=\"".basename($this->description.'.'.$this->ext)."\"\n\n"); 
		header('Content-Transfer-Encoding: binary');
		header('Pragma: public');

		switch($this->mime){
			case 'image/jpeg'	: imagejpeg($this->image); break;
			case 'image/gif'	: imagegif($this->image); break;
			case 'image/png'	: imagepng($this->image); break;
		}
			imagedestroy($this->image);
	}

	/* 
	 * Outputs a JPEG Image from the original image, against the type	
	 */
	 
	// void image_thumb([int maxwidth])
	public function thumb_image($maxwidth = 200){

		if(!is_integer($maxwidth)) $maxwidth = 200;

		header('Content-Description: File Transfer');
		header('content-type:image/jpeg');
		header('content-disposition: attachment; filename="'.$this->description.'_thumb.jpg"'); 
		header('Content-Transfer-Encoding: binary');
		header('Pragma: public');

		// Factor is a value calculated form the Width divised by 200 (maximum width).
		// These value will be used to divide the Width and Height
		// to always obtain an Image with 200 px width, against the original size.
		//
		// e.g. If Image size is 800x600, the Width 800 is divided by 200 800/200 = 4.
		// So, these value are the $factor. Then, 800 / 4= 200 (width), and 600 / 4 = 150. 
		$factor = ($this->dimensions[0] / $maxwidth);
		$dimensionx = $this->dimensions[0] / $factor;
		$dimensiony = $this->dimensions[1] / $factor;
		$this->thumb = imagecreatetruecolor($dimensionx,$dimensiony);
		imagecopyresampled($this->thumb,$this->image,0,0,0,0,$dimensionx,$dimensiony,$this->dimensions[0],$this->dimensions[1]);

		// Output a JPEG image, against the original Image type
		imagejpeg($this->thumb,null,30);
	}
}

?>
