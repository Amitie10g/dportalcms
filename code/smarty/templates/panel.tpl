<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$LANG.control_panel|ucfirst}} :: {{$SITENAME}}</title>
<link rel="stylesheet" type="text/css" href="{{$smarty.const.DPORTAL_PATH}}/default.css" />

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/external_links.js"></script>

<script type="text/javascript">
      <!--
      function items(id){
         var obj = document.getElementById('item_' + id)
         if(obj.style.display == 'block') obj.style.display = 'none'
         else obj.style.display = 'block'
      }
	  
      //-->
</script>
      
	<style type="text/css">
       .titleItem{
          cursor: pointer;
          font-weight: bold;
          text-align:center;
       }
       .hidden{
          font-weight: normal;
          margin:0;
          padding:0;
          display:none;
		  background:#cccccc;
		  border:none;
       }
       .content p{
          margin: 3px;
       }
	</style>
</head>
<body>

<div style="width:410px;margin:auto">

<h1>DPortal CMS {{$LANG.control_panel|ucfirst}}</h1>

<div style="border:2px solid;background:#CCCCCC">

<h5 class="titre">{{$LANG.information|ucfirst}}</h5>

<p style="margin:5px">

{{PANEL_MESSAGE}}

</p>
</div>

<div style="border:2px solid;background:#CCCCCC;margin:10px 0 0 0">

<h5 class="titre">{{$LANG.goto|ucfirst}}...</h5>
<div style="width:48%;float:left;text-align:right;padding:5px 2px;margin:auto"><a href="#options">{{$LANG.general_options|ucfirst}}</a></div>

<div style="width:48%;float:right;text-align:left;padding:5px 2px"><a href="#user_password" onclick="items(6)">{{$LANG.change_password|ucfirst}}</a></div>

<div style="clear:both"></div>

<div style="width:48%;float:left;text-align:right;padding:5px 2px"><a href="#manage_sections" onclick="items(10)">{{$LANG.manage_sections|ucfirst}}</a></div>

<div style="width:48%;float:right;text-align:left;padding:5px 2px"><a href="#create_section" onclick="items(11)">{{$LANG.create_section|ucfirst}}</a></div>

<div style="clear:both"></div>

<div style="width:48%;float:left;text-align:right;padding:5px 2px"><a href="#upload_images" onclick="items(20)">{{$LANG.upload_images|ucfirst}}</a></div>

<div style="width:48%;float:right;text-align:left;padding:5px 2px"><a href="#create_gallery" onclick="items(21)">{{$LANG.create_gallery|ucfirst}}</a></div>

<div style="clear:both"></div>

<div style="width:48%;float:left;text-align:right;padding:5px 2px"><a href="#create_backup" onclick="items(22)">{{$LANG.create_backup|ucfirst}}</a></div>

<div style="width:48%;float:right;text-align:left;padding:5px 2px"><a href="#restore_backup" onclick="items(24)">{{$LANG.restore_backup|ucfirst}}</a></div>

<div style="clear:both"></div>

<div style="width:48%;float:left;text-align:right;padding:5px 2px"><a href="#edit_templates" onclick="items(14)">{{$LANG.edit_templates|ucfirst}}</a></div>

<div style="width:48%;float:right;text-align:left;padding:5px 2px"><a href="#sidebar" onclick="items(15)">{{$LANG.manage_sidebar|ucfirst}}</a></div>

<div style="clear:both;height:10px"></div>

<div style="width:48%;float:center;text-align:center;padding:5px 2px;margin:auto"><a href="{{LINK section='home' argument='?section='}}">{{$LANG.return_to_index|ucfirst}}  =&gt;</a></div>

<div style="clear:both"></div>

<div class="cleaner"></div>
<div style="text-align:center;margin:10px">
<a href="{{LINK script='panel' section='clear_cache' argument='?CLR_CACHE'}}">{{$LANG.clear_all_cache|ucfirst}}</a>
</div>
</div>

