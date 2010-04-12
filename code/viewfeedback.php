<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Feedback viewer (viewfeedback.php)          #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

define('DPORTAL',true);
require_once('includes/header.php');

if(!$user_admin){
	header("HTTP/1.0 403 Forbidden");
	header("HTTP/1.0 307 Temporary redirect");	
	redir('index','home');
	die();
}

	function getfeedback(){
		$file = fopen('content/.feedback','r') or die($LANG['inexistent_file']);
		while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
			$timestamp = $data[0];
			$type = $data[1];
			$comment = $data[2];
			$ipadd1 = $data[3];
			$ipadd2 = $data[4];
		
			if($type) $content1[$timestamp] = array
			('timestamp'=>$timestamp,'comment'=>$comment,'ipadd1'=>$ipadd1,'ipadd2'=>$ipadd2);
			else $content0[$timestamp] = array
			('timestamp'=>$timestamp,'comment'=>$comment,'ipadd1'=>$ipadd1,'ipadd2'=>$ipadd2);
		}
		if($content1!=null){ krsort($content1); foreach($content1 as $list) $output1[] = $list; }	
		if($content0!=null){ krsort($content0); foreach($content0 as $list) $output0[] = $list; }
			
		return array($output1,$output0);		
		fclose($file);
	}
	
$getfeedback = getfeedback();
	
$smarty->assign('BUGS', $getfeedback[0]);
$smarty->assign('COMMENTS', $getfeedback[1]);	
$smarty->display('viewfeedback.tpl');

require_once('includes/footer.php');

?>
