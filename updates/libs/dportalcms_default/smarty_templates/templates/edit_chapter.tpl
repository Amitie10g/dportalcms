<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$LANG.editing|ucfirst}} {{$BOOK_TITLE}}, {{$LANG.chapter}} {{$CHAPTER}}: "{{$CHAPTER_TITLE}}{{if $CHAPTER_TITLE == null && $smarty.get.title != null}}{{$smarty.get.title}}{{/if}}" :: {{$SITENAME}} (editor)</title>

<link rel="stylesheet" type="text-css" href="{{$smarty.const.DPORTAL_PATH}}/default.css" />

{{if !isset($smarty.get.noWYSIWYG)}}
<!-- TinyMCE -->
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/editor/tiny_mce.js"></script>
<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/editor/tiny_mce_full.js"></script>
<!-- /TinyMCE -->

{{/if}}

</head>
<body style="background:#EEEEFF;"{{if $smarty.session.title_empty}} onload="return alert('{{$LANG.title_no_empty|ucfirst}}');"{{elseif $smarty.session.content_empty}} onload="return alert('{{$LANG.content_no_empty|ucfirst}}');"{{/if}}>

{{if !isset($smarty.get.noWYSIWYG)}}
<noscript><div style="font-family:Arial,sans-serif"><em>{{$LANG.enable_javascript_wysiwyg}}</em></div></noscript>
{{/if}}

<form id="form1" name="form1" method="post" action="{{LINK script='books' page='UPDATE_CHAPTER'}}">
  <div style="padding:0 10px;margin:0;background:#DDDDFF">
<p style="margin:3px 0 -2px 0;padding:3px 0;margin:3px 0 0 0;font-family:Verdana,Arial,sans-serif;font-size:14px">
<img src="{{$smarty.const.DPORTAL_PATH}}/editor/themes/advanced/img/separator.gif" style="position:absolute;padding:5px 0 0 0;margin:0 0 0 -2px" />&nbsp;{{$LANG.title|ucfirst}}: 
  <input style="width:200px;margin:0;font-size:14px" class="mceSelectList" type="text" name="title" value="{{$CHAPTER_TITLE}}{{if $CHAPTER_TITLE == null && $smarty.get.title != null}}{{$smarty.get.title}}{{/if}}" /> 
  <img src="{{$smarty.const.DPORTAL_PATH}}/editor/themes/advanced/images/separator.gif" style="position:absolute;padding:0 1px" />&nbsp;
  <span><span style="font-weight:bold">{{$LANG.book|ucfirst}}: </span><span title="{{$BOOK_TITLE}} ({{$BOOK}})">{{$BOOK_TITLE|truncate:'40':'...'}}</span> &nbsp;&nbsp;<img src="{{$smarty.const.DPORTAL_PATH}}/editor/themes/advanced/img/separator.gif" style="position:absolute;padding:5px 0 0 0;margin:0 0 0 -2px" />&nbsp;
 </span>
  <span><span style="font-weight:bold">{{$LANG.chapter|ucfirst}}: </span>{{$CHAPTER}}&nbsp;&nbsp;<img src="{{$smarty.const.DPORTAL_PATH}}/editor/themes/advanced/img/separator.gif" style="position:absolute;padding:5px 0 0 0;margin:0 0 0 -2px" />&nbsp;
 </span>
  <a id="elm1_save" href="javascript:;">{{$LANG.save|ucfirst}}</a>&nbsp;<img src="{{$smarty.const.DPORTAL_PATH}}/editor/themes/advanced/images/separator.gif" style="position:absolute;padding:0 1px" />&nbsp;
  {{if !isset($smarty.get.NEW)}}<a href="{{LINK script='chapter' page=$BOOK section=$CHAPTER}}" onclick="return confirm('{{$LANG.confirm_exit_editor|ucfirst}}');">{{$LANG.cancel|ucfirst}}</a>{{else}}<span title="{{$LANG.cant_cancel_title}}">{{$LANG.cant_cancel}}</span>{{/if}}
  </p>
</div>
	<p style="margin:0"><textarea id="elm1" name="content" rows="30" cols="80" style="width: 100%">
{{if !isset($smarty.get.NEW)}}{{if $smarty.session.CONTENT != null}}{{$smarty.session.CONTENT}}{{else}}{{fetch2 file=$FILENAME_FULL}}{{/if}}{{/if}}
	</textarea></p>
<p style="margin:0"><input type="hidden" name="book" value="{{$BOOK}}" /></p>
<p style="margin:0"><input type="hidden" name="chapter" value="{{$CHAPTER}}" /></p>
</form>
</body>
</html>