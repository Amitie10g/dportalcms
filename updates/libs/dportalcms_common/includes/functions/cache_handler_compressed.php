<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Smarty Cache handler Functions              #
		#  (smarty_cache_custom_functions.php)         #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################
		#                                              #
		#  This program uses some examples from the    #
		#  Smarty Documentation.                       #
		#                                              #
		################################################

// Disable Caching
function cache_handler_none(){
	return false;
}

// zlib compressed files cache
function cache_handler_gzip($action, &$smarty, &$cache_content, $tpl_file=null, $cache_id=null, $compile_id=null, $exp_time=null)
{

	// create unique cache id
	$CacheID = md5($tpl_file.$cache_id.$compile_id);
	
	switch ($action) {
		case 'read':

			// Perform the Read from File
			$_auto_id = $smarty->_get_auto_id($cache_id, $compile_id);
			$_cache_file = $smarty->_get_auto_filename($smarty->cache_dir, $tpl_file, $_auto_id);
			
			if(!is_readable($_cache_file)) return false;
			
			if(is_callable('gzopen')){
				$fd = gzopen($_cache_file, 'rb');
				$results = gzread($fd,131072);
				gzclose($fd);
			}else{
				$fd = fopen($_cache_file, 'rb');
				$results = fread($fd,131072);
				fclose($fd);
			}

			return $results;
 
			break;
	
		case 'write':

			if(!@is_writable($smarty->cache_dir)) {
				// cache_dir not writable, see if it exists
				if(!@is_dir($smarty->cache_dir)) {
					$smarty->trigger_error('the $cache_dir \'' . $smarty->cache_dir . '\' does not exist, or is not a directory.', E_USER_ERROR);
					return false;
				}
				$smarty->trigger_error('unable to write to $cache_dir \'' . realpath($smarty->cache_dir) . '\'. Be sure $cache_dir is writable by the web server user.', E_USER_ERROR);
				return false;
			}

			$_auto_id = $smarty->_get_auto_id($cache_id, $compile_id);
			$_cache_file = $smarty->_get_auto_filename($smarty->cache_dir, $tpl_file, $_auto_id);
			$_params = array('filename' => $_cache_file, 'contents' => $cache_content, 'create_dirs' => true,'compress' => 'gzip');

			// Call smarty_write_file_compress() 
			if(smarty_write_file_compress($_params, $smarty) === true) return true;
			else return false;

			break;
		
		case 'clear':
		
			if(!@is_writable($smarty->cache_dir)) {
				// cache_dir not writable, see if it exists
				if(!@is_dir($smarty->cache_dir)) {
					$smarty->trigger_error('the $cache_dir \'' . $smarty->cache_dir . '\' does not exist, or is not a directory.', E_USER_ERROR);
					return false;
				}
				$smarty->trigger_error('unable to write to $cache_dir \'' . realpath($smarty->cache_dir) . '\'. Be sure $cache_dir is writable by the web server user.', E_USER_ERROR);
				return false;
			}
	
			foreach (glob("$smarty->cache_dir/*") as $file) {
			    unlink($file);
			}
	
			return true;
	
			break;
	}
}

// bzip2 compressed files cache
function cache_handler_bzip2($action, &$smarty, &$cache_content, $tpl_file=null, $cache_id=null, $compile_id=null, $exp_time=null)
{ 
	// create unique cache id
	$CacheID = md5($tpl_file.$cache_id.$compile_id);
	
	switch ($action) {
		case 'read':

		// Perform the Read from File
		$_auto_id = $smarty->_get_auto_id($cache_id, $compile_id);
		$_cache_file = $smarty->_get_auto_filename($smarty->cache_dir, $tpl_file, $_auto_id);

		if(is_callable('bzopen')){
			$fd = bzopen($_cache_file, 'r');
			$results = bzread($fd,131072);
			bzclose($fd);
		}else{
			$fd = fopen($_cache_file, 'rb');
			$results = fread($fd,131072);
			fclose($fd);
		}

		return $results;
 
		break;
	
		case 'write':

		// Modified version of Smarty core.write_cache_file, that use zlib
		if(!@is_writable($smarty->cache_dir)) {
			// cache_dir not writable, see if it exists
			if(!@is_dir($smarty->cache_dir)) {
				$smarty->trigger_error('the $cache_dir \'' . $smarty->cache_dir . '\' does not exist, or is not a directory.', E_USER_ERROR);
				return false;
			}
			$smarty->trigger_error('unable to write to $cache_dir \'' . realpath($smarty->cache_dir) . '\'. Be sure $cache_dir is writable by the web server user.', E_USER_ERROR);
			return false;
		}

		$_auto_id = $smarty->_get_auto_id($cache_id, $compile_id);
		$_cache_file = $smarty->_get_auto_filename($smarty->cache_dir, $tpl_file, $_auto_id);
		$_params = array('filename' => $_cache_file, 'contents' => $cache_content, 'create_dirs' => true,'compress' => 'bzip2');

		// Call smarty_write_file_compress() 
		if(smarty_write_file_compress($_params, $smarty) === true) return true;
		else return false;

		break;
		
		case 'clear':
	
		foreach (glob("$smarty->cache_dir/*") as $file) {
		    unlink($file);
		}
	
		return true;
	
		break;
	}
	return $return;
}

// Write Output to Files
function smarty_write_file_compress($params, &$smarty)
{
	if ($params['create_dirs']) {
		$_params = array('dir' => $_dirname);
		require_once(SMARTY_CORE_DIR . 'core.create_dir_structure.php');
		smarty_core_create_dir_structure($_params, $smarty);
	}

	// write to tmp file, then rename it to avoid file locking race condition
	$_tmp_file = tempnam($smarty->cache_dir, 'wrt');

	// Compress the output with GZIP
	if($params['compress'] == 'gzip' && is_callable('gzopen')){
		if(($fd = gzopen($_tmp_file, 'wb9')) !== false){
			gzwrite($fd, $params['contents']);
			gzclose($fd);
		}else return false;
	}elseif($params['compress'] == 'bzip2' && is_callable('bzopen')){
		if($fd = bzopen($_tmp_file, 'w') !== false){
			bzwrite($fd, $params['contents']);
			bzclose($fd);
		}else return false;
	}elseif($params['compress'] == 'lzf' && is_callable('lzf_compress')){
		if(file_put_contents($_tmp_file,lzf_compress($params['contents'])) === false) return false;
	}elseif($params['compress'] == 'lzma' && is_callable('lzma_compress')){
		if(file_put_contents($_tmp_file,lzma_compress($params['contents'])) === false) return false;
	// Normal output if not given compression method
	}else{
		$fd = fopen($_tmp_file, 'wb9');
		fwrite($fd, $params['contents']);
		fclose($fd);
	}

	if (DIRECTORY_SEPARATOR == '\\' || !@rename($_tmp_file, $params['filename'])) {
		// On platforms and filesystems that cannot overwrite with rename() 
		// delete the file before renaming it -- because windows always suffers
		// this, it is short-circuited to avoid the initial rename() attempt
		@unlink($params['filename']);
		@rename($_tmp_file, $params['filename']);
	}
	@chmod($params['filename'], $smarty->_file_perms);

	return true;
}

?>