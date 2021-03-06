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
		  background: #AAAAFF;
		  width:130px;
		  text-align:center;
		  padding: 5px;
		  font-weight:bold
	   }
	   .panel_menu_selected{
	      background: #CCCCFF;
	   }
	   .panel_submenu{
	      display:inline;
	   }
  </style>
</head>

<body>

<div style="width:600px;margin:auto">
<h1 style="margin:0 0 10px 0">DPortal CMS {{$LANG.control_panel|ucfirst}}</h1>

<div style="border:2px solid;background:#CCCCCC">
<h5 class="titre">{{$LANG.information|ucfirst}}</h5>
<p style="margin:5px">{{PANEL_MESSAGE}} </p>
</div>
  <div style="clear:both;height:10px"></div>

<div style="border:2px solid;background:#CCCCCC;padding:10px 0 0 0">
<div style="margin:auto;padding:0 3px">
<div class="panel_menu">General</div>
<div class="panel_menu">User and Password</div>
<div class="panel_menu">Sections</div>
<div class="panel_menu">Gallery</div>
<div class="panel_menu">Videos</div>
<div class="panel_menu">Templates & Style</div>
<div class="panel_menu">Backup</div>
</div>
<div style="margin:auto;padding:10px 3px">
{{if $smarty.get.mode == 'general' || empty($smarty.get.mode)}}Site configuration | robots.txt | phpBB configuration | Memcached support
{{elseif $smarty.get.mode == 'sections'}}Edit Create{{/if}} </div>
<div style="clear:both;height:10px"></div>
{{*</div>*}}
{{if $smarty.get.tab == 'general'}}
{{*<div
style="border:2px solid;background:#CCCCCC;text-align:right;margin:10px 0 0 0">*}}
  

