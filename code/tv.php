<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Media Player and Showcase (tv.php)          #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU general Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// Include the Headers
define('DPORTAL',true);
require_once('includes/header.php');

$smarty->caching = true;

// Video mode
if(isset($_GET['file'])){

	if(($loged_in && $phpbb_dir != null)||$phpbb_dir == null){
		$video = VIDEOS_PATH.base64_decode(str_replace('.flv','',basename($_GET['file'])));
		getvideo($video, true); die();
	}else{
		header('http/1.1 403 Forbidden'); die('Access denied. Please login');
	}

// Thumbnail mode
}elseif(isset($_GET['video']) && isset($_GET['THUMB'])){

	$video = VIDEOS_PATH.base64_decode(str_replace('.flv','',basename($_GET['video'])));
	getvideothumb($video,0, true, true); die();

// Player mode
}elseif(isset($_GET['video'])&&!isset($_GET['file'])){

	$video = base64_decode($_GET['video']);
	if(!isset($_GET['HQ'])) $video = str_replace('_hq','',$video);

	$split_name = explode('.',str_replace('_hq','',base64_decode($_GET['video'])));
	$title = basename($split_name[0]);

	if(isset($_GET['HQ'])) $smarty->assign('HQ',true);
	$smarty->assign('IS_VIDEO',true);
	$smarty->assign('TITLE',$title);
	$smarty->assign('URI',base64_encode($video));
	$smarty->assign('URI_HQ',base64_encode(str_replace('.flv','_hq.flv',$video)));
	$smarty->assign('PLAYLIST',$_GET['playlist']);

	$section = $_GET['video'];
	if(isset($_GET['HQ'])) $section = $_GET['video'] . '_hq';

	$include_file = 'player.tpl';

// Playlist mode
}elseif(isset($_GET['playlist'])){

	$section = $_GET['playlist'];
	$page = $_GET['page'];
	if($_GET['page'] < 1) $page = 1;

	if(file_exists(VIDEOS_PATH.$_GET['playlist'].'/.name')){

		if(!$smarty->is_cached('playlist.tpl',$section,$page)){

			$get_video_list = getplaylist(VIDEOS_PATH.$_GET['playlist']);

			$videos_per_page = 10;
			$start = (($page - 1) * $videos_per_page);
			$prev = ($page - 1);
			$next = ($page + 1);

			$title = file_get_contents(VIDEOS_PATH.$_GET['playlist'].'/.name');

			$smarty->assign('TITLE',$title);
			$smarty->assign('PAGE',$page);
			$smarty->assign('START',$start);
			$smarty->assign('PREV',$prev);
			$smarty->assign('NEXT',$next);
			$smarty->assign('VPP',$videos_per_page);
			$smarty->assign('PLAYLIST',$get_video_list);
		}
		
		$include_file = 'playlist.tpl';
		
	}else{
		$section = 'not_found';

		header('http/1.1: 404 not found');
		$include_file = 'video_not_found.tpl';
	}

// Showcase (index) mode
}else{

	$section = 'showcase';
	$page = $_GET['page'];
	if($_GET['page'] < 1) $page = 1;

	if(!$smarty->is_cached('showcase.tpl',$section,$page)){

		$get_showcase = getshowcase();

		$playlists_per_page = 10;
		$start = (($page - 1) * $playlists_per_page);
		$prev = ($page - 1);
		$next = ($page + 1);
	}

	$smarty->assign('TITLE','Videos');
	$smarty->assign('PAGE',$page);
	$smarty->assign('START',$start);
	$smarty->assign('PREV',$prev);
	$smarty->assign('NEXT',$next);
	$smarty->assign('PPP',$playlists_per_page);

	$smarty->assign('SHOWCASE',$get_showcase);
	$include_file = 'showcase.tpl';
}

// :: Output;

$smarty->caching = false;
$smarty->display('header.tpl');

$smarty->caching = 2;$smarty->cache_lifetime = 262800;
$smarty->display('header_title.tpl',$section);
$smarty->caching = false;

$smarty->display('header_more.tpl');

$smarty->display('menu_h.tpl');
$smarty->display('menu_f.tpl');

$smarty->display('header_f.tpl');

if(!isset($_GET['HQ'])){
	$smarty->display('sidebar_h.tpl');
	$smarty->display('sidebar_user_data.tpl');
	$smarty->display('sidebar_c.tpl');
	$smarty->display('sidebar_f.tpl');
}
if(($loged_in && $phpbb_dir != null)||$phpbb_dir == null){
	$smarty->caching = 2;$smarty->cache_lifetime = 262800;
	$smarty->display($include_file,$section,$page);
}else{
	$smarty->caching = false;
	$smarty->display('login.tpl');
}

$smarty->display('footer.tpl');

require_once('includes/footer.php');

?>
