<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>{{$LANG.control_panel|ucfirst}} :: {{$SITENAME}}</title>
  <link rel="stylesheet" type="text/css"
  href="{{$smarty.const.DPORTAL_PATH}}/default.css" />
  <script type="text/javascript"
  src="{{$smarty.const.DPORTAL_PATH}}/external_links.js">
  </script>
  <script type="text/javascript">
      <!--
function items(id){
var obj = document.getElementById('item_' + id)
if(obj.style.display == 'block') obj.style.display = 'none'
else obj.style.display = 'block'
}

//--></script>
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
<span class="panel_menu{{if $TAB == "general"}} selected{{/if}} titre">{{if $TAB != "general"}}<a href="{{LINK script="panel" section="general"}}">{{/if}}General{{if $TAB != "general"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "user_pass"}} selected{{/if}} titre">{{if $TAB != "user_pass"}}<a href="{{LINK script="panel" section="user_pass"}}">{{/if}}User &amp; Password{{if $TAB != "user_pass"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "sections"}} selected{{/if}} titre">{{if $TAB != "sections"}}<a href="{{LINK script="panel" section="sections"}}">{{/if}}Sections{{if $TAB != "sections"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "gallery"}} selected{{/if}} titre">{{if $TAB != "gallery"}}<a href="{{LINK script="panel" section="gallery"}}">{{/if}}Gallery{{if $TAB != "gallery"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "videos"}} selected{{/if}} titre">{{if $TAB != "videos"}}<a href="{{LINK script="panel" section="videos"}}">{{/if}}Videos{{if $TAB != "videos"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "style"}} selected{{/if}} titre">{{if $TAB != "style"}}<a href="{{LINK script="panel" section="style"}}">{{/if}}Style{{if $TAB != "style"}}</a>{{/if}}</span>
<span class="panel_menu{{if $TAB == "backup"}} selected{{/if}} titre">{{if $TAB != "backup"}}<a href="{{LINK script="panel" section="backup"}}">{{/if}}Backups{{if $TAB != "backup"}}</a>{{/if}}</span>
<div class="panel_submenu">
{{if $TAB == "general"}}
{{if $MODE != 'site_conf'}}<a href="{{LINK script="panel" section="general/site_conf"}}">{{/if}}Site configuration{{if $MODE != 'site_conf'}}</a>{{/if}} | 
{{if $MODE != 'robotstxt'}}<a href="{{LINK script="panel" section="general/robotstxt"}}">{{/if}}robots.txt{{if $MODE != 'robotstxt'}}</a>{{/if}} | 
{{if $MODE != 'phpbb'}}<a href="{{LINK script="panel" section="general/phpbb"}}">{{/if}}phpBB integration{{if $MODE != 'phpbb'}}</a>{{/if}} | 
{{if $MODE != 'memcached'}}<a href="{{LINK script="panel" section="general/memcached"}}">{{/if}}Memcached configuration{{if $MODE != 'memcached'}}</a>{{/if}} | 
{{if $MODE != 'cse'}}<a href="{{LINK script="panel" section="general/cse"}}">{{/if}}Google CSE options{{if $MODE != 'cse'}}</a>{{/if}}

{{elseif $TAB == "sections"}}
{{if $MODE != 'edit_sections'}}<a href="{{LINK script="panel" section="sections/edit_section"}}">{{/if}}Edit Sections{{if $MODE != 'edit_sections'}}</a>{{/if}} | 
{{if $MODE != 'create_section'}}<a href="{{LINK script="panel" section="sections/create_section"}}">{{/if}}Create Section{{if $MODE != 'create_section'}}</a>{{/if}} |
{{if $MODE != 'create_category'}}<a href="{{LINK script="panel" section="sections/create_category"}}">{{/if}}Create Category{{if $MODE != 'create_category'}}</a>{{/if}} | 

{{if $MODE != 'edit_category'}}<a href="{{LINK script="panel" section="sections/edit_category"}}">{{/if}}Edit Category{{if $MODE != 'edit_category'}}</a>{{/if}}

{{elseif $TAB == "gallery"}}
{{if !empty($GALLERIES)}}
{{if $MODE != 'edit'}}<a href="{{LINK script="panel" section="gallery/edit"}}">{{/if}}Edit Galleries{{if $MODE != 'edit'}}</a>{{/if}} | 
{{/if}}
{{if $MODE != 'create' && !empty($GALLERIES)}}<a href="{{LINK script="panel" section="gallery/create"}}">{{/if}}Create Gallery{{if $MODE != 'create' && !empty($GALLERIES)}}</a>{{/if}}
{{if !empty($GALLERY_NAME)}} | <a href="{{LINK script="gallery_gallery" section="$GALLERY_NAME"}}">Go to Gallery</a>{{/if}}


{{elseif $TAB == "videos"}}
{{if !empty($PLAYLISTS)}}
{{if $MODE != 'upload'}}<a href="{{LINK script="panel" section="videos/upload"}}">{{/if}}Upload/Edit{{if $MODE != 'upload'}}</a>{{/if}} | 
{{/if}}
{{if $MODE != 'create'}}<a href="{{LINK script="panel" section="videos/create"}}">{{/if}}Create Playlist{{if $MODE != 'create'}}</a>{{/if}}
{{if !empty($PLAYLIST)}} | <a href="{{LINK script="playlist" section="$PLAYLIST"}}">Go to Playlist</a>{{/if}}

{{elseif $TAB == "style"}}
{{if $MODE != 'edit_style'}}<a href="{{LINK script="panel" section="style/edit_style"}}">{{/if}}Edit Style{{if $MODE != 'edit_style'}}</a>{{/if}} | 
{{if $MODE != 'template'}}<a href="{{LINK script="panel" section="style/template"}}">{{/if}}Edit Templates{{if $MODE != 'template'}}</a>{{/if}}

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
{{elseif $MODE == 'edit_category'}}{{include file="panel_edit_style.tpl"}}

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
{{include file="panel_backup.tpl"}}
{{/if}}
</div>
<div class="return_to_index">
<a href="{{LINK script="panel" section="clear_cache"}}">Clear all Cache/compiled templates</a> | 
<a href="{{LINK section="home"}}">Return to Index</a>
</div>

</div>
</div>
</body>
</html>
