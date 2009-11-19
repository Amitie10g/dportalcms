<?php

function getlist_sitemap(){
	$secs = @fopen("content/.list", "r") or die('<b>'.$LANG['fatal_error'].':</b> '.$LANG['missing_lists_file']);
	while (($data = fgetcsv($secs, 1000, ";")) !== FALSE) {	
		$name = $data[1];
		$timestamp = $data[4];
		$sections[] = array('name'=>$name,'timestamp'=>$timestamp);
	}
	fclose($secs);

	return $sections;
}

function getgal_sitemap(){
	$gal_dir = 'images/gallery';
	if (is_dir($gal_dir)) {
		$gal = opendir($gal_dir);
		  if ($$al) {
		      while (($conf_gal = readdir($gal)) !== false) {
		          if ($conf_gal != '.' && $conf_gal!= '..' && $conf_gal != '.htaccess'){
		              $get_gals[] = $conf_gal;
		          }
		      }
		      closedir($gal);
		  }
	}
	return $get_gals;
}

?>
