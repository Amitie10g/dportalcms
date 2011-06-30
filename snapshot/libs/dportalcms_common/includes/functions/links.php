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


/* ABOUT THIS FUNCTION
 * 
 * This function makes a HTTP redir width header() function. This is used for Redirection
 * where the server supporrts or not the mod_rewrite and redirect to a correct place.
 * 
 * header('location:/home.html') redirect to HOME if you use the mod_rewrite.
 * header("location:/index.php?section:home"); is for mod_rewrite disabled.
 *
 *
 * String section is required. If you no indicate a section (ex index.php or blog.php),
 * you must indicate a section paramener with NOT NULL value; that is not important,
 * the only important value is the second parameter, that is the Script.
 *
 *
 * Examples:
 *
 * redir('index','home');
 * Is valid and the two parameters are reqired. The two values are required.
 * If you indicate an invalid SECTION value, the function returns a valid value,
 * but a 404 page.
 *
 * redir('blog','blog');
 * This is for Blog index. The first parameter indicates the Script,
 * but the second parameter IS NOT IMPORTANT; this can be the same value
 * or different, but MUST NOT BE NULL.
 *
 * redir('blog_entry',$name);
 * This idnicates a Blog entry, the same as index.
 *
 * redir('panel','control panel');
 * The same as blog Index. The second parameter are required but is not used.
 *
*/

// void redir(string section, [string script, string argumert_URI, string marker_position])
function redir($script,$section,$http_status = null,$argument = null,$marker = null){

	global $use_rewrite;
	global $path;
	
	if($use_rewrite){
	
		if($argument != null) $argument = "$argument";
		if($marker != null)$marker = "#$marker";
	
		switch($script){
			case "edit"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/edit/section:$section"); break;
			case "new"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/edit/new_section:$section"); break;
			case "saved"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/edit/SAVED"); break;
			case "panel"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/panel/$section$argument"); break;
			case "gallery"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/gallery/$section.html$argument"); break;
			case "gallery_index"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/gallery/"); break;
			case "gallery_ajax"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/gallery/".$_GET['gallery']."_ajax"); break;
			case "blog"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/blog/"); break;
			case "blog_entry"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/blog/$section.html$marker"); break;
			case "tv"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/media_player/"); break;
			case "playlist"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/media_player/$section/"); break;
			case "video"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/media_player/$section/" . $argument . ".html$marker"); break;
			case "chapter"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/book/$section/" . $argument . ".html$marker"); break;
			case "chapter_edit"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/book/edit:$section/$argument"); break;
			case "book_index"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/book/"); break;
			case "book_filterauthor": header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/book/author:$section"); break;
			default			: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/" . str_replace('_','/',$section) . ".html$marker"); break;
		}
	
	}else{
	
		if($argument != null) $argument = "$argument";
		if($marker != null) $marker = "#$marker";
	
		switch($script){
			case "edit"			: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/edit.php$argument&section=$section"); break;
			case "new"			: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/edit.php?section=$section&NEW"); break;
			case "saved"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/edit.php?SAVED"); break;
			case "panel"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/panel.php$argument$marker"); break;
			case "gallery"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/gallery.php?gallery=$section$argument$marker"); break;
			case "gallery_index": header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/gallery.php"); break;
			case "gallery_ajax"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/gallery.php?gallery=".$_GET['gallery']."&ajax"); break;
			case "blog"			: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/blog.php"); break;
			case "blog_entry"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/blog.php?entry=$section".$marker); break;
			case "tv"			: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/tv.php"); break;
			case "playlist"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/tv.php?playlist=$section".$marker); break;
			case "video"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/tv.php?playlist=$section&video=$argument".$marker); break;
			case "chapter"		: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/book.php?book=$section&chapter=$argument".$marker); break;
			case "chapter_edit"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/book.php?EDIT&book=$section&chapter=$argument".$marker); break;
			case "book_index"	: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/book.php?INDEX"); break;
			case "book_filterauthor": header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/book.php?author=$section"); break;
			default			: header("location: http://".$_SERVER['SERVER_NAME'].DPORTAL_PATH ."/index.php?section=$section".$marker); break;
		}
	}

}

