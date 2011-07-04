<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>{{$LANG.control_panel|ucfirst}} :: {{$SITENAME}}</title>
  <link rel="stylesheet" type="text/css"
  href="{{$smarty.const.DPORTAL_PATH}}/default.css" />
  <script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/external_links.js"></script>
{{if !empty($smarty.get.template_file)}}
{{include file="editarea_script.tpl"}}
{{/if}}

  <style type="text/css">
       .titleItem{
          cursor: pointer;
          font-weight: bold;
          text-align:center;
       }
       .content p{
          margin: 3px;
       }
	   
	   .panel_menu {
	   	  display:inline;
		  background: #94D4FC;
		  width:130px;
		  text-align:center;
		  padding: 4px;
		  margin:0 !important;
		  font-weight:bold;
		  border-top: 2px #000 solid;
		  border-left: 2px #000 solid;
		  border-right: 2px #000 solid;
		  border-bottom: 2px #000 solid;
		  position:relative;
		  bottom:-1px;
	   }
	   .selected{
	   	  padding: 6px !important;
	      background: #A5E5FE;
		  border-bottom: none !important;
		  position:relative;
		  bottom:-1px;
		  z-index: 1 !important;
		  font-size: 14px !important;
	   }
	   .panel_submenu{
	      margin:5px auto 0 auto;
		  padding:5px 3px 0px 3px;
		  background:#A5E5FE;
		  border-left:2px #000 solid;
		  border-right:2px #000 solid;
		  border-top:2px #000 solid;
	   }
	   .panel_body {
	   	  background: #A5E5FE;
		  border-left: 2px #000 solid;
		  border-right: 2px #000 solid;
	   }
	   .return_to_index {
	   	  background: #A5E5FE;
		  border-left: 2px #000 solid;
		  border-right: 2px #000 solid;
		  border-bottom: 2px #000 solid;
		  text-align:right;
		  padding: 10px 5px;
	   }
  </style>
</head>

<body>
<div>
<h1 style="margin:0 0 10px 0">DPortal CMS {{$LANG.control_panel|ucfirst}}</h1>

<div style="border:2px solid;background:#CCCCCC;width:800px;margin:auto">
<h5 class="titre">{{$LANG.information|ucfirst}}</h5>
<p style="margin:5px">{{PANEL_MESSAGE}} </p>
</div>
  <div style="clear:both;height:10px"></div>

<div style="padding:5px 0 0 0;width:800px;margin:auto;">
<span class="panel_menu{{if $TAB == "general"}} selected{{/if}} titre">{{if $TAB != "general"}}<a href="{{LINK script="panel" section="general"}}">{{/if}}{{$LANG.general}}{{if $TAB != "general"|ucfirst}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "user_pass"}} selected{{/if}} titre">{{if $TAB != "user_pass"}}<a href="{{LINK script="panel" section="user_pass" argument="?tab=user_pass"}}">{{/if}}{{$LANG.user_and_password|ucfirst}}{{if $TAB != "user_pass"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "sections"}} selected{{/if}} titre">{{if $TAB != "sections"}}<a href="{{LINK script="panel" section="sections" argument="?tab=sections"}}">{{/if}}{{$LANG.sections|ucfirst}}{{if $TAB != "sections"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "gallery"}} selected{{/if}} titre">{{if $TAB != "gallery"}}<a href="{{LINK script="panel" section="gallery" argument="?tab=gallery"}}">{{/if}}{{$LANG.gallery|ucfirst}}{{if $TAB != "gallery"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "videos"}} selected{{/if}} titre">{{if $TAB != "videos"}}<a href="{{LINK script="panel" section="videos" argument="?tab=videos"}}">{{/if}}{{$LANG.videos|ucfirst}}{{if $TAB != "videos"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "style"}} selected{{/if}} titre">{{if $TAB != "style"}}<a href="{{LINK script="panel" section="style" argument="?tab=style"}}">{{/if}}{{$LANG.style|ucfirst}}{{if $TAB != "style"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "backup"}} selected{{/if}} titre">{{if $TAB != "backup"}}<a href="{{LINK script="panel" section="backup" argument="?tab=backup"}}">{{/if}}{{$LANG.backup|ucfirst}}{{if $TAB != "backup"}}</a>{{/if}}</span>
<div class="panel_submenu">
{{if $TAB == "general"}}
{{if $MODE != 'site_conf'}}<a href="{{LINK script="panel" section="general/site_conf" argument="?tab=general&amp;mode=site_conf"}}">{{/if}}{{$LANG.site_conf}}{{if $MODE != 'site_conf'}}</a>{{/if}} | 
{{if $MODE != 'robotstxt'}}<a href="{{LINK script="panel" section="general/robotstxt" argument="?tab=general&amp;mode=robotstxt"}}">{{/if}}robots.txt{{if $MODE != 'robotstxt'}}</a>{{/if}} | 
{{if $MODE != 'phpbb'}}<a href="{{LINK script="panel" section="general/phpbb" argument="?tab=general&amp;mode=phpbb"}}">{{/if}}{{$LANG.phpbb_integration}}{{if $MODE != 'phpbb'}}</a>{{/if}} | 
{{if $MODE != 'memcached'}}<a href="{{LINK script="panel" section="general/memcached" argument="?tab=general&amp;mode=memcached"}}">{{/if}}{{$LANG.memcached_conf}}{{if $MODE != 'memcached'}}</a>{{/if}} | 
{{if $MODE != 'cse'}}<a href="{{LINK script="panel" section="general/cse" argument="?tab=general&amp;mode=cse"}}">{{/if}}{{$LANG.google_cse_conf}}{{if $MODE != 'cse'}}</a>{{/if}}