<div style="border:2px solid;background:#CCCCCC;text-align:right;margin:10px 0 0 0">
<a name="options"></a>
<h5 class="titre">{{$LANG.general_options|ucfirst}}</h5>
<div style="padding:10px 10px 5px 10px;text-align:center"><span onclick="items(1)" title="Show/hide information" style="cursor:pointer"><strong>{{$LANG.server_signature|ucfirst}}</strong></span></div>
<div id="item_1" class="hidden" style="padding:10px;text-align:center">{{$smarty.server.SERVER_SIGNATURE}}</div>

<div style="padding:5px 10px 10px 10px;text-align:center"><a href="{{LINK script='panel' section='phpinfo' argument='?PHPINFO'}}" rel="external">{{$LANG.view|ucfirst}} phpinfo()</a></div>

<hr style="margin:0 0 5px 0" />

<form id="form1" method="post" action="{{LINK script='panel' section='config:update' argument='?SITE_CONF'}}">
<div style="text-align:right; margin: 0 20px 0 0">
<div>
<strong>{{$LANG.sitename|ucfirst}}:</strong> 
<input type="text" name="sitename" value="{{$SITENAME}}" style="width:220px" />
</div>

<div>
<strong>{{$LANG.sitedesc}}:</strong> 
<input type="text" name="sitedesc" value="{{$SITE_DESCRIPTION}}"  style="width:220px" />
</div>
</div>

<div style="margin:0 0 10px 180px">
<em class="desc">{{$LANG.a_clear_dscription|ucfirst}}</em>
</div>

<div style="float:center;text-align:center">
  <p><label>
  <input type="checkbox" name="use_rewrite" {{if $USE_REWRITE}}checked="checked"{{/if}} value="true" />
  {{$LANG.use_canonical_url|ucfirst}} <strong></strong> (<strong>mod_rewrite</strong>)</label>
  </p>

  <p><input type="submit" name="Submit" value="    Save    " /> </p>

  <div style="text-align:left !important;margin:5px"><span style="cursor:pointer;font-weight:bold" onclick="items(2)">{{$LANG.note|ucfirst}} ({{$LANG.click_to_show}}):</span>
    <div id="item_2" class="hidden">{{$LANG.canonical_warn}}</div>
  </div>
  
</div>

<div>
	<h5 class="titre" style="cursor:pointer" onclick="items(3)">Robots.txt</h5>
	<div style="text-align:left;margin:5px" class="hidden" id="item_3">
		<div>{{$LANG.robotstxt_preface}}</div>
		<p><textarea name="robotstxt" style="width:100%;height:100px" rows="10" cols="15">{{if file_exists('robots.txt')}}{{fetch file="robots.txt"}}{{/if}}</textarea></p>

		<p style="text-align:center"><input type="submit" name="Submit" value="     Save      " /> </p>

		<p><strong style="cursor:pointer" onclick="items(4)">{{$LANG.note|ucfirst}} ({{$LANG.click_to_show}}):</strong>
		<div id="item_4" class="hidden">{{$LANG.robotstxt_warn}}</div>
	</div>

</div>

<div>
<a name="user_password"></a>
<h5 class="titre" style="cursor:pointer" onclick="items(6)">{{$LANG.user_and_password|ucfirst}} </h5>

<div id="item_6" class="hidden">
<div style="cursor:pointer;text-align:center;margin:10px" onclick="items(7)">{{$LANG.show_hide_info}}</div>
<div style="text-align:left;margin:5px" id="item_7" class="hidden">
<p>{{$LANG.change_pass_warn}}</p>

</div>

<p><strong>{{$LANG.current_username|ucfirst}}:</strong> 
  <input type="text" name="curr_user"  style="width:220px" />
</p>

<p><strong>{{$LANG.new_username|ucfirst}}:</strong> 
  <input type="text" name="username"  style="width:220px" />
