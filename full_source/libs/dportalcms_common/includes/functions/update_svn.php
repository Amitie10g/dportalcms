<?php
/* Currently non implemented yet
// array diff_updated_files
function diff_updated_files(){

	// Open a known directory, and proceed to read its contents
	if (is_dir(UPDATES_PATH)) {
		if($updates_dir = opendir(UPDATES_PATH)){
			while (($file = readdir($updates_dir)) !== false) {
				if(nofakedir($file)){
					$file_old = filemtime(DPORTAL_ABSOLUTE_PATH."/$file");							
					$file_act = filemtime(UPDATES_PATH."/$file");							
					if($file_act > $file_old) $updated_files[] = $file;
				}
			}
		      closedir($updates_dir);
		}
	}

	if($updated_files != null) return $updated_files;
	else return false;
}
*/
?>