<form id="form1" method="post"
action="{{LINK script='panel' section='config:update' argument='?SITE_CONF'}}">

  <div style="text-align:right; margin: 0 20px 0 0;float:left">

  <div>
  <strong>{{$LANG.sitename|ucfirst}}:</strong> <input type="text"
  name="sitename" value="{{$SITENAME}}" style="width:170px" /> </div>

  <div>
  <strong>{{$LANG.sitedesc|ucfirst}}:</strong> <input type="text"
  name="sitedesc" value="{{$SITE_DESCRIPTION}}" style="width:170px" /> </div>
 
  </div>
  
  
  <div style="text-align:right; margin: 0 20px 0 0;float:right">
 
  <div>
  <strong>{{$LANG.admin_email|ucfirst}}Admin email:</strong> <input type="text"
  name="admin_email" value="{{$ADMIN_EMAIL}}" style="width:170px" /> </div>

  <div>
  <strong>{{$LANG.admin_nick|ucfirst}}Admin nick:</strong> <input type="text"
  name="admin_nick" value="{{$ADMIN_NICK}}" style="width:170px" /> </div>
 
  </div>
  
  <div style="display:inline-table">
	<select name="lang" style="width:90px"title="Select language (default, current)">
		<option value="{{$LANGFILES[0].key}}" selected="selected" disabled="disabled">Language</option>
		{{section name="lang" loop=$LANGFILES}}<option value="{{$LANGFILES[lang].key}}">{{$LANGFILES[lang].str}}</option>{{/section}}
	</select>
  </div>
  <div style="text-align:center;display:inline-table;width:290px">
  <p><label><input type="checkbox" name="use_rewrite" value="1" {{if $USE_REWRITE}}checked="checked"{{/if}} />
  {{$LANG.use_canonical_url|ucfirst}} <strong></strong>
  (<strong>mod_rewrite</strong>)</label></p>
  </div>
  <div style="text-align:center">
  <input type="submit" value="    {{$LANG.save|ucfirst}}    " /> </p>
  </div>
  <div>
  <h5 class="titre" style="cursor:pointer" onclick="items(65)">Memcached support</h5>
  <div style="text-align:left;margin:5px" class="hidden" id="item_65">
  
  <span class="titre" style="cursor:pointer" onclick="items(68)"><strong>View description.</strong></span>
    <div class="hidden" id="item_68">
	<p><strong>Memcached</strong> is used to improve performance in high volume Websites, and was designed specially to reduce the Database load in Websites that use DBs.</p>
	<p>To enable Memcached support, please fill the fields with the <strong>Memcached server</strong> ("localhost" by default) and <strong>Mecached port</strong> (11211).</p>
	<p><strong>To disable Memcached support and use the default cache-on-files, leave these fields empty</strong>.</p>
	<p>If you provide incorrect parameters, or your server does'nt have Memcached libraries installed, Memcached support will be disabled.</p>{{$LANG_enable_memcached_preface}}</div>
	
	<div style="text-align:right; margin: 0 20px 0 0">
	<div>
	  <strong>{{$LANG.memcached_server|ucfirst}}Memcached server:</strong> <input type="text"
  name="memcached_server" value="{{$MEMCACHED_SERVER}}" style="width:220px" /><br /><strong>localhost</strong> by default.</div>

  <div>
  <strong>{{$LANG.memcached port|ucfirst}}Memcached port:</strong> <input type="text"
  name="memcached_port" value="{{$MEMCACHED_PORT}}" style="width:220px" /><br /><strong>11211</strong> by default.</div>
  </div>
	
	<p style="text-align:center"><input type="submit" value="    {{$LANG.save|ucfirst}}    " /></p>
	
  </div>
  </div>


  <div>
  <h5 class="titre" style="cursor:pointer" onclick="items(3)">Robots.txt</h5>

  <div style="text-align:left;margin:5px" class="hidden" id="item_3">

  <div>{{$LANG.robotstxt_preface}}</div>

  <div>
  <textarea name="robotstxt" style="width:100%;height:100px" rows="10"
  cols="15">{{if file_exists('robots.txt')}}{{fetch file="robots.txt"}}{{/if}}</textarea></div>

  <p style="text-align:center">
  <input type="submit" value="     {{$LANG.save|ucfirst}}      " name="Submit" /> </p>
  <strong style="cursor:pointer" onclick="items(4)">{{$LANG.note|ucfirst}}
  ({{$LANG.click_to_show}}):</strong> 

  <div id="item_4" class="hidden">
  {{$LANG.robotstxt_warn}}</div>
  </div>
  </div>

  <div>
  <a name="user_password"></a> 

  <h5 class="titre" style="cursor:pointer"
  onclick="items(6)">{{$LANG.user_and_password|ucfirst}} </h5>

  <div id="item_6" class="hidden">

  <div style="cursor:pointer;text-align:center;margin:10px" onclick="items(7)">
  {{$LANG.show_hide_info}}</div>

  <div style="text-align:left;margin:5px" id="item_7" class="hidden">
  {{$LANG.change_pass_warn}} </div>

  <p><strong>{{$LANG.current_username|ucfirst}}:</strong> <input type="text"
  name="curr_user" style="width:220px" /> </p>

  <p><strong>{{$LANG.current_password|ucfirst}}:</strong> <input
  type="password" name="curr_pass" style="width:220px" /> </p>

  <p><strong>{{$LANG.new_username|ucfirst}}:</strong> <input type="text"
  name="username" style="width:220px" /> </p>

  <p><strong>{{$LANG.new_password|ucfirst}}:</strong> <input type="password"
  name="password" style="width:220px" /> </p>

  <p><strong>{{$LANG.repeat_password|ucfirst}}:</strong> <input type="password"
  name="password_repeat" style="width:220px" /> </p>

  <div style="text-align:center;margin:10px">

  <input type="submit" value="     {{$LANG.save|ucfirst}}      " name="Submit" /> </div>
  </div>
  </div>

  <h5 class="titre" onclick="items(8)"
  style="cursor:pointer">{{$LANG.phpbb_integration}}</h5>

  <div id="item_8" class="hidden">

  <div style="cursor:pointer;text-align:center;margin:10px" onclick="items(9)">
  {{$LANG.show_hide_info}}</div>

  <div style="text-align:left;margin:5px" id="item_9" class="hidden">
  {{$LANG.phpbb_int_warn}} </div>

  <p><strong>{{$LANG.phpbb_path}}:</strong> <input type="text" name="phpbb_dir"
  value="{{$PHPBB_DIR}}" style="width:55%" /></p>

  <div style="text-align:center;margin:10px">

  <input type="submit" value="     {{$LANG.save|ucfirst}}      " name="Submit" /> </div>
  </div>
</form>
</div>
{{else}}
<div
style="border:2px solid;background:#CCCCCC;text-align:center;margin:10px 0 0 0">
<a name="manage_sections"></a> 

<h5 class="titre" style="cursor:pointer"
onclick="items(10)">{{$LANG.manage_sections|ucfirst}} </h5>

<div id="item_10">
{{$LANG.sections_warn}} 