</p>
<p><strong>{{$LANG.new_password|ucfirst}}:</strong> 
  <input type="password" name="password"  style="width:220px" />
</p>
<p><strong>{{$LANG.repeat_password|ucfirst}}:</strong> 
  <input type="password" name="password_repeat" style="width:220px" />
</p>

<div style="text-align:center;margin:10px">
<input type="submit" name="Submit" value="     Save      " /> 
</div>
</div>
</div>

<h5 class="titre" onclick="items(8)" style="cursor:pointer">{{$LANG.phpbb_integration}}</h5>
<div id="item_8" class="hidden">
<div style="cursor:pointer;text-align:center;margin:10px" onclick="items(9)">{{$LANG.show_hide_info}}</div>
<div style="text-align:left;margin:5px" id="item_9" class="hidden">
<p>{{$LANG.phpbb_int_warn}}</p>

</div>

<p><strong>{{$LANG.phpbb_path}}:</strong> 
  <input type="text" name="phpbb_dir" value="{{$PHPBB_DIR}}" style="width:55%" /></p>
<div style="text-align:center;margin:10px">
<input type="submit" name="Submit" value="     Save      " /> 
</div>
</div>       
</form>

</div>


<div style="border:2px solid;background:#CCCCCC;text-align:center;margin:10px 0 0 0">
<a name="manage_sections"></a>
<h5 class="titre" style="cursor:pointer" onclick="items(10)">{{$LANG.manage_sections}} </h5>

<div id="item_10">


<p>{{$LANG.sections_warn}}</p>

<form id="form2" method="get" action="{{LINK script='edit'}}">
    <p><select name="file" onchange="submit();">
      <option selected="selected" disabled="disabled">Select section to Edit</option>
{{section name="item" loop=$SECTIONS}}
      <option value="{{$SECTIONS[item].name}}">{{$SECTIONS[item].name}} - {{$SECTIONS[item].title}}</option>
{{/section}}
    </select></p>
</form>