{{elseif $TAB == "sections"}}
{{if $MODE != 'edit_sections'}}<a href="{{LINK script="panel" section="sections/edit_section" argument="?tab=sections&amp;mode=edit_section"}}">{{/if}}{{$LANG.edit_sections}}{{if $MODE != 'edit_sections'}}</a>{{/if}} | 
{{if $MODE != 'create_section'}}<a href="{{LINK script="panel" section="sections/create_section" argument="?tab=sections&amp;mode=create_section"}}">{{/if}}{{$LANG.create_section}}{{if $MODE != 'create_section'}}</a>{{/if}} |
{{if $MODE != 'create_category'}}<a href="{{LINK script="panel" section="sections/create_category" argument="?tab=sections&amp;mode=create_category"}}">{{/if}}{{$LANG.create_category}}{{if $MODE != 'create_category'}}</a>{{/if}} | 
{{if $MODE != 'edit_category'}}<a href="{{LINK script="panel" section="sections/edit_category" argument="?tab=sections&amp;mode=edit_category"}}">{{/if}}{{$LANG.edit_category}}{{if $MODE != 'edit_category'}}</a>{{/if}}

{{elseif $TAB == "gallery"}}
{{if !empty($GALLERIES)}}
{{if $MODE != 'edit'}}<a href="{{LINK script="panel" section="gallery/edit" argument="?tab=gallery&amp;mode=edit"}}">{{/if}}{{$LANG.edit_galleries}}{{if $MODE != 'edit'}}</a>{{/if}} | 
{{/if}}
{{if $MODE != 'create' && !empty($GALLERIES)}}<a href="{{LINK script="panel" section="gallery/create" argument="?tab=gallery&amp;mode=create"}}">{{/if}}{{$LANG.create_gallery}}{{if $MODE != 'create' && !empty($GALLERIES)}}</a>{{/if}}
{{if !empty($GALLERY_NAME)}} | <a href="{{LINK script="gallery_gallery" section="$GALLERY_NAME" argument="?gallery=$GALLERY_NAME"}}">{{$LANG.goto_gallery}}</a>{{/if}}


{{elseif $TAB == "videos"}}
{{if !empty($PLAYLISTS)}}
{{if $MODE != 'upload'}}<a href="{{LINK script="panel" section="videos/upload" argument="?tab=videos&amp;mode=upload"}}">{{/if}}{{$LANG.upload_edit}}{{if $MODE != 'upload'}}</a>{{/if}} | 
{{/if}}
{{if $MODE != 'create'}}<a href="{{LINK script="panel" section="videos/create" argument="?tab=videos&amp;mode=create"}}">{{/if}}{{$LANG.create_playlist}}{{if $MODE != 'create'}}</a>{{/if}}
{{if !empty($PLAYLIST)}} | <a href="{{LINK script="playlist" section="$PLAYLIST"  argument="?playlist=$PLAYLIST"}}">{{$LANG.goto_playlist}}</a>{{/if}}

