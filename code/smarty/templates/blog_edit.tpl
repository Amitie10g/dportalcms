<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{if $NEW}}{{$LANG.publish_new_entry|ucfirst}}{{else}}{{$LANG.edit|ucfirst}} {{$LANG.entry}}{{/if}} :: {{$SITENAME}}</title>

<link rel="stylesheet" type="text-css" href="{{$smarty.const.DPORTAL_PATH}}/default.css" />

{{if !isset($smarty.get.noWYSIWYG)}}
<!-- TinyMCE -->
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/editor/tiny_mce.js"></script>
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/editor/tiny_mce_full.js"></script>
<!-- /TinyMCE -->
{{/if}}

</head>
<body style="background:#EEEEFF;"{{if $smarty.session.title_empty}} onload="return alert('{{$LANG.title_no_empty|ucfirst}}');"{{/if}}{{if $smarty.session.content_empty}} onload="return alert('{{$LANG.content_no_empty}}');"{{/if}}>

<noscript>
<div style="font-family:Arial,sans-serif"><em>{{$LANG.enable_javascript.wysiwyg}}<strong></strong></em></div>
</noscript>

<form id="form1" method="post" action="{{LINK script='blog_save'}}">
  <div style="padding:0 10px;margin:0;background:#DDDDFF">
    <p style="margin:3px 0 -2px 0;padding:3px 0;margin:3px 0 0 0;font-family:Verdana,Arial,sans-serif;font-size:14px">
    
    <span style="font-size:18px !important;vertical-align:middle">{{$LANG.title|ucfirst}}: 
    <input name="title" type="text" class="mceSelectList" style="width:150px;margin:0;font-size:16px !important;{{if $smarty.session.title_empty}}background:#FF5555;{{/if}}" tabindex="1" value="{{$TITLE}}"  title="{{$LANG.entry_title_title|ucfirst}}" />&nbsp; {{$LANG.tags|ucfirst}}:   
  <input name="tags" type="text" class="mceSelectList" style="width:150px;margin:0;font-size:14px !important" tabindex="2" value="{{$TAGS}}" title="{{$LANG.entry_tags_title|ucfirst}}" />
  <a href="javascript:tinyMCE.execInstanceCommand('mce_editor_0','mceSave');">{{$LANG.send|ucfirst}}</a>&nbsp;|
  <a href="{{if isset($smarty.get.NEW)}}{{LINK script='blog'}}
  {{else}}{{LINK section="$NAME script='blog_entry'}}
  {{/if}}"onclick="return confirm('{{$LANG.sure_to_cancel|ucfirst}}');">{{$LANG.cancel|ucfirst}}</a></span></p>
</div>
	<p style="margin:0">
		<textarea name="content" cols="80" rows="30" id="elm1" style="width: 100%;font-size:20px !important" tabindex="3">{{if $BLOG_ENTRY}}{{fetch file=$FILE}}{{/if}}{{if $NEW}}{{$CONTENT}}{{/if}}</textarea>
	</p>
{{if $NEW}}
<p style="margin:0"><input type="hidden" name="new" value="true" /></p>
{{else}}
<p style="margin:0"><input type="hidden" name="id" value="{{$ID}}" /></p>
<p style="margin:0"><input type="hidden" name="name" value="{{$NAME}}" /></p>
{{/if}}
</form>
</body>
</html>