<form id="form2" method="post"
action="{{LINK script='panel' section='section:edit' argument='?EDIT'}}">
  <p>
  <select class="list" name="file" onchange="submit();" style="width:90%">
    <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_section_to_edit}}</option>{{section name="sections" loop=$SECTIONS}}
    <option
    value="{{$SECTIONS[sections].name}}">{{$SECTIONS[sections].name|replace:"_":"/"}}
    - {{$SECTIONS[sections].title}}</option>{{/section}}
  </select>
   </p>
</form>
{{* To Delete sections, Sections must be 2 or more. Remember, 'home' can't be
deleted *}} {{if count($SECTIONS) > 1}} 

<form id="form3" method="post"
action="{{LINK script='panel' section='section:delete' argument='?DELETE'}}">
  <p>
  <select class="list" name="filename"
  onchange="if(confirm('{{$LANG.delete_section_warn|ucfirst}}')) return submit()" style="width:90%">
    <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_section_to_delete}}</option>{{section name="sections" loop=$SECTIONS}}{{if $SECTIONS[sections].name != home}}
    <option
    value="{{$SECTIONS[sections].name}}">{{$SECTIONS[sections].name|replace:"_":"/"}}
    - {{$SECTIONS[sections].title}}</option>{{/if}}{{/section}}
  </select>
   </p>
</form>
{{/if}} </div>
<a name="create_section"></a> 

<h5 onclick="items(11)" class="titre"
style="cursor:pointer">{{$LANG.create_section|ucfirst}}</h5>

<div id="item_11" class="hidden">
<p><strong style="cursor:pointer" onclick="items(30)">{{$LANG.note|ucfirst}}
({{$LANG.click_to_show}}):</strong></p>

<div id="item_30" class="hidden" style="text-align:left;padding:0 5px">
{{$LANG.create_section_warn}}</div>

<div style="margin:auto">

<form id="form4" method="post"
action="{{LINK script='panel' section='section:create' argument='?CREATE'}}">

  <div style="text-align:center">

  <select class="list" name="category" style="margin:0 0 10px 0;width:250px">
    <option class="list" selected="selected" disabled="disabled"
    value="">{{$LANG.select_category|ucfirst}}</option>{{section name="categories" loop=$CATEGORIES}}
    <option
    value="{{$CATEGORIES[categories].name}}">{{$CATEGORIES[categories].title}}
    ({{$CATEGORIES[categories].name}})</option>{{/section}}
  </select>
   </div>

  <div style="text-align:right">
  <strong>{{$LANG.section_name|ucfirst}}:</strong> <input type="text"
  name="filename" value="" style="width:250px" /> </div>

  <div style="text-align:right">
  <strong>{{$LANG.title|ucfirst}}:</strong> <input type="text" name="title"
  value="" style="width:250px" /> </div>

  <div style="text-align:center">

  <input type="submit" value="  Create!  " /></div>
</form>
</div>
</div>
<a name="create_category"></a> 

<h5 title="Show/hide editor (click)" onclick="items(52)" class="titre"
style="cursor:pointer">{{$LANG.create_category|ucfirst}}</h5>

<div id="item_52" class="hidden">
<p><strong style="cursor:pointer" onclick="items(55)">{{$LANG.note|ucfirst}}
({{$LANG.click_to_show}}):</strong></p>

<div id="item_55" class="hidden" style="text-align:left;padding:0 5px">
{{$LANG.create_category_warn}}</div>

<div style="margin:auto">

<form id="form50" method="post"
action="{{LINK script='panel' section='category:create' argument='?CREATE_CATEGORY'}}">

  <div style="text-align:right">
  <strong>{{$LANG.category_name|ucfirst}}:</strong> <input type="text"
  name="name" value="" style="width:250px" /> </div>

  <div style="text-align:right">
  <strong>{{$LANG.category_title|ucfirst}}:</strong> <input type="text"
  name="title" value="" style="width:250px" /> </div>

  <div style="text-align:center">

  <input type="submit" value="  Create!  " /></div>
</form>
</div>
</div>
{{if count($CATEGORIES) >= 1}}
<a name="create_category"></a> 

<h5 title="Show/hide editor (click)" onclick="items(102)" class="titre"
style="cursor:pointer">{{$LANG.delete_category|ucfirst}}</h5>

<div id="item_102" class="hidden">

<div style="margin:auto;padding:10px 0 2px 0">

