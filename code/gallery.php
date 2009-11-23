<?php
	
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Image gallery (panel.php)                   #
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

// :: GET parameters

// Get the Gallery (see README files for details)
if(isset($_GET['gallery'])) $getgallery = $_GET['gallery'];
else $gallery = null;

// :: Image mode

// Get image mode (IMAGE variable and the Token)
if(isset($_GET['IMAGE'])&&isset($_GET['token'])){

	// Decode the Token
	$token = explode(';',base64_decode($_GET['token']));

	$directory = $token[0];
	$filename = $token[1];

	// If the parameters passed don't correspond,
	// send peoper Headers and messages (404 and 403)
	if(!is_file("$directory/$filename")){ header('HTTP/1.1 404 Not found'); die($LANG['image_does_not_exist']);}
	

	// Initialize the Class Image
	$image = new image("$directory/$filename");
	
	// If the ORIG parameter are given, returns the Original image
	if(isset($_GET['ORIG'])) $image->original_image();
	else $image->thumb_image(200);
	
	die();

// :: Output modes

// Gallery
}elseif(file_exists("images/gallery/$getgallery/.name")){

	$directory = "images/gallery/$getgallery";

	$get_page = $_SESSION['gallery_page'];
	if($get_page[0] == $_GET['gallery']) $page = $get_page[1];
	else $page = 1;

	// Gets the Number of page. If not give, default is '1' 
	if(isset($_GET['page'])) $getpage = $_GET['page'];
	else $getpage = 1;

	// Enable Smarty Cache
	$smarty->caching = true;

	$dirconf = getgalconf($directory);
	$title = $dirconf[0];

	if(!$smarty->is_cached('gallery_gallery.tpl',$getpage)){

		$dircontents = getgallerycontents($directory,$page,$dirconf[1]);

		if($dircontents != null){

			$numpage = $dircontents['numpage'];
			$list = $dircontents['list'];
			$imp = $dircontents['imp'];
			$pages = round(count($list) / $imp);

			if(preg_match("/[0-9]+/",$getpage)>0) $smarty->assign('PAGE',page($getpage,$imp));
			else $smarty->assign('PAGE',1);
	
			$smarty->assign('IMAGELIST',$list);
	
			if($getpage>0)$smarty->assign('BACKPAGE',$getpage-1);else $smarty->assign('BACKPAGE',1);
			if($getpage<=$numpages)$smarty->assign('NEXTPAGE',$getpage+1);
			$smarty->assign('CURRPAGE',$getpage);
			$smarty->assign('IMP',$imp);
		}
	}

	$ajax_url = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH.'/gallery.php?gallery='.$getgallery.'&amp;AJAX&amp;page='.$page;
	$ajax_block = 'gallery_content';

	$smarty->assign('AJAX_URL',$ajax_url);
	$smarty->assign('AJAX_BLOCK',$ajax_block);

	$smarty->assign('TEMPLATE','gallery_c.tpl');
	$smarty->assign('IS_GALLERY',true);

// Main page
}else{

	if(!$smarty->is_cached('gallery_index.tpl')) $galleries = getgalleries();

	$title = "Galleries";

	$getgallery = 'index';

	$smarty->assign('TEMPLATE','gallery_index.tpl');
	$smarty->assign('LIST',$galleries);

}

// :: Output

// AJAX mode
if(isset($_GET['AJAX'])){

	$_SESSION['gallery_page'] = array($_GET['gallery'],$_GET['page']);

	$page = $_GET['page'];
	if($page < 1) $page = 1;

	$start = (($page - 1) * $imp);
	$prev = ($page - 1);
	$next = ($page + 1);

	$smarty->assign('PAGE',$page);
	$smarty->assign('START',$start);
	$smarty->assign('PREV',$prev);
	$smarty->assign('NEXT',$next);
	$smarty->assign('IPP',$imp);

	$smarty->caching = 2;$smarty->cache_lifetime = 3600;
	$smarty->display('gallery_gallery.tpl',$getgallery,$page);
	die();

// Feed mode (template is for now empty)
}elseif(isset($_GET['FEED'])){

	$smarty->assign('TITLE',$title);

	if($getpage<=$numpages&&$getpage>0) $smarty->caching = 2;$smarty->cache_lifetime = 3600;
	$smarty->display('gallery_feed.tpl',$getgallery);die();

// Main
}else{

	$smarty->assign('TITLE',$title);

	$smarty->caching = false;
	$smarty->display('header.tpl');
	$smarty->display('header_more.tpl');
	$smarty->display('sidebar_h.tpl');
	$smarty->display('sidebar_search.tpl');

	$smarty->display('sidebar_user_data.tpl');

	$smarty->display('sidebar_c.tpl');
	$smarty->display('sidebar_f.tpl');

	$smarty->caching = 2;$smarty->cache_lifetime = 2592000;
	$smarty->display('gallery.tpl',$getgallery);

	$smarty->display('footer.tpl');
}

require_once('includes/footer.php');

?>
