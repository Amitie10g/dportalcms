<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Feedback send (feedback.php)                #
		#                                              #
		#  Copyright Davod.                            #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

define('DPORTAL',true);
require_once('includes/header.php');

// String getip(void)
function getip(){
	$ip1	= $_SERVER['REMOTE_ADDR'];
	$ip2	= $_SERVER["HTTP_X_FORWARDED_FOR"];
	if($ip2==null) $ip = $ip1;
	else $ip = $ip = "$ip1,$ip2";
	return $ip;
}

// Bool submit(string content)
function submit($content,$type){

	$ip = getip();
	$file = fopen("content/.feedback",'a');
	flock($file,2);
	$output = time().",$type,\"$content\",$ip\n";
	if(fwrite($file,$output)) return true;
	fclose($file);
}

if(isset($_GET['SUBMIT'])){
	$getcontent = $_POST['content'];
	$type = $_POST['type'];
	if(preg_match("/[\w\s]*/","",$content)>0) submit($getcontent,$type);
	$_SESSION['time'] = time();

	header('location:feedback.php?SENDED'); die();
}

if(isset($_SESSION['time'])){
	$countdown = ($_SESSION['time'] - (time()-900));
	$smarty->assign('COUNTDOWN',$countdown);
	$smarty->assign('SCOUNTDOWN',strftime("%M",$countdown));
	
	if($countdown <= 0) session_unregister('time');
}

$smarty->display('feedback.tpl');

include_once('includes/footer.php');

?>