{{* To Delete sections, Sections must be 2 or more. Remember, 'home' can't be deleted *}}
{{if count($SECTIONS) > 1}}
<form id="form3" method="post" action="{{LINK script='panel' section='section:delete' argument='?DELETE'}}">
    <p><select name="filename" onchange="if(confirm('{{$LANG.delete_entry_warn|ucfirst}}')) return submit()">
      <option selected="selected" disabled="disabled">Select Section to delete</option>
{{section name="item" loop=$SECTIONS}}
     {{if $SECTIONS[item].name != home}}<option value="{{$SECTIONS[item].name}}">{{$SECTIONS[item].name}} - {{$SECTIONS[item].title}}</option>{{/if}}
{{/section}}
    </select></p>
</form>
{{/if}}

</div>

<a name="create_section"></a>
<h5 title="Show/hide editor (click)" onclick="items(11)" class="titre" style="cursor:pointer">{{$LANG.create_section|ucfirst}}</h5>
<div id="item_11" class="hidden">

<p><strong style="cursor:pointer" onclick="items(30)">{{$LANG.note|ucfirst}} ({{$LANG.click_to_show}}):</strong></p>
<div id="item_30" class="hidden" style="text-align:left;padding:0 5px">{{$LANG.create_section_warn}}</div>

<p><strong style="cursor:pointer" onclick="items(31)">{{$LANG.about_subdirs|ucfirst}}</strong></p>
<div id="item_31" class="hidden" style="text-align:left;padding:0 5px">{{$LANG.create_section_warn}}</div>

<div style="float:center;margin:auto">
<form id="form4" method="post" action="{{LINK script='panel' section='section:create' argument='?CREATE'}}">
<div style="text-align:right">
<strong>{{$LANG.section_name|ucfirst}}:</strong> 
<input type="text" name="filename" value="" style="width:250px" />
</div>
<div style="text-align:right">	  
<strong>{{$LANG.title|ucfirst}}:</strong> 
<input type="text" name="title" value=""  style="width:250px" />
</div>
<div style="text-align:center"><Input type="submit" value="  Create!  " /></div>
</form>
</div>
</div>
</div>

<div style="border:2px solid;background:#CCCCCC;text-align:center;margin:10px 0 0 0">
<a name="upload_images"></a>
<h5 class="titre" style="cursor:pointer" onclick="items(20)">{{$LANG.upload_images_to_a_gallery|ucfirst}}</h5>
<div id="item_20">

<p><strong style="cursor:pointer" onclick="items(32)">{{$LANG.note|ucfirst}} ({{$LANG.click_to_show}}):</strong></p>
<div id="item_32" class="hidden" style="text-align:left;padding:0 5px">{{$LANG.upload_gallery_preface|ucfirst}}</div>

<form id="form2" method="post" action="{{LINK script='panel' section='gallery:upload' argument='?UPLOAD_GALLERY'}}" enctype="multipart/form-data">
<p><select name="gallery">
      <option selected="selected" disabled="disabled">Select gallery to Upload</option>
{{section name="item" loop=$GALLERIES}}
      <option name="gallery" value="{{$GALLERIES[item].file}}">{{$GALLERIES[item].file}} - {{$GALLERIES[item].title}}</option>
{{/section}}
    </select></p>
	
	<input type="file" name="images[]" />
	<input type="file" name="images[]" />
	<input type="file" name="images[]" />
	<input type="file" name="images[]" />
	<input type="file" name="images[]" />

	<p><input type="submit" value="Upload" /></p>
</form>
</div>

<a name="create_gallery"></a>
<h5 class="titre" style="cursor:pointer" onclick="items(21)">{{$LANG.create_gallery|ucfirst}}</h5>
<div id="item_21" class="hidden">

<p><strong style="cursor:pointer" onclick="items(33)">{{$LANG.note|ucfirst}} ({{$LANG.click_to_show}}):</strong></p>
<div id="item_33" class="hidden" style="text-align:left;padding:0 5px">{{$LANG.create_gallery_preface}}</div>

<div style="text-align:right;margin:0 50px 0 0">
<form method="post" action="{{LINK script='panel' section='gallery:create' argument='?CREATE_GALLERY'}}">

<div><strong>{{$LANG.name|ucfirst}}:</strong> 
		<input type="text" name="name" style="width:250px" /></div>
		
	<div><strong>{{$LANG.title|ucfirst}}</strong>:
	  <input type="text" name="title" style="width:250px" /></div>
	  <p style="text-align:center">
			<select name="max">
			<option selected="selected" disabled="disabled">IMP</option>
{{section name='max' loop=$MAX}}
			<option value="{{$MAX[max]}}">{{$MAX[max]}}</option>
{{/section}}
		</select>
		<input type="submit" value="Create" />
		</p>
</form>

</div>
</div>
</div>


<div style="border:2px solid;background:#CCCCCC;text-align:center;margin:10px 0 0 0">
<a name="create_backup"></a>
<h5 onclick="items(22)" class="titre" style="cursor:pointer">{{$LANG.create_backup}}</h5>
<div id="item_22" style="text-align:left;padding:7px">
<div>{{$LANG.create_backup_preface}}</div>

<form method="post" action="{{LINK script='panel' section='backup:create' argument='?BACKUP'}}">

<div style="float:center;text-align:center;">

<label><input type="checkbox" disabled="disabled" checked="checked" />Sections</label>

<label><input type="checkbox" name="mode[blog]" value="true" />Blog</label>

<label><input type="checkbox" name="mode[config]" value="true" />Config</label>

<label><input type="checkbox" name="mode[templates]" value="true" />
Templates</label>
</div>
<div style="float:center;text-align:center;margin:10px 0 0 3px">
<input type="submit" value="  Perform  " />
</div>
</form>
<div style="clear:both"></div>
</div>


<h5 onclick="items(23)" class="titre" style="cursor:pointer">{{$LANG.download_backup|ucfirst}}</h5>
<div id="item_23" class="hidden">

<div>{{$LANG.download_backup_preface|ucfirst}}</div>

<form method="post" action="{{LINK script='panel' section='backup:download' argument='?DOWNLOAD_BACKUP'}}">

<p><select name="filename" onchange="submit()">
	<option selected="selected" disabled="disabled"*>Select a Backup File</option>
{{section name="backups" loop="$BACKUPS}}
	<option value="{{$BACKUPS[backups]}}">{{$BACKUPS[backups]}}</option>
{{sectionelse}}<option disabled="disabled">{{$LANG.no_backups|ucfirst}}</option>
{{/section}}
</select></p>
</form>
</div>

<a name="restore_backup"></a>
<h5 onclick="items(24)" class="titre" style="cursor:pointer">{{$LANG.restore_backup}}</h5>
<div id="item_24">

<div>{{$LANG.restore_backup_preface}}</div>

<form method="post" action="{{LINK script='panel' section='backup:restore' argument='?RESTORE'}} enctype="multipart/form-data">
<p><input name="filename" type="file" /></p>
<p><input type="submit" value="  Upload  " /></p>
</form>
</div>


<h5 onclick="items(25)" class="titre" style="cursor:pointer">{{$LANG.delete_backups|ucfirst}}</h5>
<div id="item_25" class="hidden">
<div style="margin:5px;text-align:left">{{$LANG.delete_backup_preface}}</div>
<form method="post" action="{{LINK script='panel' section='backup:delete' argument='?DELETE_BACKUPS'}}">
<label><input name="no_last" type="checkbox" value="true" checked />All except last</label>
<input type="submit" value="  {{$LANG.delete|ucfirst}}  " />
</form>

</div>
</div>

<div style="border:2px solid;background:#CCCCCC;text-align:center;margin:10px 0 0 0">
<a name="edit_templates"></a>
<h5 onclick="items(14)" class="titre" style="cursor:pointer"><a name="edit_templates"></a>{{$LANG.edit_templates_manually|ucfirst}}</h5>
<div id="item_14" style="padding:5px;">

  <div>{{$LANG.edit_templates_preface}}</div>
  <form id="form7" method="get" action="{{LINK script='panel'}}">
    <p><select name="template_file" onchange="submit();" style="width:70%">
      <option selected="selected" disabled="disabled">Select a Template to edit</option>
{{section name="templates" loop=$TEMPLATES}}
      <option value="{{$TEMPLATES[templates].name}}">{{$TEMPLATES[templates].name}}</option>
{{/section}}
    </select></p>
</form>
</div>

<a name="sidebar"></a>
<h5 onclick="items(15)" class="titre" style="cursor:pointer">{{$LANG.sidebar_content_edit|ucfirst}}</h5>
<div id="item_15" class="hidden">
<form action="{{LINK script='panel' section='template:save' argument='?TEMPLATE_SAVE'}}" method="post">
<textarea name="content" cols="10" rows="10" style="width:98%">
{{fetch file=$SIDEBAR_TEMPLATE}}
</textarea>
<input type="hidden" name="file" value="sidebar_c.tpl" />
<input type="submit" value="    Save    " />
</form>
</div>

<h5 class="titre" onclick="items(16)" style="cursor:pointer"><a name="footer"></a>{{$LANG.footer_content_edit|ucfirst}}</h5>
<div id="item_16" class="hidden">
<form action="{{LINK script='panel' section='template:save' argument='TEMPLATE_SAVE'}}" method="post">

<textarea name="content" cols="10" rows="10" style="width:98%">
{{fetch file=$FOOTER_TEMPLATE}}
</textarea>
<input type="hidden" name="file" value="footer_c.tpl" />
<input type="submit" value="    Save    " />
</form>
</div>
</div>
</div>

</div>
</body>
</html>
