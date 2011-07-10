<?php
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  DBlog, Blog (blog.php/index.php)            #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU General Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// Include the Headers
define('DPORTAL',true);
require_once('config/config.php');

// Gets the Entry name
$entry_name = $_GET['entry'];

$page = $_GET['page'];

if(empty($page) && empty($entry_name) && !isset($_GET['FEED']) && !isset($_GET['NEW']) && !isset($_GET['POST']) && !isset($_GET['POST_COMMENT']) && !isset($_GET['DELETE'])){
	if(substr($_SERVER['REQUEST_URI'],-1) != '/' && $use_rewrite){
		header('HTTP/1.1 301 Moved Permanently');
		header('location: ' . $_SERVER['REQUEST_URI'] . '/');
	}
}

if(!is_numeric($page) && $page < 1) $page = 1;

$year = $_GET['year'];
$month = $_GET['month'];

$smarty->assign('IS_BLOG', true);

// Get the entries for the Sidebar, and order by Year and date
$smarty->caching = true;
if(!$smarty->is_cached('sidebar_blog.tpl')){
	
	if(($entries = get_blog_entries()) != null){
	
		foreach($entries as $item){
			$year = date('Y',$item['created']);
			$month = date('m',$item['created']);
			$entries_sidebar[$year][$month][] = $item;
		}
		
		$smarty->assign('ENTRIES_SIDEBAR',$entries_sidebar);
	}
}
$smarty->caching = false;