/* ABOUT THIS FUNCTION
 *
 * This is a Smarty Custom function and return the correct URI if you use or not 
 * mod_rewrite for the Templates. This function is called link_url in the Script,
 * and is registered in Smarty as 'LINK'
 *
 * This function is similar to the first function, redir(), but returns al URI
 *
 * Parameters:
 * 
 * section: Is the Section and can be empty
 * script: Is the script to be used. Ex index.php, blog.php, etc
 *
 * Examples:
 *
 * Simple URL linking
 *
 * 		Template:
 * 		------------------------------------------------------------
 *  		<a href="{LINK section=$section script='index'}>Home</a>
 * 		------------------------------------------------------------
 *
 * 		Output:
 * 		------------------------------------------------------------
 * 			<a href="/home.html">Home</a>
 * 		------------------------------------------------------------
 *
 *		Output(mod_rewrite disabled
 *		------------------------------------------------------------
 *			<a href="/index.php?section=home.html">Home</a>
 *		------------------------------------------------------------
 *
 * Using Absolute Domain URL path (required for Feeds)
 *
 * 		Template:
 * 		------------------------------------------------------------
 *  		<link href="{$smarty.server.SERVER_NAME}
 *			{LINK script='feed_index'}>{$SITENAME}</link>
 * 		------------------------------------------------------------
 *
 * 		Output:
 * 		------------------------------------------------------------
 * 			<link href="http://foobar.com/blog/atom.xml">
 *			Blog Foo Bar</link>
 * 		------------------------------------------------------------
*/

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
			case 'login'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/LOGIN"; break;
			case 'logout'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/LOGOUT"; break;
			case 'panel'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/panel/$section$page$marker"; break;
			case 'edit'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/edit/$page$section".$marker; break;
			case 'blog'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/$page".$marker; break;
			case 'blog_edit'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/edit:$section"; break;
			case 'blog_delete'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/delete:$section"; break;
			case 'blog_delete_comments'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/DELETE_COMMENTS"; break;
			case 'blog_save'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/POST"; break;
			case 'blog_goto'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/page:".$section; break;
			case 'blog_entry'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/".$section.'.html'.$marker; break;
			case 'blog_comments_goto'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/".$section.'_'.$page.'.html'.$marker; break;
			case 'blog_comments_goto_ajax'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/comments:".$section.'_'.$page; break;
			case 'blog_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/atom.xml"; break;
			case 'blog_entry_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog/".$section.'_atom.xml'; break;
			case 'gallery_index'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery/"; break;
			case 'gallery_gallery'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery/".$section.'.html'.$marker; break;
			case 'gallery_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery/".$section.'_feed.xml'; break;
			case 'gallery_ajax'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery/".$section.'_ajax'; break;
			case 'gallery_ajax_goto'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery/".$section.'_ajax/page:'.$page; break;
			case 'gallery_image'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery/".$section.'.'.strtolower($ext); break;
			case 'gallery_image_orig'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery/".$section.'_orig.'.strtolower($ext); break;
			case 'gallery_image_prev'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery/".$section.'_prev.'.strtolower($ext); break;
			case 'video_script'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/"; break;
			case 'showcase'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/"; break;
			case 'showcase_goto'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/page:".$section; break;
			case 'playlist'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/".$section.'/'; break;
			case 'playlist_goto'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/".$page.'/page:'.$section; break;
			case 'player'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/".$page.'/'. $section.'.html'.$marker; break;
			case 'player_hq'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/".$page.'/'. $section.'_hq.html'.$marker; break;
			case 'video_thumb'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/thumbs/". $section.'.jpg'; break;
			case 'video'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/".$page.'/'. $section.'.flv'; break;
			case 'video_hq'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/".$page.'/'. $section.'_hq.flv'; break;
			case 'video_download'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/media_player/".$page.'/download:'. $section.'.flv'; break;
			case 'category'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/".$section."/sections/"; break;
			case 'categories'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/categories/"; break;
			case 'index_pdf'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/". str_replace('_','/',$section).'.pdf'; break;
			default				: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/". str_replace('_','/',$section).'.html'.$marker; break;
		}	
	}else{
	
			switch($script){
			case 'login'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?LOGIN"; break;
			case 'logout'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?LOGOUT"; break;
			case 'panel'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/panel.php$argument".$marker; break;
			case 'edit'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/edit.php".$argument.$section.$marker; break;
			case 'edit_section'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/edit.php".$marker; break;
			case 'blog'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php".$argument; break;
			case 'blog_edit'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?EDIT&amp;entry=$section"; break;
			case 'blog_delete'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?DELETE&amp;entry=$section"; break;
			case 'blog_delete_comments'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?DELETE_COMMENTS"; break;
			case 'blog_save'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?POST"; break;
			case 'blog_goto'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?page=".$section.$marker; break;
			case 'blog_entry'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?entry=".$section.$marker; break;
			case 'blog_comments_goto'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?entry=".$section.'&amp;page='.$page.$marker; break;
			case 'blog_comments_goto_ajax'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?COMMENTS&amp;entry=".$section.'&amp;page='.$page.$marker; break;
			case 'blog_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?FEED"; break;
			case 'blog_entry_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/blog.php?entry=".$section.'&amp;FEED'; break;
			case 'gallery_index'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery.php".$marker; break;
			case 'gallery_gallery'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery.php?gallery=".$section.$marker; break;
			case 'gallery_feed'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery.php?gallery=".$section.'&amp;FEED'; break;
			case 'gallery_ajax'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery.php?gallery=".$section.'&amp;AJAX'; break;
			case 'gallery_ajax_goto'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery.php?gallery=".$section.'&amp;AJAX&amp;page='.$page; break;
			case 'gallery_image'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery.php?IMAGE&amp;token=".$section; break;
			case 'gallery_image_orig'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery.php?IMAGE&amp;token=".$section.'&amp;ORIG'; break;
			case 'gallery_image_prev'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/gallery.php?IMAGE&amp;token=".$section.'&amp;PREV'; break;
			case 'video_script'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php".$marker; break;
			case 'showcase'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php".$marker; break;
			case 'showcase_goto'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php?page=".$section.$marker; break;
			case 'playlist'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php?playlist=".$section.$marker; break;
			case 'playlist_goto'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php?playlist=".$page.'&amp;page='.$section.$marker; break;
			case 'player'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php?playlist=".$page.'&amp;video='.$section.$marker; break;
			case 'player_hq'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php?playlist=".$page.'&amp;video='. $section.'_hq'.$marker; break;
			case 'video_thumb'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php?video=". $section.'&amp;THUMB'; break;
			case 'video'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php?playlist=".$page.'&amp;file='.$section; break;
			case 'video_hq'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/tv.php?playlist=".$page.'&amp;file='.$section.'_hq'; break;
			case 'books'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/book.php$argument".$marker; break;
			case 'books_filter_author'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/book.php?author=$section".$marker; break;
			case 'chapter'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/book.php?book=".$argument.'&amp;chapter='.$section.$marker; break;
			case 'book_comments_goto'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/book.php?book=".$argument.'&amp;chapter='. $section.'&amp;page='.$page.$marker; break;
			case 'book_comments_goto_ajax'	: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/book.php?COMMENTS&amp;book=".$argument.'&amp;chapter='. $section.'&amp;page='.$page.$marker; break;
			case 'chapter_print'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/book.php?PRINT&amp;book=".$page.'&amp;chapter='.$section.$marker; break;
			case 'chapter_pdf'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/book.php?PDF&amp;book=".$page.'&amp;chapter='.$section.$marker; break;
			case 'edit_chapter'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/book.php?EDIT&amp;book=".$page.'&amp;chapter='.$section.$marker; break;
			case 'category'			: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?category=".$section.$marker; break;
			case 'categories'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?CATEGORIES".$marker; break;
			case 'index_pdf'		: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?section=".$section.'&amp;PDF'; break;
			default				: $uri = 'http://'.$_SERVER['SERVER_NAME'].DPORTAL_PATH."/index.php?section=".$section.$marker; break;
		}
	
	}
	return str_replace('//sections','/sections',$uri);
}

?>