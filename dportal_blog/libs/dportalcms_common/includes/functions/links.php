<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  Functions for create Links (panel.php)      #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU General Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

// void redir(string section, [string script, string argumert_URI, string marker_position])
function redir($script,$section,$http_status = null,$argument = null,$marker = null){

	global $use_rewrite;
	global $path;
	
	if($use_rewrite){
	
		if($argument != null) $argument = "$argument";
		if($marker != null)$marker = "#$marker";
	
		switch($script){
			default			: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH); break;
			case "blog_entry"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/$section.html$marker"); break;
			case "panel"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/$section$marker"); break;
		}
	
	}else{
	
		if($argument != null) $argument = "$argument";
		if($marker != null) $marker = "#$marker";
	
		switch($script){
			default			: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/index.php$argument$marker"); break;
			case "blog_entry"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/index.php?entry=$section".$marker); break;
			case "panel"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/panel.php$argument$marker"); break;
		}
	}
	die();
}

// string Smarty registered function link_url(array params('section','script',&$smarty)
function link_url($params,&$smarty){

	global $use_rewrite;
	
	$section = $params['section'];	// string
	$script = $params['script'];	// string
	$ext = $params['ext'];		// string
	$page = $params['page'];	// string
	$argument = $params['argument'];// array
	if(!empty($params['marker'])) $marker = '#'.$params['marker'];	// string

	if($use_rewrite){
	
		switch($script){
			default				: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/".$section.$page.$marker; break;
			case 'stylesheet'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/style.css"; break;
			case 'login'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/LOGIN"; break;
			case 'logout'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/LOGOUT"; break;
			case 'panel'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/panel/$section$page$marker"; break;
			case 'blog_edit'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/edit:$section"; break;
			case 'blog_delete'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/delete:$section"; break;
			case 'blog_delete_comments'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/DELETE_COMMENTS"; break;
			case 'blog_save'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/POST"; break;
			case 'blog_goto'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH.'/'.$section."page:$page"; break;
			case 'blog_entry'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/$section.html$marker"; break;
			case 'blog_comments_goto'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/".$section.'_'.$page.'.html'.$marker; break;
			case 'blog_comments_goto_ajax'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/comments:".$section.'_'.$page; break;
			case 'blog_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/atom.xml"; break;
			case 'blog_entry_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/".$section.'_atom.xml'; break;
		}	
	}else{
	
		switch($script){
			default				: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php".$argument; break;
			case 'stylesheet'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/style.php"; break;
			case 'login'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?LOGIN"; break;
			case 'logout'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?LOGOUT"; break;
			case 'panel'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/panel.php$argument".$marker; break;
			case 'blog_edit'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?EDIT&amp;entry=$section"; break;
			case 'blog_delete'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?DELETE&amp;entry=$section"; break;
			case 'blog_delete_comments'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?DELETE_COMMENTS"; break;
			case 'blog_save'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?POST"; break;
			case 'blog_goto'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?page=".$page.$argument.$marker; break;
			case 'blog_entry'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?entry=".$section.$marker; break;
			case 'blog_comments_goto'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?entry=".$section.'&amp;page='.$page.$marker; break;
			case 'blog_comments_goto_ajax'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?COMMENTS&amp;entry=".$section.'&amp;page='.$page.$marker; break;
			case 'blog_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?FEED"; break;
			case 'blog_entry_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?entry=".$section.'&amp;FEED'; break;
		}
	
	}
	return str_replace('//sections','/sections',$uri);
}

?>