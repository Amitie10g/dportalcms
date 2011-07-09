<?php
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Memcached support module (memcached.php)    #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

function cache_handler_memcached($action, &$smarty, &$cache_content, $tpl_file=null, $cache_id=null, $compile_id=null, $exp_time=null){

	global $memcached;
	global $site_id;

	$CacheID = 'dcms_' . $site_id . '_' . sha1($tpl_file.$cache_id.$compile_id);

	switch($action){
		case 'read' :
			$content = $memcached->get($CacheID);
			
			if(!empty($content)) return $content;
			else return false;
			break;
		
		case 'write' :
			if($memcached->set($CacheID,$cache_content)) return true;
			else return false;		
			break;
		
		case 'clear' :
			if(!empty($CacheID)){
				if($memcached->delete($CacheID,0)) return true;
				else return false;		
				// Two alternatives to clear all Cache, a WHILE block to delete all Cache,
				// Or Memcached::flush to simply invalidate all the data.
			}else{
				if($memcached->flush(0)) return true;
				else return false;		
			}

			break;
		
		default: 
		
			// error, unknown action
			$smarty_obj->_trigger_error_msg("cache_handler: unknown action \"$action\"");
			$return = false;
			break;
	}
}

?>