// Create new entry
if(isset($_GET['NEW'])){

	if($user_admin){

		$smarty->assign('TITLE',$_SESSION['title']);
		$smarty->assign('CONTENT',$_SESSION['content']);
		
		$new_entry = true;
		$smarty->assign('NEW',$new_entry);
		$smarty->display('blog_edit.tpl');
	}else{
		header('HTTP/1.1 404 Not found');
		$smarty->assign('TITLE',$LANG['not_found']);
		
		$smarty->display('header.tpl');
	
		$smarty->display('header_title.tpl');
	
		$smarty->display('header_more.tpl');
		$smarty->display('header_close.tpl');
		$smarty->display('body_h.tpl');
		$smarty->display('container.tpl');

		$smarty->display('sidebar_h.tpl');

		$smarty->display('sidebar_user_data.tpl');
		
		$smarty->is_cached = 2; $smarty->cache_lifetime = 1296000;
		$smarty->display('sidebar_blog.tpl');
		$smarty->caching = false;

		$smarty->display('sidebar_c.tpl');
		$smarty->display('sidebar_f.tpl');
		$smarty->display('blog_entry_not_found.tpl');
		$smarty->display('footer_page.tpl');
		$smarty->display('footer.tpl');
	}

// Edit mode
}elseif(isset($_GET['EDIT']) && $user_admin){

	$get_entry = get_blog_entry($entry_name);

	if(!$get_entry){
		$_SESSION['blog_entry_doesnt_exist'] = true;
		redir('blog','blog');die();
	}

	$title = $get_entry['title'];
	$id = $get_entry['id'];	
	$name = $get_entry['name'];	
	$file = $get_entry['file'];
	$tags = $get_entry['tags'];

	$smarty->assign('ID',$id);
	$smarty->assign('NAME',$name);
	$smarty->assign('FILE',$file);
	$smarty->assign('SITENAME',$sitename);
	$smarty->assign('TAGS',$tags);
	$smarty->assign('TITLE',$title);

	$smarty->assign('BLOG_ENTRY', true);

 	$smarty->display('blog_edit.tpl');

// Delete mode
}elseif(isset($_GET['DELETE']) && $user_admin){

	$entry = $_GET['entry'];

	$id = get_post_id($entry);

	if(delete_entry($id)) $_SESSION['blog_entry_deleted'] = true;

	$smarty->clear_cache(null,'blog_index');

	redir('blog','blog'); die();
	
// Moderate comments mode
}elseif(isset($_GET['DELETE_COMMENTS']) && $user_admin){

	$id = $_POST['entry'];
	$comments = $_POST['comments'];
	$action = $_POST['action'];
	
	$name = get_post_name($id);
	
	if(!empty($id) && !empty($comments)) $moderated = moderate_comments($id,$comments,$action);
	
	$smarty->clear_cache(null,"blog_comments|$id");
	
	//clearstatcache(true,COMMENTS_PATH . $id);
	
	if($moderated == 1) $_SESSION['COMMENTS_DELETED'] = true;
	elseif($moderated == 2) $_SESSION['COMMENTS_MODERATED'] = true;
	else $_SESSION['COMMENTS_NOT_MODERATED'] = true;

	redir('blog_entry',$name,null,null,'comments'); die();

// Publish/update mode
}elseif(isset($_GET['POST'])  && $user_admin){

	$title = $_POST['title'];
	$id = $_POST['id'];
	$name = $_POST['name'];
	$content = stripslashes($_POST['content']); // Slashes striped
	$timestamp = time();
	$tags = $_POST['tags'];
	$new = $_POST['new'];

	// Limit the max lenght to aviod a title loo large.
	if(empty($title) || strlen($title) > 50){
		$_SESSION['content'] = $content;
		$_SESSION['title_empty'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
		die();
	}

	// If content is empty or greater than 100 KiB (uncomment if you want to apply this limit)
	if(empty($content)/* || mbstrlen($content) > 102400*/){
		$_SESSION['title'] = $title;
		$_SESSION['content_empty'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
		die();
	}

	// Parse a Name from the Title
	if($new) $name = title2name($title);

	// Save/update the entry
	if($new) $posting = blog_new_entry($timestamp,$name,$title,$content,$tags);
	else $posting = blog_update_entry($id,$name,$title,$content,$tags);

	// Check if be done successfully
	if($posting) $_SESSION['blog_entry_saved'] = true;
	else $_SESSION['blog_entry_error'] = true;
	
	$smarty->clear_cache(null,'blog_index');
	$smarty->clear_cache('blog_entry_content.tpl',$id);

	// Redir to the Entry
	redir('blog_entry',$name); die();

// Publish comment mode
}elseif(isset($_GET['POST_COMMENT'])){

	// Get the data form GET
	$name = $_POST['name'];
	$comment = stripslashes($_POST['comment']);
	
	if(($loged_in && defined(PHPBB_SESSION_ID)) || $user_admin){
		$user = PHPBB_USER_ID;
		$email = PHPBB_USER_EMAIL;
	}else{
		$user = $_POST['nick'];
		$email = $_POST['email'];
		$website = $_POST['url'];
	}
	
	$id = get_post_id($name);
		
	if(preg_match(PREG_EMAIL_STRING,$email) == 0) $email = null;
	
	// If comments is not sended
	if(empty($user) && !$loged_in){
		$_SESSION['nick_empty'] = true;
		if(!empty($email)) $_SESSION['EMAIL'] = $email;
		if(!empty($website)) $_SESSION['WEBSITE'] = $website;
		if(!empty($comment)) $_SESSION['COMMENT'] = $comment;
		
		redir('blog_entry',$name,null,null,'comment');
		die();
		
	}elseif(empty($email) && !$loged_in){
		$_SESSION['email_empty'] = true;
		if(!empty($user)) $_SESSION['NICK'] = $user;
		if(!empty($website)) $_SESSION['WEBSITE'] = $website;
		if(!empty($comment)) $_SESSION['COMMENT'] = $comment;
		
		redir('blog_entry',$name,null,null,'comment');
		die();
		
	}elseif(empty($comment) || mb_strlen($comment,'utf-8') > 5000){
		$_SESSION['comment_empty'] = true;
		if(!empty($user)) $_SESSION['NICK'] = $user;
		if(!empty($email)) $_SESSION['EMAIL'] = $email;
		if(!empty($website)) $_SESSION['WEBSITE'] = $website;
		
		redir('blog_entry',$name,null,null,'comment');
		die();
	}
	
	if(preg_match(PREG_URL_STRING,$website) > 0){
		if(strpos($website,"http://") !== false) $website = $website;
		else $website = 'http://' . $website;
	}else $website = null;

	$posting = blog_post_comment($id,$user,$comment,$email,$website);

	//clearstatcache(true,COMMENTS_PATH . $id);

	if($posting){
		if(!$loged_in){
			$_SESSION['COMMENT_PREVIEW_CONTENT'] = $comment;
			$_SESSION['COMMENT_PREVIEW_NICK'] = $user;
			$_SESSION['COMMENT_PREVIEW_URL'] = $website;
		}
		$_SESSION['COMMENT_PUBLISHED'] = true;
		
		if(empty($_SESSION['NICK']) || $_SESSION['NICK'] != $user) $_SESSION['NICK'] = $user;
		if(empty($_SESSION['EMAIL']) || $_SESSION['EMAIL'] != $email) $_SESSION['EMAIL'] = $email;
		if(empty($_SESSION['WEBSITE']) || $_SESSION['WEBSITE'] != $website) $_SESSION['WEBSITE'] = $website;
		
		if(empty($_COOKIE['NICK']) || $_COOKIE['NICK'] != $user) setcookie('NICK',$user,time()+36002592000);
		if(empty($_COOKIE['EMAIL']) || $_COOKIE['EMAIL'] != $email) setcookie('EMAIL',$email,time()+36002592000);
		if(empty($_COOKIE['WEBSITE']) || $_COOKIE['WEBSITE'] != $website) setcookie('WEBSITE',$website,time()+36002592000);
		
		unset_global_var('comment');
	
		$_SESSION['COMMENT_PUBLISHED'] = true;
		redir('blog_entry',$name,null,null,'comments');
	}else{
		$_SESSION['COMMENT_NOT_PUBLISHED'] = true;
		redir('blog_entry',$name,null,null,'comment');
	}
	
	die();
	
// Entry mode
}elseif(!empty($entry_name) && !isset($_GET['EDIT'])){

	$ajax_url = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH.'/index.php?COMMENTS&amp;entry='.$entry_name;
	$ajax_block = 'getcomments';
	
	$smarty->assign('AJAX_URL',$ajax_url);
	$smarty->assign('AJAX_BLOCK',$ajax_block);

	if($_GET['page'] == 1 && !isset($_GET['COMMENTS'])) redir('blog_entry',$entry_name);

	$smarty->assign("IS_BLOG", true);

	$get_entry = get_blog_entry($entry_name);

	if($get_entry != false){

		$title = $get_entry['title'];
		$id = $get_entry['id'];
		$name = $get_entry['name'];
		$file = $get_entry['file'];
		$user = $get_entry['user'];
		$tags = $get_entry['tags'];
		$created = $get_entry['created'];
		$updated = $get_entry['updated'];
		
		$smarty->assign('ID',$id);
		$smarty->assign('NAME',$name);	
		$smarty->assign('FILE',$file);
		$smarty->assign('TAGS',$tags);
		$smarty->assign('TITLE',"$title");
		$smarty->assign('USER',$user);
		$smarty->assign('CREATED',$created);
		$smarty->assign('UPDATED',$updated);
		
		if($use_phpbb){
			if(is_numeric($user)) $user += $user; //Conver Numerical to Integer
			if(is_integer($user) && $user == 2 && $user > 52) $username = get_user_by_id($user);
			if($username !== false) $user = $username;
		}else $user = PHPBB_USERNAME; // Ignore the user from Database
		
		// PDF version (NEW!). Available but not used. You can add a link to PDF version using my function
		if(isset($_GET['PDF'])){
		
			$file = gzopen(ENTRIES_PATH . $id,'rb');
			
			$referer = 'http://'.$_SERVER['SERVER_NAME'].str_replace(array('&PDF','.pdf'),array('','.html'),$_SERVER['REQUEST_URI']);

			$pdf->setAuthor($user);
			$pdf->setTitle($title);
			$pdf->setCompression(true);
			
			$pdf->SetMargins(15,15,10);
	
			$pdf->SetHeaderContent(utf8_decode($title),true);
			$pdf->SetFooterContent(utf8_decode($lang['from'] . '<a href="' . $referer . '">' . $sitename . '</a>. '), utf8_decode("© $admin_user. All rights reserved"),true);

			// Configure the Page and Font for Title
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','U',16);
			$pdf->WriteHTML($title);
			$pdf->SetFont('Arial','',10);
			//Uncompresed text up to 1 MiB (neither page should be greater than 500 KiB, generally).
			$pdf->WriteHTML(gzread($file,1048576));
			$pdf->Output("$title.pdf",'D');
			die();
			
		}elseif(isset($_GET['FEED'])){
			header('content-type:application/atom+xml');
			$smarty->display('feed_atom_entry.tpl');
			die();
		}
		
		if (@filesize(COMMENTS_PATH.$id) !== 0) $comments = get_comments_post($id);
		else $comments = false;
		
		$total = count($comments);
		$comments_per_page = 5;
		if(isset($_GET['COMMENTS'])) $comments_per_page = 20;
		$pages = ceil($total / $comments_per_page);
		if($page > $pages || $page < 1) $page = 1;
		$start = (($page - 1) * $comments_per_page);
		$prev = ($page - 1);
		$next = ($page + 1);

		// Well, here I call a function to read the Comments file twice. This is more secure than Session
		if(!$user_admin) $timestamp_published += get_blog_comment_timestamp_by_ip($id,$_SERVER['REMOTE_ADDR']);

		$time_left = get_left($timestamp_published, $time_left_greace_period);
		

		if(($time_left === true && !$user_admin) || $user_admin) $smarty->assign('ALLOW_PUBLISH',true);
		// Time left, in Minutes. Add one minute to the Minutes left, because starts form 14 to 00 minutes
		else $smarty->assign('TIME_LEFT',strftime("%M",($time_left + 59)));

		if($start > $total){
			header('HTTP/1.1 307 Redirection');
			redir('blog_entry',$name); die();
		}
	
		$smarty->assign('PAGE',$page);
		$smarty->assign('START',$start);
		$smarty->assign('PREV',$prev);
		$smarty->assign('NEXT',$next);
		$smarty->assign('CPP',$comments_per_page);

		$smarty->assign('COMMENTS',$comments);
		
		$smarty->assign('IS_ENTRY',true);
		
		// Display Comments for AJAX page
		if(isset($_GET['COMMENTS'])){
			$smarty->assign('AJAX',true);
			$smarty->display('blog_entry_comments_c.tpl');
			die();
		}
	
	}else{
		header('HTTP/1.1 404 Not found');
		$smarty->assign('TITLE',"Not found");
	}

	// :: Output
	$smarty->display('header.tpl');
	
	$smarty->display('header_title.tpl');
	
	$smarty->display('header_more.tpl');
	$smarty->display('header_close.tpl');
	$smarty->display('body_h.tpl');
	if(!isset($_GET['PRINT'])){
		$smarty->display('container.tpl');

		$smarty->display('sidebar_h.tpl');

		$smarty->display('sidebar_user_data.tpl');
		$smarty->display('sidebar_blog_comments.tpl');
		
		$smarty->is_cached = 2; $smarty->cache_lifetime = 1296000;
		$smarty->display('sidebar_blog.tpl');
		$smarty->caching = false;

		$smarty->display('sidebar_c.tpl');
		$smarty->display('sidebar_f.tpl');
	}
	
	if(!empty($get_entry)){
		if(isset($_GET['PRINT'])) $smarty->display('blog_entry_simple-header.tpl');
		else $smarty->display('blog_entry_header.tpl');
		$smarty->caching = 2; $smarty->cache_lifetime = 1296000;
		$smarty->display('blog_entry_content.tpl',$id);
		$smarty->caching = false;
		if(!isset($_GET['PRINT'])){
			$smarty->display('blog_entry_comments_h.tpl');
			$smarty->caching = 2; $smarty->cache_lifetime = 1296000;
			$smarty->display('blog_entry_comments_c.tpl');
			$smarty->caching = false;
			$smarty->display('blog_entry_comments_f.tpl');
			$smarty->display('blog_entry_form.tpl');
		}
		if(isset($_GET['PRINT'])) $smarty->display('blog_entry_simple-footer.tpl');
		else $smarty->display('blog_entry_footer.tpl');
		
	}else{
		$smarty->display('blog_entry_not_found.tpl');
	}
	if(!isset($_GET['PRINT'])) $smarty->display('footer_page.tpl');
	$smarty->display('footer.tpl');

// Index mode
}else{

	$year = $_GET['year'];
	$month = $_GET['month'];

	$entries_per_page = 5; // 5 by default. You can modify manually or by Configuration

	$show_ad_index_pair = (($page - 1) * $entries_per_page);
	$show_ad_index_impair = ((($page - 1) * $entries_per_page) + 2);
	
	$smarty->assign('SHOW_AD_INDEX_PAIR',$show_ad_index_pair);
	$smarty->assign('SHOW_AD_INDEX_IMPAIR',$show_ad_index_impair);
	
	if(isset($_GET['FEED'])) $limit = $entries_per_page;
	
	$smarty->caching = true;
	
	if(!$smarty->is_cached('blog_index.tpl',"blog_index|$page|$year|$month") || (isset($_GET['FEED']) && !$smarty->is_cached('feed_atom_index.tpl'))){
		$entries = get_blog_entries($limit,$year,$month);
		$total = count($entries);
	
		$start = (($page - 1) * $entries_per_page);
		$prev = ($page - 1);
		$next = ($page + 1);
		
		if($start >= $total){
			$page = ceil(($total) / $entries_per_page);
		}
		
		$smarty->assign('YEAR_CHECKED',$year_checked);
		$smarty->assign('MONTH_CHECKED',$month_checked);
		
		if(!empty($year_checked) && empty($month_checked)) $smarty->assign('TITLE',$LANG['entries_of']." $year_checked");
		if(!empty($year_checked) && !empty($month_checked))$smarty->assign('TITLE',$LANG['entries_of'].' '.month_number_to_locale_string($month_checked)." $year_checked");

		$smarty->assign('ENTRIES',$entries);
		$smarty->assign('IS_BLOG', true);
	
		$smarty->assign('PAGE',$page);
		$smarty->assign('START',$start);
		$smarty->assign('PREV',$prev);
		$smarty->assign('NEXT',$next);
		$smarty->assign('EPP',$entries_per_page);
	
		$smarty->assign('SITENAME',$sitename);
	}
	
	// :: Output
	
	if(isset($_GET['FEED'])){
		$smarty->assign('LAST_ENTRY',$entries[0]['id']);
		header('content-type:application/atom+xml');
		$smarty->display('feed_atom_index.tpl');
	}else{
		$smarty->display('header.tpl');
		
		$smarty->caching = 2; $smarty->cache_lifetime = 1296000;
		$smarty->display('header_title.tpl','blog_index|$year|$month');
		$smarty->caching = false;
	
		$smarty->display('header_more.tpl');
		$smarty->display('header_close.tpl');
		$smarty->display('body_h.tpl');
		$smarty->display('container.tpl');

		$smarty->display('sidebar_h.tpl');

		$smarty->display('sidebar_user_data.tpl');
		
		$smarty->is_cached = 2; $smarty->cache_lifetime = 1296000;
		$smarty->display('sidebar_blog.tpl');
		$smarty->caching = false;

		$smarty->display('sidebar_c.tpl');
		$smarty->display('sidebar_f.tpl');
		$smarty->display('content_h.tpl');
		$smarty->caching = 2; $smarty->cache_lifetime = 1296000;
		$smarty->display('blog_index.tpl',"blog_index|$page$year|$month");
		$smarty->caching = false;
		$smarty->display('content_f.tpl');
		$smarty->display('footer_page.tpl');
		$smarty->display('footer.tpl');
	}
}

require_once(INCLUDES_PATH.'footer.php');

?>
