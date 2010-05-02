<?php
		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  DBlog, Blog (blog.php)                      #
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

// Gets the Entry name
$entry_name = $_GET['entry'];

// Alerts and Messages
$blog_message = get_blog_message();
$blog_alert = get_alerts(); 
if($blog_message != null) $smarty->assign('MESSAGE',$blog_message);
if($blog_alert != null) $smarty->assign('WARNING_MESSAGE',$blog_alert);

// Create new entry
if(isset($_GET['NEW']) && $user_admin){

	$smarty->assign('TITLE',$_SESSION['title']);
	$smarty->assign('CONTENT',$_SESSION['content']);
		
	$new_entry = true;
	$smarty->assign('NEW',$new_entry);
	$smarty->display('blog_edit.tpl');

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

	$smarty->assign('IS_BLOG', true);
	$smarty->assign('BLOG_ENTRY', true);

 	$smarty->display('blog_edit.tpl');

// Delete mode
}elseif(isset($_GET['DELETE']) && $user_admin){

	$entry = $_GET['entry'];

	$smarty->clear_cache('feed_atom_index.tpl');
	$smarty->clear_cache(null,'blog_index');
	$smarty->clear_cache(null,$entry);

	if(delete_entry($entry)) $_SESSION['blog_entry_deleted'] = true;

	redir('blog','blog'); die();
	
// Moderate comments mode
}elseif(isset($_GET['DELETE_COMMENTS']) && $user_admin){

	$id = $_POST['entry'];
	$comments = $_POST['comments'];
	$action = $_POST['action'];
	
	$name = get_post_name($id);

	$smarty->clear_cache('feed_atom_index.tpl');
	$smarty->clear_cache(null,'blog_index');
	$smarty->clear_cache(null,$id);

	if($id != null && $comments != null){
		if(moderate_comments($id,$comments,0)) $moderated = true;
	}
	
	$smarty->clear_cache(null,"blog_comments|$id");
	
	clearstatcache(true,COMMENTS_PATH . $id);
	
	if($moderated) $_SESSION['blog_comment_deleted'] = true;
	else $_SESSION['blog_comment_not_deleted'] = true;

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

	if($title == null){
		$_SESSION['content'] = $content;
		$_SESSION['title_empty'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
		die();
	}

	if($content == null){
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
	$smarty->clear_cache(null,"blog_comments|$id");
	$smarty->clear_cache("blog_entry_content.tpl",$id);

	// Redir to the Entry
	redir('blog_entry',$name,null,null,"comments"); die();

// Publish comment mode
}elseif(isset($_GET['POST_COMMENT'])){

	// Get the data form GET
	$id = $_POST['id'];
	$nick = stripslashes($_POST['nick']);
	$email = stripslashes($_POST['email']);
	$url = stripslashes($_POST['url']);
	$comment = stripslashes($_POST['comment']);
	$timestamp = time();
	
	$name = get_post_name($id);

	$posting = blog_post_comment($id,$timestamp,$nick,$comment,$email,$url);

	if($posting) $_SESSION['blog_post_saved'] = true;
	else $_SESSION['blog_post_error'] = true;

	$smarty->clear_cache(null,"blog_comments|$id");
	
	clearstatcache(true,COMMENTS_PATH . $id);

	// Dedir to the Entry page, comments section
	if($posting) redir('blog_entry',$name,null,null,'comments');
	else redir('blog_entry',$name,null,null,'comment');
		
	die();

// Entry mode
}elseif(isset($entry_name) &&!isset($_GET['EDIT']) && !isset($_GET['FEED'])){

	if($_GET['page'] == 1) redir('blog_entry',$entry_name);

	$smarty->assign("IS_BLOG", true);

	$page = $_GET['page'];
	if($_GET['page'] < 1) $page = 1;

	$get_entry = get_blog_entry($entry_name);

	if($get_entry != false){

		$smarty->caching = true;

		$comments_per_page = 10;
		$start = (($page - 1) * $comments_per_page);
		$prev = ($page - 1);
		$next = ($page + 1);
	
		$title = $get_entry['title'];
		$id = $get_entry['id'];
		$name = $get_entry['name'];
		$file = $get_entry['file'];
		$tags = $get_entry['tags'];
		
		if(!$smarty->is_cached("blog_entry_comments.tpl","blog_comments|$id|$page") || $user_admin) $comments = get_comments_post($id);
		elseif(filesize(COMMENTS_PATH.$id) === 0) $comments = false;

		$total = count($comments);

		if($start > $total){
			header('HTTP/1.1 307 Redirection');
			redir('blog_entry',$name); die();
		}
	
		$smarty->assign('PAGE',$page);
		$smarty->assign('START',$start);
		$smarty->assign('PREV',$prev);
		$smarty->assign('NEXT',$next);
		$smarty->assign('CPP',$comments_per_page);

		$smarty->assign('ID',$id);
		$smarty->assign('NAME',$name);	
		$smarty->assign('FILE',$file);
		$smarty->assign('TAGS',$tags);
		$smarty->assign('TITLE',$title);
	
		$smarty->assign('COMMENTS',$comments);
		
		$smarty->assign('IS_ENTRY',true);
	
	}else{
		header('HTTP/1.1 404 Not found');
		$smarty->assign('TITLE',"Not found");
	}

	// :: Output
	$smarty->caching = false;
	$smarty->display('header.tpl');

	$smarty->display('header_title.tpl');

	$smarty->display('header_more.tpl');

	$smarty->display('menu_h.tpl');

	$smarty->display('menu_f.tpl');
	$smarty->display('header_f.tpl');

	$smarty->display('sidebar_h.tpl');
	$smarty->display('sidebar_search.tpl');

	$smarty->display('sidebar_user_data.tpl');

	$smarty->display('sidebar_c.tpl');
	$smarty->display('sidebar_f.tpl');
	
	if($get_entry != null){
		$smarty->display('blog_entry_header.tpl');
		$smarty->caching = 2;$smarty->cache_lifetime = 262800;
		$smarty->display('blog_entry_content.tpl',$id);
		$smarty->caching = false;
		$smarty->display('blog_entry_comments_h.tpl');
		if($IS_ADMIN) $smarty->display('blog_entry_comments_moderate.tpl');
		$smarty->caching = 2;$smarty->cache_lifetime = 262800;
		$smarty->display('blog_entry_comments.tpl',"blog_comments|$id|$page");
		$smarty->caching = false;
		$smarty->display('blog_entry_comments_f.tpl');
		$smarty->display('blog_entry_form.tpl');
		$smarty->display('blog_entry_footer.tpl');
	}else{
		$smarty->display('blog_entry_not_found.tpl');
	}
	$smarty->display('footer.tpl');

// Feed Index mode
}elseif(isset($_GET['FEED']) && !isset($_GET['entry'])){

	$smarty->caching = true;
	if(!$smarty->is_cached('feed_atom_index.tpl')){

		$entries = get_blog_entries_feed(5);

		if($entries == null){
		header('HTTP/1.1 404 Not found');
		die($LANG['no_entries_published']);
		}

		$lastentry = $entries[0][id];

		$smarty->assign('ENTRIES',$entries);
		$smarty->assign('LAST_ENTRY',$lastentry);
	}

	$smarty->caching = 2; $smarty->cache_lifetime = 2592000;

	header('content-type:application/atom+xml');
	$smarty->display('feed_atom_index.tpl');

// Feed Entry mode
}elseif(isset($_GET['FEED']) && isset($_GET['entry'])){

  $smarty->caching = true;

	$entry = get_blog_entry_feed($entry_name);
	
	if($entry == false){
		header('HTTP/1.1 404 Not found');
		die($LANG['not_found']);
	}
	
	$smarty->assign('ENTRY',$entry);
	
	$smarty->caching = 2; $smarty->cache_lifetime = 2592000;

	header('content-type:application/atom+xml');
	$smarty->display('feed_atom_entry.tpl',$entry_name);

// Index mode
}else{

	$page = $_GET['page'];
	if($_GET['page'] < 1) $page = 1;

	if(!$smarty->is_cached('blog_index.tpl')){

	$entries = get_blog_entries($blog_entries_index);
	$total = count($entries);

		$entries_per_page = 5; // 5 by default
		$start = (($page - 1) * $entries_per_page);
		$prev = ($page - 1);
		$next = ($page + 1);

		if($start > $total){
			header('HTTP/1.1 307 Redirection');
			redir('blog','blog'); die();
		}

	}

	$smarty->assign('ENTRIES',$entries);
	$smarty->assign('IS_BLOG', true);

	$smarty->assign('PAGE',$page);
	$smarty->assign('START',$start);
	$smarty->assign('PREV',$prev);
	$smarty->assign('NEXT',$next);
	$smarty->assign('EPP',$entries_per_page);

	$smarty->assign('SITENAME',$sitename);
	$smarty->assign('TITLE','Blog');

	// :: Output
	$smarty->caching = false;
	$smarty->display('header.tpl');
	
	$smarty->display('header_title.tpl');
	
	$smarty->display('header_more.tpl');
	
	$smarty->display('menu_h.tpl');
	$smarty->display('menu_f.tpl');
	
	$smarty->display('header_f.tpl');

	$smarty->display('sidebar_h.tpl');
	$smarty->display('sidebar_search.tpl');

	$smarty->display('sidebar_user_data.tpl');

	$smarty->display('sidebar_c.tpl');
	$smarty->display('sidebar_f.tpl');
	$smarty->caching = 2;$smarty->cache_lifetime = 262800;
	$smarty->display('blog_index.tpl',"blog_index|$page");
	$smarty->caching = false;
	$smarty->display('footer.tpl');

}

require_once('includes/footer.php');

?>