<form id="form50" method="post"
action="{{LINK script='panel' section='category:delete' argument='?DELETE_CATEGORY'}}">

  <select class="list" name="category" style="margin:0 0 10px 0;width:250px" onchange="if(confirm('{{$LANG.delete_category_warn|ucfirst}}')) return submit()">
    <option class="list" selected="selected" disabled="disabled"
    value="">{{$LANG.select_category_to_delete|ucfirst}}</option>{{section name="categories" loop=$CATEGORIES}}
    <option
    value="{{$CATEGORIES[categories].name}}">{{$CATEGORIES[categories].title}}
    ({{$CATEGORIES[categories].name}})</option>{{/section}}
  </select>
</form>
</div>
</div>
{{/if}}
</div>

<div style="border:2px solid;background:#CCCCCC;text-align:center;margin:10px 0 0 0">
<a name="upload_images"></a> 

<h5 class="titre" style="cursor:pointer"
onclick="items(20)">{{$LANG.upload_images_to_a_gallery|ucfirst}}</h5>

<div id="item_20">
<p><strong style="cursor:pointer" onclick="items(32)">{{$LANG.note|ucfirst}}
({{$LANG.click_to_show}}):</strong></p>

<div id="item_32" class="hidden" style="text-align:left;padding:0 5px">
{{$LANG.upload_gallery_preface|ucfirst}}</div>

<form id="form5" method="post"
action="{{LINK script='panel' section='gallery:upload' argument='?UPLOAD_GALLERY'}}"
enctype="multipart/form-data">
  <p>
  <select class="list" name="gallery" style="width:90%">
    <option class="list" selected="selected" disabled="disabled"
    value="">{{$LANG.select_gallery_to_upload}}</option>{{section name="galleries" loop=$GALLERIES}}
    <option
    value="{{$GALLERIES[galleries].file}}">{{$GALLERIES[galleries].file}} -
    {{$GALLERIES[galleries].title}}</option>{{/section}}
  </select>
   </p>

  <p><input type="file" name="images[]" /> <input type="file" name="images[]"
  /> <input type="file" name="images[]" /> <input type="file" name="images[]"
  /> <input type="file" name="images[]" /> </p>

  <p>
  <input type="submit" value="Upload" /></p>
</form>
</div>
<a name="create_gallery"></a> 

<h5 class="titre" style="cursor:pointer"
onclick="items(21)">{{$LANG.create_gallery|ucfirst}}</h5>

<div id="item_21" class="hidden">
<p><strong style="cursor:pointer" onclick="items(33)">{{$LANG.note|ucfirst}}
({{$LANG.click_to_show}}):</strong></p>

<div id="item_33" class="hidden" style="text-align:left;padding:0 5px">
{{$LANG.create_gallery_preface}}</div>

<div style="text-align:right;margin:0 50px 0 0">

<form method="post"
action="{{LINK script='panel' section='gallery:create' argument='?CREATE_GALLERY'}}">

  <div>
  <strong>{{$LANG.name|ucfirst}}:</strong> <input type="text" name="name"
  style="width:250px" /></div>

  <div>
  <strong>{{$LANG.title|ucfirst}}</strong>: <input type="text" name="title"
  style="width:250px" /></div>

  <p style="text-align:center">
  <select style="width:85px" name="max">
    <option class="list" selected="selected"
    disabled="disabled">IMP</option>{{section name='max' loop=$MAX}}
    <option value="{{$MAX[max]}}">{{$MAX[max]}}</option>{{/section}}
  </select>
   
  <input type="submit" value="Create" /> </p>
</form>
</div>
</div>
{{if $smarty.section.galleries.total > 0}} <a name="delete_gallery"></a> 

<h5 class="titre" style="cursor:pointer"
onclick="items(81)">{{$LANG.delete_gallery|ucfirst}}</h5>

<div id="item_81" class="hidden">

<form method="post"
action="{{LINK script='panel' section='gallery:delete' argument='?DELETE_GALLERY'}}">
  <p>
  <select class="list" name="gallery"
  onchange="if(confirm('{{$LANG.delete_category_warn|ucfirst}}')) return submit()">
    <option class="list" selected="selected" disabled="disabled"
    value="">{{$LANG.select_gallery_to_delete|ucfirst}}</option>{{section name="galleries" loop=$GALLERIES}}
    <option
    value="{{$GALLERIES[galleries].file}}">{{$GALLERIES[galleries].file}} -
    {{$GALLERIES[galleries].title}}</option>{{/section}}
  </select>
   </p>
