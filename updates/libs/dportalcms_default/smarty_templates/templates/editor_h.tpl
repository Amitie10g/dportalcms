<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$LANG.editing|ucfirst}} "{{$TITLE}}{{if $TITLE == null && $smarty.get.title != null}}{{$smarty.get.title}}{{/if}}" :: {{$SITENAME}} (editor)</title>

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

<form id="form1" method="post" action="{{LINK script='edit' page='SAVE' argument='?SAVE'}}">
  <div style="padding:0 10px;margin:0;background:#DDDDFF">
