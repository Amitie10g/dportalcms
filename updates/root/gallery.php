<?php
	
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Image gallery (panel.php)                   #
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
require_once('config/config.php');

// :: GET parameters

// Get the Gallery (see README files for details)
if(isset($_GET['gallery'])) $getgallery = $_GET['gallery'];
else $gallery = null;

// :: Image mode

// Get image mode (IMAGE variable and the Token)
if(isset($_GET['IMAGE'])&&isset($_GET['token'])){

	// Decode the Token
	$token = explode(';',base64_decode(strrev(base64_decode($_GET['token']))));

	$gallery = $token[0];
	$image = $token[1];
	
	/* Images sizes should be handled properly to different places.
	 * Place is passed by URI as GET parameter.
	 *
	 * If Image is for Preview (displayed in the Index of Galleries)
	 * dimensions shouldn't be greater than 150x700 pixels.
	 *
	 * If Image is for Thumbnail (displayed in gallery), dimensions
	 * shouldn't be greater than 200x100 pixels.
	 *
	 * If Image is smaller than these values, image is not resized.
	 *
	 * If Image is for normal view (without parameters), them is
	 * displayed as is; class will output image without filtering
	 * or resising. Tecnically, no limits are assigned, and Function
	 * in the Class will not resize the image.
	 *
	 * Special image size is for Administrator. These mode display
	 * smaller images, and no limit of Images per page will be established.
	 * This is for decrease the bandwidh when loading all images in one page.
	 *
	 */

	// Preview for Index galleries page
	if(isset($_GET['PREV'])){
		$maxwidth = 150;
		$maxheight = 70;
	}elseif($user_admin){
		$maxwidth = 150;
		$maxheight = 100;
	// Thumbnail for Gallery
	}else{
		$maxwidth = 200;
		$maxheight = 250;
	}
	
	// If the parameters passed don't correspond,
	// send peoper Headers and messages (404 and 403)
	if(!is_file(GALLERY_PATH . "$gallery/$image")){ header('HTTP/1.1 404 Not found'); die($LANG['image_does_not_exist']);}
	
	// Initialize the Class Image
	$image = new image(GALLERY_PATH . "$gallery/$image");
	
	// If the ORIG parameter are given, returns the Original image
	if(isset($_GET['ORIG'])) $image->original_image();
	else $image->thumb_image($maxwidth,$maxheight);
	
	die();

// :: Output modes

// Gallery
}elseif(file_exists(GALLERY_PATH . "$getgallery/.name")){

	$type = "gallery";

	$directory = GALLERY_PATH . "$getgallery";

	// Gets the Number of page. If not give, default is '1' 
	if(isset($_SESSION['gallery_page'][$getgallery]) && !isset($_GET['page'])) $getpage = $_SESSION['gallery_page'][$getgallery];
	elseif(isset($_GET['page'])) $getpage = $_GET['page'];
	else $getpage = 1;

	// Enable Smarty Cache
	$smarty->caching = true;

	$dirconf = getgalconf($directory);
	$title = str_replace("\"","",$dirconf[0]);

	if(!$smarty->is_cached('gallery_gallery.tpl',"gallery_gallery|$getgallery|$getpage") || $user_admin){

		$dircontents = getgallerycontents($getgallery,$getpage,$dirconf[1]);

		if($dircontents != null){

			$numpage = $dircontents['numpage'];
			$list = $dircontents['list'];
			$imp = $dircontents['imp'];
			$getpages = round(count($list) / $imp);
			
			if(preg_match("/[0-9]+/",$getpage)>0) $smarty->assign('PAGE',page($getpage,$imp));
			else $smarty->assign('PAGE',1);
	
			$smarty->assign('IMAGELIST',$list);
	
			if($getpage>0)$smarty->assign('BACKPAGE',$getpage-1);else $smarty->assign('BACKPAGE',1);
			if($getpage<=$numpages)$smarty->assign('NEXTPAGE',$getpage+1);
			$smarty->assign('CURRPAGE',$getpage);
			$smarty->assign('IMP',$imp);
		}
	}

	$ajax_url = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH.'/gallery.php?gallery='.$getgallery.'&amp;AJAX&amp;page='.$getpage;
	$ajax_block = 'gallery_content';

	$smarty->assign('CREATED',filemtime($directory . '/.name'));
	$smarty->assign('UPDATED',filemtime($directory));

	$smarty->assign('AJAX_URL',$ajax_url);
	$smarty->assign('AJAX_BLOCK',$ajax_block);
	
	$smarty->assign('GALLERY',$directory);

	$smarty->assign('TEMPLATE','gallery_c.tpl');

// Main page
}else{

	$type = "galleries";

	$smarty->caching = true;

	if(isset($getgallery)) redir('gallery_index','gallery_index');

	if(!$smarty->is_cached("gallery.tpl","gallery|index") || $user_admin) $galleries = getgalleries();

	$title = $LANG['galleries'];

	$getgallery = 'index';

	$smarty->assign('TEMPLATE','gallery_index.tpl');
	$smarty->assign('LIST',$galleries);
}

// :: Output

// AJAX mode
if(isset($_GET['AJAX'])){

	$_SESSION['gallery_page'] = array($_GET['gallery']=>$_GET['page']);

	if($getpage < 1 || $getpage == null) $getpage = 1;

	$start = (($getpage - 1) * $imp);
	$prev = ($getpage - 1);
	$next = ($getpage + 1);

	$smarty->assign('PAGE',$getpage);
	$smarty->assign('START',$start);
	$smarty->assign('PREV',$prev);
	$smarty->assign('NEXT',$next);
	$smarty->assign('IPP',$imp);

	$smarty->caching = 2;$smarty->cache_lifetime = 3600;
	$smarty->display('gallery_gallery.tpl',"gallery_gallery|$getgallery|$getpage");
	die();

// Feed mode (template is for now empty)
}elseif(isset($_GET['FEED'])){

	$smarty->assign('TITLE',$title);

	if($getpage<=$numpages&&$getpage>0) $smarty->caching = 2;$smarty->cache_lifetime = 3600;
	$smarty->display('gallery_feed.tpl',$getgallery);die();

// Gallery
}else{

	$smarty->assign('IS_GALLERY',true);
	
	$smarty->assign('GALLERY_NAME',$getgallery);

	$smarty->assign('TYPE',$type);

	$smarty->assign('TITLE',$title);

	$smarty->caching = false;
	$smarty->display('header.tpl');
	
	$smarty->display('header_title.tpl');
	
	$smarty->display('header_more.tpl');
	$smarty->display('header_close.tpl');
	$smarty->display('body_h.tpl');
	$smarty->display('container.tpl');
	$smarty->display('menu_h.tpl');

	$smarty->display('menu_f.tpl');
	$smarty->display('header_f.tpl');

	$smarty->display('sidebar_h.tpl');

	$smarty->display('sidebar_user_data.tpl');

	$smarty->display('sidebar_c.tpl');
	$smarty->display('sidebar_f.tpl');

	$smarty->display('gallery.tpl',"gallery|$getgallery");

	$smarty->display('footer_page.tpl');
	$smarty->display('footer.tpl');
}

require_once(INCLUDES_PATH.'footer.php');
?>