{{elseif $TAB == "style"}}
{{if $MODE != 'edit_style'}}<a href="{{LINK script="panel" section="style/edit_style" argument="?tab=style&amp;mode=edit_style"}}">{{/if}}{{$LANG.edit_style}}{{if $MODE != 'edit_style'}}</a>{{/if}} | 
{{if $MODE != 'template'}}<a href="{{LINK script="panel" section="style/template" argument="?tab=style&amp;mode=template"}}">{{/if}}{{$LANG.edit_templates}}{{if $MODE != 'template'}}</a>{{/if}}

{{elseif $TAB == "backup"}}
{{if !empty($BACKUPS)}}{{if $MODE != 'download'}}<a href="{{LINK script="panel" section="backup/download" argument="?tab=backup&amp;mode=download"}}">{{/if}}{{$LANG.download_backup}}{{if $MODE != 'download'}}</a>{{/if}} | {{/if}}
{{if $MODE != 'create'}}<a href="{{LINK script="panel" section="backup/create" argument="?tab=backup&amp;mode=create"}}">{{/if}}{{$LANG.create_backup}}{{if $MODE != 'create'}}</a>{{/if}} | 
{{if $MODE != 'restore'}}<a href="{{LINK script="panel" section="backup/restore" argument="?tab=backup&amp;mode=restore"}}">{{/if}}{{$LANG.restore_backup}}{{if $MODE != 'restore'}}</a>{{/if}}{{if !empty($BACKUPS)}} | 
{{if $MODE != 'delete'}}<a href="{{LINK script="panel" section="backup/delete" argument="?tab=backup&amp;mode=delete"}}">{{/if}}{{$LANG.delete_backup}}{{if $MODE != 'delete'}}</a>{{/if}} {{/if}}

{{/if}}
</div>

<div class="panel_body">
{{if $TAB == 'general'}}
{{if $MODE == 'site_conf'}}{{include file="panel_siteconf.tpl"}}
{{elseif $MODE == 'robotstxt'}}{{include file="panel_robotstxt.tpl"}}
{{elseif $MODE == 'phpbb'}}{{include file="panel_phpbb.tpl"}}
{{elseif $MODE == 'memcached'}}{{include file="panel_memcached.tpl"}}
{{elseif $MODE == 'cse'}}{{include file="panel_cse.tpl"}}
{{/if}}

{{elseif $TAB == 'user_pass'}}
{{include file="panel_user_pass.tpl"}}

{{elseif $TAB == 'sections'}}
{{if $MODE == 'edit_sections'}}{{include file="panel_edit_sections.tpl"}}
{{elseif $MODE == 'create_section'}}{{include file="panel_create_section.tpl"}}
{{elseif $MODE == 'create_category'}}{{include file="panel_create_category.tpl"}}
{{* Reuse the template "panel_edit_style.tpl" that says "Not implemented yet" *}}
{{elseif $MODE == 'edit_category'}}{{include file="panel_edit_category.tpl"}}

{{/if}}

{{elseif $TAB == 'gallery'}}
{{if $MODE == 'edit'}}{{include file="panel_edit_gallery.tpl"}}
{{elseif $MODE == 'create'}}{{include file="panel_create_gallery.tpl"}}
{{/if}}

{{elseif $TAB == 'videos'}}
{{if $MODE == 'edit'}}{{include file="panel_edit_style.tpl"}}
{{elseif $MODE == 'upload'}}{{include file="panel_upload_videos.tpl"}}
{{elseif $MODE == 'create'}}{{include file="panel_create_playlist.tpl"}}
{{/if}}

{{elseif $TAB == 'style'}}
{{if $MODE == 'template'}}{{include file="panel_edit_template.tpl"}}
{{elseif $MODE == 'edit_style'}}{{include file="panel_edit_style.tpl"}}
{{/if}}

{{elseif $TAB == 'backup'}}
{{if $MODE == 'download'}}{{include file="panel_backup_download.tpl"}}
{{elseif $MODE == 'create'}}{{include file="panel_backup_create.tpl"}}
{{elseif $MODE == 'restore'}}{{include file="panel_backup_restore.tpl"}}
{{elseif $MODE == 'delete'}}{{include file="panel_backup_delete.tpl"}}{{/if}}
{{/if}}
</div>
<div class="return_to_index">
<a href="{{LINK script="panel" section="clear_cache" argument="?CLR_CACHE"}}">{{$LANG.clear_all_cache}}</a> | 
<a href="{{LINK section="home"}}">{{$LANG.return_to_index}}</a>
</div>

</div>
</div>
</body>
</html>