</form>
</div>
{{/if}} </div>

<div
style="border:2px solid;background:#CCCCCC;text-align:center;margin:10px 0 0 0">
<a name="upload_images"></a> 

<h5 class="titre" style="cursor:pointer"
onclick="items(90)">{{$LANG.upload_video|ucfirst}}</h5>

<div id="item_90">
  <form id="form6" method="post"
action="{{LINK script='panel' section='video:upload' argument='?UPLOAD_VIDEO'}}"
enctype="multipart/form-data">
  <p>
  <select class="list" name="playlist" style="width:90%">
    <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_playlist_to_upload}}</option>
    {{section name="playlists" loop=$PLAYLISTS}}
    <option value="{{$PLAYLISTS[playlists].dirname}}">{{$PLAYLISTS[playlists].dirname}} -
    {{$PLAYLISTS[playlists].title}}</option>{{/section}}
  </select>
   </p>

  <p style="text-align:right">{{$LANG.video|ucfirst}}: <input type="file" name="video[]" /><br />
  {{$LANG.hq_version|ucfirst}}: <input type="file" name="video_hq[]" /></p>

  <p><input type="submit" value="{{$LANG.upload|ucfirst}}" /></p>
</form>
</div>
<a name="create_showcase"></a> 

<h5 class="titre" style="cursor:pointer"
onclick="items(91)">{{$LANG.create_playlist|ucfirst}}</h5>

<div id="item_91" class="hidden">
<p><strong style="cursor:pointer" onclick="items(93)">{{$LANG.note|ucfirst}}
({{$LANG.click_to_show}}):</strong></p>

<div id="item_93" class="hidden" style="text-align:left;padding:0 5px">
{{$LANG.create_playlist_preface}}</div>

<div style="text-align:right;margin:0 50px 0 0">

<form method="post"
action="{{LINK script='panel' section='video:create' argument='?CREATE_SHOWCASE'}}">

  <div>
  <strong>{{$LANG.name|ucfirst}}:</strong> <input type="text" name="name"
  style="width:250px" /></div>

  <div>
  <strong>{{$LANG.title|ucfirst}}</strong>: <input type="text" name="title"
  style="width:250px" /></div>

  <p style="text-align:center">
  <input type="submit" value="Create" /> </p>
</form>
</div>
</div>

<a name="create_showcase"></a> 

<h5 class="titre" style="cursor:pointer"
onclick="items(94)">{{$LANG.delete_playlist|ucfirst}}</h5>

<div id="item_94" class="hidden">

<div style="text-align:center;margin:0">

<form method="post"
action="{{LINK script='panel' section='video:delete_playlist' argument='?DELETE_PLAYLIST'}}">

<p>
  <select class="list" name="playlist" onchange="if(confirm('{{$LANG.delete_playlist_warn|ucfirst}}')) return submit()">
    <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_playlist_to_delete|ucfirst}}</option>
    {{section name="playlists" loop=$PLAYLISTS}}
    <option value="{{$PLAYLISTS[playlists].dirname}}">{{$PLAYLISTS[playlists].dirname}} -
    {{$PLAYLISTS[playlists].title}}</option>{{/section}}
  </select>
   </p>
   
</form>
</div>
</div>

</div>

<div
style="border:2px solid;background:#CCCCCC;text-align:center;margin:10px 0 0 0">
<a name="create_backup"></a> 

<h5 onclick="items(22)" class="titre"
style="cursor:pointer">{{$LANG.create_backup}}</h5>

<div id="item_22" style="text-align:left;padding:7px">

<div>
{{$LANG.create_backup_preface}}</div>

<form method="post"
action="{{LINK script='panel' section='backup:create' argument='?BACKUP'}}">

  <div style="text-align:center;">
  <label><input type="checkbox" checked="checked" disabled="disabled"/>{{$LANG.sections|ucfirst}}</label>
  <label><input type="checkbox" name="mode[blog]" value="true" />{{$LANG.blog|ucfirst}}</label>
  <label><input type="checkbox" name="mode[config]" value="true" />{{$LANG.config|ucfirst}}</label>
  <label><input type="checkbox" name="mode[templates]" value="true" />{{$LANG.templates|ucfirst}}</label>

  </div>

  <div style="text-align:center;margin:10px 0 0 3px">

  <input type="submit" value="  Perform  " /> </div>
</form>

<div style="clear:both">
</div>
</div>
{{if $BACKUPS != null}}
<h5 onclick="items(23)" class="titre"
style="cursor:pointer">{{$LANG.download_backup|ucfirst}}</h5>

<div id="item_23" class="hidden">

<div>
{{$LANG.download_backup_preface|ucfirst}}</div>

<form method="post"
action="{{LINK script='panel' section='backup:download' argument='?DOWNLOAD_BACKUP'}}">
  <p>
  <select class="list" name="filename" onchange="submit()">
    <option class="list" selected="selected" disabled="disabled">Select a
    Backup File</option>{{section name="backups" loop="$BACKUPS}}
    <option
    value="{{$BACKUPS[backups]}}">{{$BACKUPS[backups]}}</option>{{sectionelse}}
    <option
    disabled="disabled">{{$LANG.no_backups|ucfirst}}</option>{{/section}}
  </select>
   </p>
</form>
</div>
{{/if}}
<a name="restore_backup"></a> 

<h5 onclick="items(24)" class="titre"
style="cursor:pointer">{{$LANG.restore_backup}}</h5>

<div id="item_24">

<div>
{{$LANG.restore_backup_preface}}</div>

<form method="post"
action="{{LINK script='panel' section='backup:restore' argument='?RESTORE'}}"
enctype="multipart/form-data">
  <p><input name="filename" type="file" /></p>

  <p>
  <input type="submit" value="  Upload  " /></p>
</form>
</div>
{{if $BACKUPS != null}}
<h5 onclick="items(25)" class="titre"
style="cursor:pointer">{{$LANG.delete_backups|ucfirst}}</h5>

<div id="item_25" class="hidden">

<div style="margin:5px;text-align:left">
{{$LANG.delete_backup_preface}}</div>

<form method="post"
action="{{LINK script='panel' section='backup:delete' argument='?DELETE_BACKUPS'}}">
  <p><label><input name="no_last" type="checkbox" checked="checked"
  value="true" />All except last</label> 
  <input type="submit" value="  {{$LANG.delete|ucfirst}}  " /></p>
</form>
</div>
{{/if}}
</div>

<div
style="border:2px solid;background:#CCCCCC;text-align:center;margin:10px 0 0 0">
<a name="edit_templates"></a> 

<h5 onclick="items(14)" class="titre" style="cursor:pointer"><a
name="edit_templates"></a>{{$LANG.edit_templates_manually|ucfirst}}</h5>

<div id="item_14" style="padding:5px;">

<div>
{{$LANG.edit_templates_preface}}</div>

<form id="form7" method="get" action="{{LINK script='panel'}}">
  <p>
  <select class="list" name="template_file" onchange="submit();"
  style="width:90%">
    <option class="list" selected="selected"
    disabled="disabled">{{$LANG.select_template_to_edit|ucfirst}}</option>{{section name="templates" loop=$TEMPLATES}}
    <option
    value="{{$TEMPLATES[templates].name}}">{{$TEMPLATES[templates].name}}</option>{{/section}}
  </select>
   </p>
</form>
</div>
<a name="sidebar"></a> 

<h5 onclick="items(15)" class="titre"
style="cursor:pointer">{{$LANG.sidebar_content_edit|ucfirst}}</h5>

<div id="item_15" class="hidden">

<form
action="{{LINK script='panel' section='template:save' argument='?TEMPLATE_SAVE'}}"
method="post">

  <div>
  <textarea name="content" cols="10" rows="10" style="width:98%">{{fetch file=$SIDEBAR_TEMPLATE}}
        </textarea></div>

  <p><input type="hidden" name="file" value="sidebar_c.tpl" /> 
  <input type="submit" value="    {{$LANG.save|ucfirst}}    " /></p>
</form>
</div>

<h5 class="titre" onclick="items(16)" style="cursor:pointer"><a
name="footer"></a>{{$LANG.footer_content_edit|ucfirst}}</h5>

<div id="item_16" class="hidden">

<form
action="{{LINK script='panel' section='template:save' argument='TEMPLATE_SAVE'}}"
method="post">

  <div>
  <textarea name="content" cols="10" rows="10" style="width:98%">{{fetch file=$FOOTER_TEMPLATE}}
        </textarea></div>

  <p><input type="hidden" name="file" value="footer_c.tpl" /> 
  <input type="submit" value="    {{$LANG.save|ucfirst}}    " /></p>
</form>
</div>
</div>
{{/if}}
</div>
</body>
</html>
